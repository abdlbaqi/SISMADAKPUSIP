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
        'kata_sandi',
        'unit_kerja',
        'peran'
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kata_sandi' => 'hashed'
    ];

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

}