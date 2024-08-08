<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Barang;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{

    public function stok(Request $request)
    {
        $search = $request->input('search');

        $query = DB::table('barang_masuk')
            ->leftJoin('barang', 'barang_masuk.barang_id', '=', 'barang.id')
            ->leftJoin('jenis_barang', 'barang.jenis_barang_id', '=', 'jenis_barang.id')
            ->leftJoin('supplier', 'barang.supplier_id', '=', 'supplier.id')
            ->leftJoin('detail_barang_masuk', 'barang.supplier_id', '=', 'detail_barang_masuk.id')
            ->leftJoin('status_barang', 'barang_masuk.status_barang_id', '=', 'status_barang.id')
            ->select(
                'barang_masuk.barang_id',
                'barang.id as valbarang_id',
                'barang.nama as nama_barang',
                'barang.keterangan as keterangan_barang',
                'jenis_barang.nama as nama_jenis_barang',
                'supplier.nama as supplier_name',
                'status_barang.nama as status_name',
                'status_barang.warna as warna_status',
                DB::raw('SUM(barang_masuk.jumlah) as jumlah')
            )
            ->where('jumlah', '>', 0)
            ->when($search, function ($query) use ($search) {
                return $query->where('barang.nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis_barang.nama', 'like', '%' . $search . '%');
            })
            ->orderBy('jumlah','desc')
            ->orderBy('barang.nama','asc');

        $data = $query->get();

        // Memproses data ke grup Serial Number berdasarkan Supplier dan Kondisi Barang
        $groupedData = $data->groupBy('barang_id')->map(function ($items) {
            $result = [
                'barang_id' => $items->first()->barang_id,
                'nama_barang' => $items->first()->nama_barang,
                'nama_jenis_barang' => $items->first()->nama_jenis_barang,
                'jumlah_barang' => $items->first()->jumlah_barang,
                'keterangan_barang' => $items->first()->keterangan_barang,
                'suppliers' => []
            ];

            foreach ($items as $item) {
                if (!isset($result['suppliers'][$item->supplier_name])) {
                    $result['suppliers'][$item->supplier_name] = [];
                }
                $result['suppliers'][$item->supplier_name][] = [
                    'serial_number' => $item->serial_number,
                    'nama_status' => $item->status_name,
                    'warna_status' => $item->warna_status
                ];
            }

            return $result;
        });

        $data = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedData->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), 7),
            $groupedData->count(),
            7,
            null,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('laporan.stok.index', ['data' => $data]);
    }

    public function barangmasuk(Request $request)
    {
		$search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

		$data = DB::table('barang_masuk')
			->leftJoin('barang', 'barang_masuk.barang_id', '=', 'barang.id')
			->leftJoin('supplier', 'barang.supplier_id', '=', 'supplier.id')
			->leftJoin('jenis_barang', 'barang.jenis_barang_id', '=', 'jenis_barang.id')
			->select(
				'barang_masuk.id as barang_masuk_id',
				'barang_masuk.keterangan',
				'barang_masuk.tanggal',
				'barang.nama as nama_barang',
				'jenis_barang.nama as nama_jenis_barang',
				'supplier.nama as nama_supplier',
				'barang_masuk.jumlah'
			)
			->selectRaw("DATE_FORMAT(barang_masuk.tanggal, '%d %M %Y') as formatted_tanggal")
			->when($search, function ($query) use ($search) {
				return $query->where('barang_masuk.barang_id', 'like', '%' . $search . '%')
					->orWhere('barang.nama', 'like', '%' . $search . '%')
					->orWhere('supplier.nama', 'like', '%' . $search . '%');
			})
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('barang_masuk.tanggal', [$startDate, $endDate]);
            })
			->orderBy('barang_masuk.created_at', 'desc')
			->paginate(7);

		// Ambil detail barang masuk
		foreach ($data as $item) {
			$item->detail = DB::table('detail_barang_masuk')
				->leftJoin('serial_number', 'detail_barang_masuk.serial_number_id', '=', 'serial_number.id')
				->leftJoin('status_barang', 'detail_barang_masuk.status_barang_id', '=', 'status_barang.id')
				->select('serial_number.serial_number', 'status_barang.nama as status_barang', 'detail_barang_masuk.kelengkapan')
				->where('detail_barang_masuk.barangmasuk_id', $item->barang_masuk_id)
				->orderBy('serial_number.serial_number', 'asc')
				->get();
		}

		// Transform data untuk modal
		$data->getCollection()->transform(function ($item) {
			$item->tanggal = \Carbon\Carbon::parse($item->tanggal)->isoFormat('DD MMMM YYYY');
			return $item;
		});

		return view('laporan.barangmasuk.index', compact('data', 'startDate', 'endDate'));
	}

    public function barangkeluar(Request $request)
        {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = DB::table('barang_keluar')
            ->leftJoin('permintaan_barang_keluar', 'barang_keluar.permintaan_id', '=', 'permintaan_barang_keluar.id')            
            ->leftJoin('customer', 'permintaan_barang_keluar.customer_id', '=', 'customer.id')
            ->leftJoin('keperluan', 'permintaan_barang_keluar.keperluan_id', '=', 'keperluan.id')
            ->select(
                'barang_keluar.*',
                'customer.nama as nama_customer', 
                'keperluan.nama as nama_keperluan',
                'permintaan_barang_keluar.id as permintaan_barang_keluar_id',
                'permintaan_barang_keluar.jumlah'
            )
            ->selectRaw("DATE_FORMAT(barang_keluar.tanggal, '%d %M %Y') as formatted_tanggal")
                ->when($search, function ($query) use ($search) {
                    return $query->where('customer.nama', 'like', '%' . $search . '%');
                })
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('barang_keluar.tanggal', [$startDate, $endDate]);
                })
            ->orderBy('barang_keluar.created_at', 'desc')
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

        return view('laporan.barangkeluar.index', compact('data', 'startDate', 'endDate'));
    }
}