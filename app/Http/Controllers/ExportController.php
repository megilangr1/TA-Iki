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
        return Excel::download(new PosExport, 'pos.xlsx');
    }
}
