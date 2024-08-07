<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPermintaanBarangKeluar extends Model
{
    use HasFactory;

    protected $table = "detail_permintaan_bk";

    protected $fillable = [
        'customer_id',
        'keperluan_id',
        'tanggal',
        'keterangan',
        'status'
    ];
}
