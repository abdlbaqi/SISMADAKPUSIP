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
    Schema::table('surat_keluar', function (Blueprint $table) {
    $table->string('tujuan_surat')->after('dikirimkan_melalui');
    $table->string('nama_penandatangan')->after('tujuan_surat');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
