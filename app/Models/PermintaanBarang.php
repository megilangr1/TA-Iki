<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermintaanBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_toko',
        'id_gudang',
        'id_toko_tujuan',
        'id_gudang_tujuan',
        'tanggal_permintaan',
        'keterangan',
        'status'
    ];

    public function detail()
    {
        return $this->hasMany(PermintaanBarangDetail::class, 'id_permintaan_barang', 'id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang', 'id');
    }

    public function toko_tujuan()
    {
        return $this->belongsTo(Toko::class, 'id_toko_tujuan', 'id');
    }

    public function gudang_tujuan()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang_tujuan', 'id');
    }
}
