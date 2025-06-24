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
        Schema::table('surat_masuk', function (Blueprint $table) {
          $table->enum('unit_disposisi', ['sekretaris', 'kabid_deposit', 
          'kabid_pengembangan', 'kabid_layanan', 'kabid_pembinaan', 'kabid_pengelolaan_arsip']);
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
