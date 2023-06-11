<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toko extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_toko',
        'alamat_toko'
    ];
}
