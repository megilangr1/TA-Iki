<?php

namespace App\Exports;

use App\Models\Pos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PosExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        

        return view('export.pos', [
            'pos' => Pos::with([
                'toko',
                'gudang',
                'user'
                ])->withCount('detail')->withSum('detail', 'sub_total')->get()
        ]);
    }
}
