<?php
// File: app/Models/SuratKeluar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'kategori_id',
        'sifat_surat',
        'klasifikasi',
        'hal',
        'tujuan_surat',
        'nama_penandatangan',
        'file_surat',
        'dikirimkan_melalui',
    ];

    protected $dates = [
        'tanggal_surat'
    ];

     public function kategori()
    {
        return $this->belongsTo(KategoriSurat::class, 'kategori_id');
    }
    // Mutator untuk format tanggal
    public function setTanggalSuratAttribute($value)
    {
        $this->attributes['tanggal_surat'] = Carbon::createFromFormat('Y-m-d', $value);
    }

    // Accessor untuk format tanggal
    public function getTanggalSuratAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    // Accessor untuk format tanggal Indonesia
    public function getTanggalSuratFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_surat)->format('d F Y');
    }

}