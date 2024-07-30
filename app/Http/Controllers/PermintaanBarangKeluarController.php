<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\PermintaanBarangKeluar;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanBarangKeluarController extends Controller
{

	public function index(Request $request)
	{
		$search = $request->input('search');

		$data = DB::table('permintaan_barang_keluar')
        ->leftJoin('customer', 'permintaan_barang_keluar.customer_id', '=', 'customer.id')
        ->leftJoin('barang_masuk', 'permintaan_barang_keluar.barangmasuk_id', '=', 'barang_masuk.id')
        ->leftJoin('barang', 'barang_masuk.barang_id', '=', 'barang.id')
        ->leftJoin('jenis_barang', 'barang.jenis_barang_id', '=', 'jenis_barang.id')
        ->leftJoin('supplier', 'barang_masuk.supplier_id', '=', 'supplier.id')
        ->leftJoin('keperluan', 'permintaan_barang_keluar.keperluan_id', '=', 'keperluan.id')
        ->select('permintaan_barang_keluar.*', 'barang_masuk.serial_number as serial_number', 'customer.nama as nama_customer', 'barang.nama as nama_barang', 'keperluan.nama as nama_keperluan', 'jenis_barang.nama as nama_jenis_barang', 'supplier.nama as nama_supplier')
        ->selectRaw("DATE_FORMAT(permintaan_barang_keluar.tanggal, '%d %M %Y') as formatted_tanggal")
        ->when($search, function ($query) use ($search) {
            return $query->where('permintaan_barang_keluar.barangmasuk_id', 'like', '%' . $search . '%')
                ->orWhere('barang.nama', 'like', '%' . $search . '%')
                ->orWhere('customer.nama', 'like', '%' . $search . '%')
                ->orWhere('keperluan.nama', 'like', '%' . $search . '%')
                ->orWhere('permintaan_barang_keluar.serial_number', 'like', '%' . $search . '%')
                ->orWhere('jenis_barang.nama', 'like', '%' . $search . '%')
                ->orWhere('supplier.nama', 'like', '%' . $search . '%');
        })
        ->orderBy('permintaan_barang_keluar.tanggal', 'asc')
        ->paginate(7);

		$data->getCollection()->transform(function ($item) {
			$item->tanggal = \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMMM YYYY');
			return $item;
		});

        return view('permintaanbarangkeluar.index', compact('data'));
	}

	public function create($id = null)
	{
        $barangMasuk = null;
		$jenis_barang_id = null;
		$barangbyjenis = null;
		$jenis_barang = DB::table('jenis_barang')->select('id', 'nama')->orderBy('nama', 'asc')->get();
		$barang = DB::table('barang')
			->join('jenis_barang', 'barang.jenis_barang_id', '=', 'jenis_barang.id')
			->select('barang.id', 'barang.nama', 'jenis_barang.nama as jenis_barang_nama')
			->orderBy('jenis_barang.nama', 'asc')
			->orderBy('barang.nama', 'asc')			
			->get();

		if ($id !== null) {
			$barangMasuk = DB::table('barang_masuk')->where('id', $id)->first();
			$jenis_barang_id = DB::table('barang')
				->join('jenis_barang', 'barang.jenis_barang_id', '=', 'jenis_barang.id')
				->where('barang.id', $barangMasuk->barang_id)
				->value('jenis_barang.id');
			$barangbyjenis = DB::table('barang')->where('jenis_barang_id', $jenis_barang_id)->orderBy('nama', 'asc')->get();
		}
		
		$customer = DB::table('customer')->select('id', 'nama')->orderBy('nama', 'asc')->get();
		$keperluan = DB::table('keperluan')->select('id', 'nama')->orderBy('nama', 'asc')->get();

        return view('permintaanbarangkeluar.create', compact('barangMasuk', 'customer', 'barang', 'barangbyjenis', 'jenis_barang', 'jenis_barang_id', 'keperluan'));
	}

	public function getBarangByJenis($id)
	{
		$barang = DB::table('barang')->where('jenis_barang_id', $id)->orderBy('nama', 'asc')->get();
		return response()->json($barang);
	}

	public function getSerialNumberByBarang($id)
	{
		$serialnumber = DB::table('barang_masuk')->where('barang_id', $id)->orderBy('serial_number', 'asc')->get();
		return response()->json($serialnumber);
	}

	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'serialnumber' => 'required|numeric',
			'barang_id' => 'required|numeric',
			'customer_id' => 'required|numeric',
			'keperluan_id' => 'required|numeric',
			'keterangan' => 'nullable|string|max:255',
			'tanggal' => 'required|date_format:Y-m-d',
		], [
			'serialnumber.required' => 'Serial Number harus diisi.',
			'serialnumber.numeric' => 'Serial Number harus berupa angka.',
			'keperluan_id.required' => 'Keperluan harus dipilih.',
			'keperluan_id.numeric' => 'ID Keperluan harus berupa angka.',
			'barang_id.required' => 'Barang harus dipilih.',
			'barang_id.numeric' => 'ID barang harus berupa angka.',
			'customer_id.required' => 'Penerima harus dipilih.',
			'customer_id.numeric' => 'ID Penerima barang harus berupa angka.',
			'keterangan.string' => 'Keterangan harus berupa teks.',
			'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
			'tanggal.required' => 'Tanggal harus diisi.',
			'tanggal.date_format' => 'Format tanggal harus YYYY-MM-DD.',
        ]);

		$barang_masuk = DB::table('barang_masuk')->where('serial_number', $request->serialnumber)->first();

		$data = PermintaanBarangKeluar::create([
			'barangmasuk_id' => $barang_masuk->id,
			'customer_id' => $request->customer_id,
			'keperluan_id' => $request->keperluan_id,
			'keterangan' => $request->keterangan,
			'tanggal' => $request->tanggal,
		]);

		/*$barang = Barang::find($request->barang_id);
		$barang->jumlah += 1; //$request->jumlah;
		$barang->save();*/

		return redirect('/permintaanbarangkeluar')->with('success', 'Anda berhasil menambahkan data!');
	}

	public function delete($id)
	{
		$data = PermintaanBarangKeluar::find($id);

		$data->delete();
		return redirect('/permintaanbarangkeluar')->with('success', 'Anda berhasil menghapus data!');
	}

	public function updateStatus(Request $request)
	{
        $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $permintaan = PermintaanBarangKeluar::findOrFail($request->id);
        
        if (!in_array($permintaan->status, ['Disetujui', 'Tidak Disetujui'])) {
            $permintaan->status = $request->status;
            $permintaan->save();

            return response()->json([
                'success' => true,
                'message' => 'Status permintaan berhasil diperbarui',
                'data' => $permintaan
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Status permintaan tidak dapat diubah karena sudah disetujui atau tidak disetujui',
            'data' => $permintaan
        ]);
	}
}
