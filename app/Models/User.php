<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi
    public function anggota()
    {
        return $this->hasOne(anggota::class);
    }

    public function petugas()
    {
        return $this->hasOne(petugas::class);
    }

    public function kepala()
    {
        return $this->hasOne(kepala_perpus::class);
    }
}
