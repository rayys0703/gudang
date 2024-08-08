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
			->leftJoin('keperluan', 'permintaan_barang_keluar.keperluan_id', '=', 'keperluan.id')
			->select(
				'permintaan_barang_keluar.*',
				'customer.nama as nama_customer',
				'keperluan.nama as nama_keperluan',
				'permintaan_barang_keluar.id as permintaan_barang_keluar_id',
                'permintaan_barang_keluar.jumlah'
			)
			->selectRaw("DATE_FORMAT(permintaan_barang_keluar.tanggal_awal, '%d %M %Y') as tanggal")
			->when($search, function ($query) use ($search) {
				return $query->where('customer.nama', 'like', '%' . $search . '%')
					->orWhere('keperluan.nama', 'like', '%' . $search . '%')
					->orWhere('customer.nama', 'like', '%' . $search . '%')
					->orWhere('permintaan_barang_keluar.jumlah', 'like', '%' . $search . '%')
					->orWhere('permintaan_barang_keluar.tanggal_awal', 'like', '%' . $search . '%');
			})
			->orderBy('permintaan_barang_keluar.tanggal_awal', 'desc')
			->orderBy('permintaan_barang_keluar.status', 'asc')
			->paginate(7);

		foreach ($data as $item) {
			$item->detail = DB::table('detail_permintaan_bk')
				->leftJoin('serial_number', 'detail_permintaan_bk.serial_number_id', '=', 'serial_number.id')
				->leftJoin('barang_masuk', 'serial_number.barangmasuk_id', '=', 'barang_masuk.id')
				->leftJoin('barang', 'barang_masuk.barang_id', '=', 'barang.id')
				->leftJoin('jenis_barang', 'barang.jenis_barang_id', '=', 'jenis_barang.id')
				->leftJoin('supplier', 'barang.supplier_id', '=', 'supplier.id')
				->select(
					'serial_number.serial_number', 
					'barang.nama as nama_barang', 
					'jenis_barang.nama as nama_jenis_barang', 
					'supplier.nama as nama_supplier'
				)
				->where('detail_permintaan_bk.permintaan_barang_keluar_id', $item->permintaan_barang_keluar_id)
				->orderBy('serial_number.serial_number', 'asc')
				->get();
		}

		// Format tanggal untuk tampilan
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
		$serialnumber = DB::table('serial_number')
			->join('barang_masuk', 'serial_number.barangmasuk_id', '=', 'barang_masuk.id')
			->where('barang_masuk.barang_id', $id)
			/*->whereNotExists(function ($query) {
				$query->select(DB::raw(1))
					->from('permintaan_barang_keluar')
					->whereRaw('permintaan_barang_keluar.barangmasuk_id = serial_number.id')
					->where(function ($subQuery) {
						$subQuery->whereNull('permintaan_barang_keluar.status')
							->orWhere('permintaan_barang_keluar.status', '!=', 'Ditolak');
					});
			})*/
			->orderBy('serial_number.serial_number', 'asc') // Mengurutkan berdasarkan serial_number
			->pluck('serial_number.serial_number'); // Memilih kolom serial_number dari tabel serial_number

		return response()->json($serialnumber);
	}

	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'serial_numbers' => 'required|array',
			'serial_numbers.*' => 'required|numeric',
			'customer_id' => 'required|numeric',
			'keperluan_id' => 'required|numeric',
			'keterangan' => 'nullable|string|max:255',
			'tanggal_awal' => 'required|date_format:Y-m-d',
		], [
			'serial_numbers.required' => 'Serial Number harus diisi.',
			'serial_numbers.array' => 'Serial Number harus berupa array.',
			'serial_numbers.*.required' => 'Setiap Serial Number harus diisi.',
			'serial_numbers.*.numeric' => 'Serial Number harus berupa angka.',
			'customer_id.required' => 'Penerima harus dipilih.',
			'customer_id.numeric' => 'ID Penerima barang harus berupa angka.',
			'keperluan_id.required' => 'Keperluan harus dipilih.',
			'keperluan_id.numeric' => 'ID Keperluan harus berupa angka.',
			'keterangan.string' => 'Keterangan harus berupa teks.',
			'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
			'tanggal_awal.required' => 'Tanggal harus diisi.',
			'tanggal_awal.date_format' => 'Format tanggal harus YYYY-MM-DD.',
		]);

		// Hitung jumlah dari total serial number
		$jumlah = count($request->serial_numbers);

		// Simpan permintaan_barang_keluar
		$permintaan = PermintaanBarangKeluar::create([
			'customer_id' => $request->customer_id,
			'keperluan_id' => $request->keperluan_id,
			'jumlah' => $jumlah,
			'keterangan' => $request->keterangan,
			'tanggal_awal' => $request->tanggal_awal,
		]);

		// Simpan detail_permintaan_bk
		foreach ($request->serial_numbers as $serialNumber) {
			// Ambil data dari tabel serial_number
			$serialNumberData = DB::table('serial_number')
				->where('serial_number', $serialNumber)
				->first();

			if (!$serialNumberData) {
				return redirect()->back()->withErrors(['serial_numbers' => 'Serial Number ' . $serialNumber . ' tidak ditemukan.'])->withInput();
			}

			DB::table('detail_permintaan_bk')->insert([
				'permintaan_barang_keluar_id' => $permintaan->id,
				'serial_number_id' => $serialNumberData->id,
				'keterangan' => $request->keterangan,
			]);
		}

		return redirect('/permintaanbarangkeluar')->with('success', 'Anda berhasil menambahkan data!');
	}

	public function delete($id)
	{
		// Temukan permintaan berdasarkan ID
		$data = PermintaanBarangKeluar::find($id);

		if (!$data) {
			return redirect('/permintaanbarangkeluar')->withErrors(['error' => 'Data permintaan tidak ditemukan.']);
		}

		// Hapus detail permintaan barang keluar terkait
		DB::table('detail_permintaan_bk')
			->where('permintaan_barang_keluar_id', $id)
			->delete();

		// Hapus data permintaan barang keluar
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
		
		if (!in_array($permintaan->status, ['Disetujui', 'Ditolak'])) {
			$permintaan->status = $request->status;
			$permintaan->save();
	
			if ($request->status === 'Disetujui') {
				$permintaanBarang = DB::table('permintaan_barang_keluar')
					->select('permintaan_barang_keluar.*')
					->where('permintaan_barang_keluar.id', $request->id)
					->first();
				
				if ($permintaanBarang) {
					$insertData = DB::table('barang_keluar')->insert([
						'permintaan_id' => $permintaanBarang->id,
						'tanggal' => now(),			
						'created_at' => now(),
						//'keterangan' => $permintaanBarang->keterangan,						
					]);

					/*if ($insertData) {
						$barang = Barang::find($permintaanBarang->barang_id);
						$barang->jumlah -= $permintaanBarang->jumlah;
						$barang->save();
					}		*/		
				}
			}
	
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
