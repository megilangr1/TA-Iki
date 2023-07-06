<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengirimanBarangDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_pengiriman_barang',
        'id_barang',
        'jumlah',
        'keterangan',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }
}
