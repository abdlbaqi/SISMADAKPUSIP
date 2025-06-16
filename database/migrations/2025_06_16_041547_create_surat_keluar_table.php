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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda')->unique();
            $table->string('nomor_surat');
            $table->string('tujuan_surat');
            $table->string('perihal');
            $table->date('tanggal_surat');
            $table->date('tanggal_kirim');
            $table->foreignId('kategori_id')->constrained('kategori_surat');
            $table->enum('sifat_surat', ['biasa', 'penting', 'segera', 'rahasia']);
            $table->string('lampiran')->nullable();
            $table->text('isi_ringkas')->nullable();
            $table->string('file_surat')->nullable();
            $table->enum('status', ['draft', 'menunggu_persetujuan', 'disetujui', 'dikirim']);
            $table->foreignId('pembuat_id')->constrained('pengguna');
            $table->foreignId('penyetuju_id')->nullable()->constrained('pengguna');
            $table->text('catatan')->nullable();
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
