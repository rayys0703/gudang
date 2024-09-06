<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SupplierController extends Controller
{

	public function index(Request $request)
	{
		return view('supplier.index');
	}

	public function create()
	{
		return view('supplier.create');
	}

    public function store(Request $request)
    {
        $response = Http::withToken(session('token'))->post(config('app.api_url') . '/suppliers', $request->all());

        if ($response->successful()) {
            return redirect('/supplier')->with('success', 'Data berhasil ditambahkan!');
        }

        return back()->withErrors('Gagal menambahkan data supplier.');
    }

    public function edit($id)
    {
        $response = Http::withToken(session('token'))->get(config('app.api_url') . '/suppliers/' . $id);

        if ($response->successful()) {
            $data = $response->json();
            return view('supplier.edit', compact('data'));
        }

        return redirect('/supplier')->withErrors('Gagal mengambil data supplier.');
    }

    public function update($id, Request $request)
    {
        $response = Http::withToken(session('token'))->put(config('app.api_url') . '/suppliers/' . $id, $request->all());

        if ($response->successful()) {
            return redirect('/supplier')->with('success', 'Data berhasil diperbarui!');
        }

        return back()->withErrors('Gagal memperbarui data supplier.');
    }

    public function delete($id)
    {
        $response = Http::withToken(session('token'))->delete(config('app.api_url') . '/suppliers/' . $id);

        if ($response->successful()) {
            return redirect('/supplier')->with('success', 'Data berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data supplier.');
    }

    public function deleteSelected(Request $request)
    {
        $response = Http::withToken(session('token'))->post(config('app.api_url') . '/suppliers/delete-selected', [
            'ids' => $request->input('ids')
        ]);

        if ($response->successful()) {
            return redirect('/supplier')->with('success', 'Data terpilih berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data supplier terpilih.');
    }
}
