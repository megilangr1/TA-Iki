<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use Livewire\Component;

class ModalStokBarang extends Component
{
    public $barang = [];

    protected $listeners = [
        'openModalStokBarang'
    ];

    public function render()
    {
        return view('livewire.barang.modal-stok-barang');
    }

    public function openModalStokBarang($id)
    {
        $this->reset('barang');
        $this->getBarang($id);

        $this->emit('stok-barang-modal', 'show');
    }

    public function getBarang($id)
    {
        try {
            $getData = Barang::with('hargaWithTrashed')->where('id', '=', $id)->firstOrFail();

            $this->barang = $getData->toArray();
        } catch (\Exception $e) {
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function dummy()
    {
        // $getData = Barang::with('harga')->where('id', '=', $this->barang['id'])->firstOrFail();
        dd($this->state);
    }

}
