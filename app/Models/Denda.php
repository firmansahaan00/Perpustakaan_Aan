<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';

    protected $fillable = [
        'peminjaman_id',
        'jenis',
        'nominal_tagihan',
        'keterangan',
        'status_denda',
        'parent_id',
        'is_revisi',
    ];

    // relasi ke peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // relasi parent (denda lama)
    public function parent()
    {
        return $this->belongsTo(Denda::class, 'denda_parent_id');
    }

    // relasi child (denda revisi)
    public function revisi()
    {
        return $this->hasMany(Denda::class, 'denda_parent_id');
    }
}