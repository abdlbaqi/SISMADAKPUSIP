<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->string('kode_arsip')->unique();
            $table->string('nomor_berkas');
            $table->string('judul_berkas');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_arsip', ['surat_masuk', 'surat_keluar', 'dokumen_lain']);
            $table->foreignId('kategori_id')->constrained('kategori_surat');
            $table->date('tanggal_arsip');
            $table->string('lokasi_fisik')->nullable();
            $table->string('file_digital')->nullable();
            $table->enum('tingkat_akses', ['publik', 'terbatas', 'rahasia']);
            $table->date('retensi_sampai')->nullable();
            $table->enum('status_arsip', ['aktif', 'inaktif', 'musnah']);
            $table->foreignId('diarsipkan_oleh')->constrained('pengguna');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
