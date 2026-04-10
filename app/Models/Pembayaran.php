<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'denda_id',
        'nominal_bayar',
        'metode',
        'tipe',
        'tanggal_bayar',
    ];

    // relasi ke denda
    public function denda()
    {
        return $this->belongsTo(Denda::class);
    }
}