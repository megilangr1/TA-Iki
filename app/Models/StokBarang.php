<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jenis_transaksi',
        'id_transaksi',
        'id_transaksi_detail',
        'id_toko',
        'id_gudang',
        'id_barang',
        'nominal_stok',
        'perubahan_stok',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang', 'id');
    }
}
