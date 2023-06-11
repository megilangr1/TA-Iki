<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class AjaxDataController extends Controller
{
    
    public function dataKategori(Request $request)
    {
        $getData = new Kategori();
        if ($request->search != null) {
            $getData = $getData->where(function($q) use ($request) {
                $q->where('nama_kategori', 'like', '%'. $request->search .'%');
            });
        }

        $getData = $getData->orderBy('nama_kategori', 'ASC')->limit(10)->get()->toArray();
        return response()->json($getData);
    }
}
