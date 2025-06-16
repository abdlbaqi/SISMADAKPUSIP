<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_agenda',
        'nomor_surat',
        'tujuan_surat',
        'perihal',
        'tanggal_surat',
        'tanggal_kirim',
        'kategori_id',
        'sifat_surat',
        'lampiran',
        'isi_ringkas',
        'file_surat',
        'status',
        'pembuat_id',
        'penyetuju_id',
        'catatan'
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'tanggal_kirim' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }

    public function pembuat()
    {
        return $this->belongsTo(Pengguna::class, 'pembuat_id');
    }

    public function penyetuju()
    {
        return $this->belongsTo(Pengguna::class, 'penyetuju_id');
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
            'draft' => 'Draft',
            'menunggu_persetujuan' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'dikirim' => 'Dikirim'
        ];
        return $status[$this->status] ?? 'Tidak Diketahui';
    }
}