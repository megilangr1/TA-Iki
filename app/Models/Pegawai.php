<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_toko',
        'nama_pegawai',
        'id_user'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function toko() {
        return $this->belongsTo(Toko::class, 'id_toko', 'id');
    }
}
