<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JenisBarangController extends Controller
{

	public function index(Request $request)
	{
        return view('jenisbarang.index');
	}

	public function create()
	{
		return view('jenisbarang.create');
	}

	public function store(Request $request): RedirectResponse
	{
		$response = Http::withToken(session('token'))->post(config('app.api_url') . '/jenisbarang', $request->all());

        if ($response->successful()) {
            return redirect('/jenisbarang')->with('success', 'Data berhasil ditambahkan!');
        }

        return back()->withErrors('Gagal menambahkan data jenis barang.');
	}

	public function edit($id)
	{
		$response = Http::withToken(session('token'))->get(config('app.api_url') . '/jenisbarang/' . $id);

        if ($response->successful()) {
            $data = $response->json();
            $data = (object) $data;
            return view('jenisbarang.edit', compact('data'));
        }
        return redirect('/jenisbarang')->withErrors('Gagal mengambil data jenis barang.');
	}

	public function update($id, Request $request): RedirectResponse
	{
		$response = Http::withToken(session('token'))->put(config('app.api_url') . '/jenisbarang/' . $id, $request->all());

        if ($response->successful()) {
            return redirect('/jenisbarang')->with('success', 'Data berhasil diperbarui!');
        }

        return back()->withErrors('Gagal memperbarui data jenis barang.');
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(config('app.api_url') . '/jenisbarang/' . $id);

        if ($response->successful()) {
            return redirect('/jenisbarang')->with('success', 'Data berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data jenis barang.');
	}

	public function deleteSelected(Request $request)
	{
		$response = Http::withToken(session('token'))->post(config('app.api_url') . '/jenisbarang/delete-selected', [
            'ids' => $request->input('ids')
        ]);

        if ($response->successful()) {
            return redirect('/jenisbarang')->with('success', 'Data terpilih berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data jenis barang terpilih.');
	}
}
