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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk');
            $table->foreignId('dari_pengguna_id')->constrained('pengguna');
            $table->foreignId('kepada_pengguna_id')->constrained('pengguna');
            $table->text('instruksi');
            $table->date('batas_waktu')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi', 'sangat_tinggi']);
            $table->enum('status', ['menunggu', 'diterima', 'diproses', 'selesai']);
            $table->text('catatan_penerima')->nullable();
            $table->timestamp('tanggal_diterima')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
