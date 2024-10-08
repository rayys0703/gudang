<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::withToken(Session::get('token'))->get(config('app.api_url') . '/dashboard');

        if ($response->successful()) {
            $data = $response->json();
            
            return view('dashboard', $data);
        } else {
            // Handle error
            return redirect()->route('login')->withErrors('Tidak dapat memuat dashboard.');
        }
    }
}

//$data['total_supplier'] = 99999;
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Http\RedirectResponse;
// use App\Models\Barang;
// use App\Models\BarangKeluar;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {  
//     public function index(Request $request)
//     {
//         $search = $request->input('search');

//         $total_supplier = DB::table('supplier')->count();
//         $total_customer = DB::table('customer')->count();
//         $total_barang = DB::table('barang')->count();
//         $total_barang_masuk = DB::table('barang_masuk')->count();
//         $total_barang_keluar = DB::table('barang_keluar')->count();

//         return view('dashboard', compact('total_supplier', 'total_customer', 'total_barang', 'total_barang_masuk', 'total_barang_keluar'));
//     }

// }
