<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'tb_log_aktivitas';

    protected $fillable = ['id_user', 'aktivitas', 'waktu_aktivitas'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
