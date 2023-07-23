<?php

namespace App\Http\Controllers;

use App\Exports\PosExport;
use App\Models\Pos;
use Illuminate\Http\Request;
use Excel;

class ExportController extends Controller
{
    public function export()
    {
        // $getData = Pos::with([
        //     'toko',
        //     'gudang',
        //     'user'
        //     ])->withCount('detail')->withSum('detail', 'sub_total')->get();
        // dd($getData->toArray());
        return Excel::download(new PosExport, 'pos.xlsx');
    }
}
