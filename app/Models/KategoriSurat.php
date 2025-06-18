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
        'keterangan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Relationship dengan SuratMasuk
     */
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'kategori_id');
    }

    /**
     * Scope untuk kategori aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}