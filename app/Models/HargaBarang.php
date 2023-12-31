<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HargaBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_barang',
        'tanggal_harga',
        'harga',
        'diskon',
        'keterangan'
    ];
}
