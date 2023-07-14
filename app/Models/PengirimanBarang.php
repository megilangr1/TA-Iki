<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengirimanBarang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_permintaan',
        'id_toko',
        'id_gudang',
        'id_toko_tujuan',
        'id_gudang_tujuan',
        'tanggal_pengiriman',
        'keterangan',
        'status',
    ];

    public function detail()
    {
        return $this->hasMany(PengirimanBarangDetail::class, 'id_pengiriman_barang', 'id');
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

    public function permintaanBarang()
    {
        return $this->belongsTo(PermintaanBarang::class, 'id_permintaan', 'id');
    }

    public function penerimaanBarang()
    {
        return $this->hasOne(PenerimaanBarang::class, 'id_pengiriman', 'id');
    }
}
