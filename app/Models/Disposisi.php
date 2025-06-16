<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';

    protected $fillable = [
        'surat_masuk_id',
        'dari_pengguna_id',
        'kepada_pengguna_id',
        'instruksi',
        'batas_waktu',
        'prioritas',
        'status',
        'catatan_penerima',
        'tanggal_diterima',
        'tanggal_selesai'
    ];

    protected $casts = [
        'batas_waktu' => 'date',
        'tanggal_diterima' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(Pengguna::class, 'dari_pengguna_id');
    }

    public function penerima()
    {
        return $this->belongsTo(Pengguna::class, 'kepada_pengguna_id');
    }

    public function getPrioritasTextAttribute()
    {
        $prioritas = [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi',
            'sangat_tinggi' => 'Sangat Tinggi'
        ];
        return $prioritas[$this->prioritas] ?? 'Tidak Diketahui';
    }

    public function getStatusTextAttribute()
    {
        $status = [
            'menunggu' => 'Menunggu',
            'diterima' => 'Diterima',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai'
        ];
        return $status[$this->status] ?? 'Tidak Diketahui';
    }
}
