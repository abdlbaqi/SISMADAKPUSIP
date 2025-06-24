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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('nomor_referensi')->nullable();
            $table->date('tanggal_surat');
            $table->string('jenis_surat');
            $table->string('sifat_surat');
            $table->string('klasifikasi');
            $table->text('hal');
            $table->text('isi_ringkas');
            $table->string('file_surat')->nullable();
            $table->string('dikirimkan_melalui');
            $table->string('status')->default('draft'); // draft, terkirim, arsip
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};