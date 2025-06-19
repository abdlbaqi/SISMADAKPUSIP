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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();

            // Identitas Pengirim
            $table->string('nama_pengirim');
            $table->string('jabatan_pengirim');
            $table->string('instansi_pengirim');

            // Informasi Surat
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->string('asal_surat');
            $table->string('perihal');
            $table->text('isi_ringkas');
            $table->foreignId('kategori_id')->constrained('kategori_surat');
            $table->enum('sifat_surat', ['biasa', 'penting', 'segera', 'rahasia']);
            $table->text('keterangan')->nullable();
            $table->string('file_surat')->nullable();

            // Meta
            $table->enum('status', ['belum_dibaca', 'sudah_dibaca', 'diproses', 'selesai'])->default('belum_dibaca');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
