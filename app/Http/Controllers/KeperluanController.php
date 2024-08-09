<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Keperluan;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeperluanController extends Controller
{

	public function index(Request $request)
	{
		$search = $request->input('search');

        $data = Keperluan::when($search, function ($query) use ($search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })->paginate(7);

        return view('keperluan.index', compact('data'));
	}

	public function create()
	{
		return view('keperluan.create');
	}

	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			'nama' => 'required|string|max:30',
			'nama_tanggal_awal' => 'nullable|string|max:30',
			'nama_tanggal_akhir' => 'nullable|string|max:30',
			'extend' => 'nullable|boolean',
		], [
			'nama.required' => 'Nama jenis barang harus diisi.',
			'nama.string' => 'Nama jenis barang harus berupa teks.',
			'nama.max' => 'Nama jenis barang tidak boleh lebih dari 30 karakter.',
			'nama_tanggal_awal.string' => 'Nama tanggal awal harus berupa teks.',
			'nama_tanggal_awal.max' => 'Nama tanggal awal tidak boleh lebih dari 30 karakter.',
			'nama_tanggal_akhir.string' => 'Nama tanggal akhir harus berupa teks.',
			'nama_tanggal_akhir.max' => 'Nama tanggal akhir tidak boleh lebih dari 30 karakter.',
			'extend.boolean' => 'Extend harus berupa nilai boolean (false/true).',
		]);

		$data = Keperluan::create([
			'nama' => $request->nama,
			'nama_tanggal_awal' => $request->nama_tanggal_awal,
			'nama_tanggal_akhir' => $request->nama_tanggal_akhir,
			'extend' => $request->extend ?? 0,
		]);

		return redirect('/keperluan')->with('success', 'Anda berhasil menambahkan data!');
	}

	public function edit($id)
	{
		$data = Keperluan::find($id);
		return view('keperluan.edit', ['data' => $data]);
	}

	public function update($id, Request $request): RedirectResponse
	{
		$request->validate([
			'nama' => 'required|string|max:30',
			'nama_tanggal_awal' => 'nullable|string|max:30',
			'nama_tanggal_akhir' => 'nullable|string|max:30',
			'extend' => 'nullable|boolean',
		], [
			'nama.required' => 'Nama jenis barang harus diisi.',
			'nama.string' => 'Nama jenis barang harus berupa teks.',
			'nama.max' => 'Nama jenis barang tidak boleh lebih dari 30 karakter.',
			'nama_tanggal_awal.string' => 'Nama tanggal awal harus berupa teks.',
			'nama_tanggal_awal.max' => 'Nama tanggal awal tidak boleh lebih dari 30 karakter.',
			'nama_tanggal_akhir.string' => 'Nama tanggal akhir harus berupa teks.',
			'nama_tanggal_akhir.max' => 'Nama tanggal akhir tidak boleh lebih dari 30 karakter.',
			'extend.boolean' => 'Extend harus berupa nilai boolean (false/true).',
		]);

		$data = Keperluan::find($id);

		$data->nama = $request->nama;
		$data->nama_tanggal_awal = $request->nama_tanggal_awal;
		$data->nama_tanggal_akhir = $request->nama_tanggal_akhir;
		$data->extend = $request->extend ?? 0;
		$data->save();

		return redirect('/keperluan')->with('success', 'Anda berhasil memperbarui data!');
	}

	public function delete($id)
	{
		$keperluan = Keperluan::find($id);
		/*$barangMasuk = BarangMasuk::where('status_barang_id', $id)->get();

		foreach ($barangMasuk as $item) {
			$barang = Barang::find($item->barang_id);
			if ($barang) {
				$barang->jumlah -= $item->jumlah;
				$barang->save();
			}
			$item->delete();
		}*/

		$keperluan->delete();
		return redirect('/keperluan')->with('success', 'Anda berhasil menghapus data!');
	}

	public function deleteSelected(Request $request)
	{
		$ids = $request->input('ids');
		foreach ($ids as $id) {
			$keperluan = Keperluan::find($id);
			/*$barangMasuk = BarangMasuk::where('status_barang_id', $id)->get();

			foreach ($barangMasuk as $item) {
				$barang = Barang::find($item->barang_id);
				if ($barang) {
					$barang->jumlah -= $item->jumlah;
					$barang->save();
				}
				$item->delete();
			}*/

			$keperluan->delete();
		}
		return response()->json(['success' => 'Data berhasil dihapus']);
	}
}
