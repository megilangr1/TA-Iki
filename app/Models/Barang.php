<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_kategori', 
        'nama_barang',
        'keterangan'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function harga()
    {
        return $this->hasOne(HargaBarang::class, 'id_barang', 'id')->orderBy('tanggal_harga', 'DESC')->orderBy('created_at', 'DESC');
    }

    public function hargaWithTrashed()
    {
        return $this->hasMany(HargaBarang::class, 'id_barang', 'id')->withTrashed()->orderBy('tanggal_harga', 'DESC')->orderBy('created_at', 'DESC');
    }
}
