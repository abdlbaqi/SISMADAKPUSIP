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
        'nomor_referensi',
        'tanggal_surat',
        'jenis_surat',
        'sifat_surat',
        'klasifikasi',
        'hal',
        'isi_ringkas',
        'file_surat',
        'dikirimkan_melalui',
        'status'
    ];

    protected $dates = [
        'tanggal_surat'
    ];

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

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan jenis surat
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_surat', $jenis);
    }

    // Generate nomor surat otomatis
    public static function generateNomorSurat($jenis = null, $klasifikasi = null)
    {
        $year = date('Y');
        $month = date('m');
        
        // Ambil nomor terakhir untuk tahun ini
        $lastNumber = self::whereYear('tanggal_surat', $year)
                         ->orderBy('id', 'desc')
                         ->first();
        
        $nextNumber = $lastNumber ? (intval(substr($lastNumber->nomor_surat, 0, 3)) + 1) : 1;
        
        // Format: 001/JENIS/KLASIFIKASI/MM/YYYY
        $nomorSurat = sprintf('%03d', $nextNumber);
        
        if ($jenis) {
            $nomorSurat .= '/' . strtoupper($jenis);
        }
        
        if ($klasifikasi) {
            $nomorSurat .= '/' . strtoupper($klasifikasi);
        }
        
        $nomorSurat .= '/' . $month . '/' . $year;
        
        return $nomorSurat;
    }
}