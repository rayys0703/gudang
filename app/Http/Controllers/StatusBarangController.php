<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\StatusBarang;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StatusBarangController extends Controller
{

	public function index(Request $request)
	{
        return view('statusbarang.index');
	}

	public function create()
	{
		return view('statusbarang.create');
	}

	public function store(Request $request): RedirectResponse
	{
		$response = Http::withToken(session('token'))->post(config('app.api_url') . '/statusbarang', $request->all());

        if ($response->successful()) {
            return redirect('/statusbarang')->with('success', 'Data berhasil ditambahkan!');
        }

        return back()->withErrors('Gagal menambahkan data status barang.');
	}

	public function edit($id)
	{
		$response = Http::withToken(session('token'))->get(config('app.api_url') . '/statusbarang/' . $id);

        if ($response->successful()) {
            $data = $response->json();
            $data = (object) $data;
            return view('statusbarang.edit', compact('data'));
        }
        return redirect('/statusbarang')->withErrors('Gagal mengambil data status barang.');
	}

	public function update($id, Request $request): RedirectResponse
	{
		$response = Http::withToken(session('token'))->put(config('app.api_url') . '/statusbarang/' . $id, $request->all());

        if ($response->successful()) {
            return redirect('/statusbarang')->with('success', 'Data berhasil diperbarui!');
        }

        return back()->withErrors('Gagal memperbarui data status barang.');
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(config('app.api_url') . '/statusbarang/' . $id);

        if ($response->successful()) {
            return redirect('/statusbarang')->with('success', 'Data berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data status barang.');
	}

	public function deleteSelected(Request $request)
	{
		$response = Http::withToken(session('token'))->post(config('app.api_url') . '/statusbarang/delete-selected', [
            'ids' => $request->input('ids')
        ]);

        if ($response->successful()) {
            return redirect('/statusbarang')->with('success', 'Data terpilih berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data status barang terpilih.');
	}
}
