<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'kata_sandi',
        'peran',
        'jabatan',
        'unit_kerja'
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function suratMasukDibuat()
    {
        return $this->hasMany(SuratMasuk::class, 'dibuat_oleh');
    }

    public function suratMasukDiterima()
    {
        return $this->hasMany(SuratMasuk::class, 'penerima_id');
    }

    public function suratKeluarDibuat()
    {
        return $this->hasMany(SuratKeluar::class, 'pembuat_id');
    }

    public function suratKeluarDisetujui()
    {
        return $this->hasMany(SuratKeluar::class, 'penyetuju_id');
    }

    public function disposisiDikirim()
    {
        return $this->hasMany(Disposisi::class, 'dari_pengguna_id');
    }

    public function disposisiDiterima()
    {
        return $this->hasMany(Disposisi::class, 'kepada_pengguna_id');
    }

    public function arsipDibuat()
    {
        return $this->hasMany(Arsip::class, 'diarsipkan_oleh');
    }
}