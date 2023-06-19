<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_pengiriman',
        'id_toko',
        'id_gudang',
        'tanggal_penerimaan',
        'keterangan',
        'status',
    ];

    public function detail()
    {
        return $this->hasMany(PenerimaanBarangDetail::class, 'id_penerimaan_barang', 'id');
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
