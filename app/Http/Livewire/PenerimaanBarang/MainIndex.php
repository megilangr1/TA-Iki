<?php

namespace App\Http\Livewire\PenerimaanBarang;

use Livewire\Component;

class MainIndex extends Component
{
    public function render()
    {
        return view('livewire.penerimaan-barang.main-index')
            ->layout('backend.layouts.master');
    }
}
