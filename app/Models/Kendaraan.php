<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'tb_kendaraan';

    protected $fillable = ['plat_nomor', 'jenis_kendaraan', 'warna', 'pemilik', 'id_user'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function transaksis() {
        return $this->hasMany(Transaksi::class, 'id_kendaraan');
    }
}
