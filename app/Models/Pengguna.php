<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'jabatan',
        'unit_kerja',
        'peran',
        'aktif'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'aktif' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Relationship dengan SuratMasuk sebagai penerima
     */
    public function suratMasukSebagaiPenerima()
    {
        return $this->hasMany(SuratMasuk::class, 'penerima_id');
    }

    /**
     * Relationship dengan SuratMasuk sebagai pembuat
     */
    public function suratMasukSebagaiPembuat()
    {
        return $this->hasMany(SuratMasuk::class, 'dibuat_oleh');
    }

    /**
     * Accessor untuk nama lengkap dengan jabatan
     */
    public function getNamaLengkapAttribute()
    {
        return $this->nama . ($this->jabatan ? ' - ' . $this->jabatan : '');
    }

    /**
     * Scope untuk pengguna aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }
}