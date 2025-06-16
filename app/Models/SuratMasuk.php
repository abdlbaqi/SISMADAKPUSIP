<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'asal_surat',
        'perihal',
        'tanggal_surat',
        'tanggal_diterima',
        'kategori_id',
        'sifat_surat',
        'lampiran',
        'isi_ringkas',
        'file_surat',
        'status',
        'penerima_id',
        'catatan',
        'dibuat_oleh'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_diterima' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(Pengguna::class, 'dibuat_oleh');
    }

    public function penerima()
    {
        return $this->belongsTo(Pengguna::class, 'penerima_id');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }

    public function getSifatSuratTextAttribute()
    {
        $sifat = [
            'biasa' => 'Biasa',
            'penting' => 'Penting',
            'segera' => 'Segera',
            'rahasia' => 'Rahasia'
        ];
        return $sifat[$this->sifat_surat] ?? 'Tidak Diketahui';
    }

    public function getStatusTextAttribute()
    {
        $status = [
            'belum_dibaca' => 'Belum Dibaca',
            'sudah_dibaca' => 'Sudah Dibaca',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai'
        ];
        return $status[$this->status] ?? 'Tidak Diketahui';
    }
}