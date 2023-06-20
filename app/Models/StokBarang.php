<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_transaksi',
        'id_transaksi_detail',
        'id_toko',
        'id_gudang',
        'id_barang',
        'nominal_stok',
        'perubahan_stok',
    ];
}
