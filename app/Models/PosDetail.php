<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_pos',
        'id_barang',
        'jumlah',
        'harga',
        'sub_total',
    ];
}
