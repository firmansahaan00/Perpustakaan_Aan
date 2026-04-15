<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status',
        'catatan',
    ];

    // relasi ke user
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    //relasi ke anggota
    public function Anggota()
    {
        return $this->belongsTo(User::class, 'user_id'); // sesuaikan foreign key
    }

    // relasi ke buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // relasi ke denda
    public function Denda()
    {
        return $this->hasMany(Denda::class);
    }


}
