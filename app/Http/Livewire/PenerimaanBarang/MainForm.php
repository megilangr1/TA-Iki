<?php

namespace App\Http\Livewire\PenerimaanBarang;

use Livewire\Component;

class MainForm extends Component
{
    public $state = [];
    public $params = [
        'id' => null,
        'tanggal_penerimaan' => null,
    ];

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        return view('livewire.penerimaan-barang.main-form');
    }
}
