<?php

namespace App\Http\Livewire\Pos;

use App\Models\Pos;
use Livewire\Component;

class MainIndex extends Component
{
    public function render()
    {
        $getData = Pos::with('detail')->paginate(10);

        return view('livewire.pos.main-index', [
            'dataPos' => $getData
        ]);
    }
}
