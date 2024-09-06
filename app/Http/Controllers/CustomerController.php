<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{

	public function index(Request $request)
	{
		return view('customer.index');
	}

	public function create()
	{
		return view('customer.create');
	}

	public function store(Request $request)
	{
		$response = Http::withToken(session('token'))->post(config('app.api_url') . '/customers', $request->all());

        if ($response->successful()) {
            return redirect('/customer')->with('success', 'Data berhasil ditambahkan!');
        }

        return back()->withErrors('Gagal menambahkan data customer.');
	}

	public function edit($id)
	{
		$response = Http::withToken(session('token'))->get(config('app.api_url') . '/customers/' . $id);

        if ($response->successful()) {
            $data = $response->json();
            return view('customer.edit', compact('data'));
        }

        return redirect('/customer')->withErrors('Gagal mengambil data customer.');
	}

	public function update($id, Request $request)
	{
		$response = Http::withToken(session('token'))->put(config('app.api_url') . '/customers/' . $id, $request->all());

        if ($response->successful()) {
            return redirect('/customer')->with('success', 'Data berhasil diperbarui!');
        }

        return back()->withErrors('Gagal memperbarui data customer.');
	}

	public function delete($id)
	{
		$response = Http::withToken(session('token'))->delete(config('app.api_url') . '/customers/' . $id);

        if ($response->successful()) {
            return redirect('/customer')->with('success', 'Data berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data customer.');
	}

	public function deleteSelected(Request $request)
	{
		$response = Http::withToken(session('token'))->post(config('app.api_url') . '/customers/delete-selected', [
            'ids' => $request->input('ids')
        ]);

        if ($response->successful()) {
            return redirect('/customer')->with('success', 'Data terpilih berhasil dihapus!');
        }

        return back()->withErrors('Gagal menghapus data customer terpilih.');
	}
}
