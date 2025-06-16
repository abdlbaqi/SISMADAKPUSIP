<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';

    protected $fillable = [
        'kode_arsip',
        'nomor_berkas',
        'judul_berkas',
        'deskripsi',
        'jenis_arsip',
        'kategori_id',
        'tanggal_arsip',
        'lokasi_fisik',
        'file_digital',
        'tingkat_akses',
        'retensi_sampai',
        'status_arsip',
        'diarsipkan_oleh',
        'catatan'
    ];

    protected $casts = [
        'tanggal_arsip' => 'date',
        'retensi_sampai' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    public function pengarsip()
    {
        return $this->belongsTo(Pengguna::class, 'diarsipkan_oleh');
    }

    public function getJenisArsipTextAttribute()
    {
        $jenis = [
            'surat_masuk' => 'Surat Masuk',
            'surat_keluar' => 'Surat Keluar',
            'dokumen_lain' => 'Dokumen Lain'
        ];
        return $jenis[$this->jenis_arsip] ?? 'Tidak Diketahui';
    }

    public function getTingkatAksesTextAttribute()
    {
        $tingkat = [
            'publik' => 'Publik',
            'terbatas' => 'Terbatas',
            'rahasia' => 'Rahasia'
        ];
        return $tingkat[$this->tingkat_akses] ?? 'Tidak Diketahui';
    }

    public function getStatusArsipTextAttribute()
    {
        $status = [
            'aktif' => 'Aktif',
            'inaktif' => 'Tidak Aktif',
            'musnah' => 'Musnah'
        ];
        return $status[$this->status_arsip] ?? 'Tidak Diketahui';
    }
}