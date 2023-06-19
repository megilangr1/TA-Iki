<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kategori;
use App\Models\Toko;
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

    public function dataToko(Request $request)
    {
			$getData = new Toko();
			if ($request->search != null) {
				$getData = $getData->where(function($q) use ($request) {
					$q->where('nama_toko', 'like', '%'. $request->search .'%');
				});
			}

			$getData = $getData->orderBy('nama_toko', 'ASC')->limit(10)->get()->toArray();
			return response()->json($getData);
    }

    public function dataToko(Request $request)
    {
        $getData = new Toko();

        if ($request->search != null) {
            $getData = $getData->where(function($q) use ($request) {
                $q->where('nama_toko', 'like', '%'. $request->search .'%');
            });
        }
        
        $getData = $getData->orderBy('nama_toko', 'ASC')->limit(10)->get()->toArray();
        return response()->json($getData);
    }

    public function dataGudang(Request $request)
    {
        $getData = new Gudang();

        if ($request->id_toko != null) {
            $getData = $getData->where('id_toko', '=', $request->id_toko);
        }

        if ($request->search != null) {
            $getData = $getData->where(function($q) use ($request) {
                $q->where('nama_gudang', 'like', '%'. $request->search .'%');
            });
        }

        $getData = $getData->orderBy('nama_gudang', 'ASC')->limit(10)->get()->toArray();
        return response()->json($getData);
    }

    public function dataBarang(Request $request)
    {
        $getData = new Barang();

        if ($request->search != null) {
            $getData = $getData->where(function($q) use ($request) {
                $q->where('nama_barang', 'like', '%'. $request->search .'%');
            });
        }

        $getData = $getData->orderBy('nama_barang', 'ASC')->limit(10)->get()->toArray();
        return response()->json($getData);
    }
}
