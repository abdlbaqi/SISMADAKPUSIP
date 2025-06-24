<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

  protected $fillable = [
    'nama_pengirim',
    'jabatan_pengirim',
    'instansi_pengirim',
    'nomor_surat',
    'perihal',
    'isi_ringkas',
    'tanggal_surat',
    'tanggal_diterima',
    'kategori_id',
    'sifat_surat',
    'keterangan',
    'file_surat',
    'unit_disposisi',
];


    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    /**
     * Relationship dengan KategoriSurat
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    /**
     * Relationship dengan Pengguna sebagai pembuat surat
     */
    public function pembuatSurat()
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    /**
     * Accessor untuk format tanggal surat Indonesia
     */
    public function getTanggalSuratFormatAttribute()
    {
        return $this->tanggal_surat ? $this->tanggal_surat->format('d/m/Y') : '-';
    }

    /**
     * Accessor untuk format tanggal diterima Indonesia
     */
    public function getTanggalDiterimaFormatAttribute()
    {
        return $this->tanggal_diterima ? $this->tanggal_diterima->format('d/m/Y') : '-';
    }


    /**
     * Accessor untuk sifat surat text Indonesia
     */
    public function getSifatSuratTextAttribute()
    {
        return match($this->sifat_surat) {
            'biasa' => 'Biasa',
            'penting' => 'Penting',
            'segera' => 'Segera',
            'rahasia' => 'Rahasia',
            default => '-'
        };
    }

}