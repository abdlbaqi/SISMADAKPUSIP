<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSurat extends Model
{
    use HasFactory;

    protected $table = 'kategori_surat';

    protected $fillable = [
        'nama_kategori',
        'kode_kategori',
        'keterangan'
    ];

    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_id');
    }

    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'kategori_id');
    }

    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'kategori_id');
    }
}
