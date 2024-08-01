<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permintaan_barang_keluar', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned();
            $table->unsignedBigInteger('barangmasuk_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('keperluan_id');
            $table->string('keterangan')->nullable();
            $table->date('tanggal');
            $table->enum('status', ['Belum Disetujui', 'Disetujui', 'Ditolak'])->default('Belum Disetujui');
            $table->timestamps();

            $table->foreign('barangmasuk_id')->references('id')->on('barang_masuk')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('keperluan_id')->references('id')->on('keperluan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_barang_keluar');
    }
};
