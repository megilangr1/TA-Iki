<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
use App\Models\StokBarang;
use Livewire\Component;

class ModalStokBarang extends Component
{
    public $barang = [];
    public $stokData = [];

    public $state = [
        'id_toko' => null,
        'id_gudang' => null
    ];

    public $toko = [];
    public $gudang = [];

    public $showFilter = true;

    protected $listeners = [
        'openModalStokBarang'
    ];

    public function updatedState($val, $key)
    {
        if ($key == 'id_toko') {
            if ($this->state['id_toko'] != null) {
                $this->emit('initSelect2Gudang', $this->state['id_toko']);
            }
        }
    }

    public function render()
    {
        return view('livewire.barang.modal-stok-barang');
    }

    public function openModalStokBarang($id)
    {
        $this->reset('barang', 'stokData', 'toko', 'gudang', 'state', 'showFilter');
        try {
            $idToko = null;
            $idGudang = null;
            if (is_array($id)) {
                $idToko = $id['id_toko'] ?? null;
                $idGudang = $id['id_gudang'] ?? null;
                $id = $id['id_barang'];

                $this->showFilter = false;
            }

            $getBarang = Barang::where('id', '=', $id)->firstOrFail();
            $this->barang = $getBarang->toArray();

            $this->loadAllStok($idToko, $idGudang);
            $this->setSelect2();
            $this->emit('stok-barang-modal', 'show');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function loadAllStok($idToko = null, $idGudang = null)
    {
        try {
            $this->reset('stokData');
            $getData = StokBarang::with([
                'barang',
                'toko',
                'gudang'
            ])->groupBy('id_toko')->groupBy('id_gudang')->groupBy('id_barang')
                ->selectRaw('sum(perubahan_stok) as perubahan_stok, id_toko, id_gudang, id_barang')
                ->orderBy('stok_barangs.id_toko', 'ASC')
                ->orderBy('stok_barangs.id_gudang', 'ASC')
                ->where('stok_barangs.id_barang', '=', $this->barang['id']);

            if ($idToko != null) {$getData = $getData->where('stok_barangs.id_toko', '=', $idToko); }

            if ($idGudang != null) { $getData = $getData->where('stok_barangs.id_gudang', '=', $idGudang); }
            $getData = $getData->get();

            $this->stokData['data'] = $getData->toArray();
            $this->setSelect2();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function loadStok()
    {
        if ($this->state['id_toko'] && $this->state['id_gudang'] && $this->barang != null) {
            $this->reset('stokData');
            try {
                $getData = StokBarang::with(['toko', 'gudang'])
                    ->orderBy('id', 'ASC')
                    ->where('id_toko', '=', $this->state['id_toko'])
                    ->where('id_gudang', '=', $this->state['id_gudang'])
                    ->where('id_barang', '=', $this->barang['id'])
                    ->get();

                $totalStok = $getData->sum('perubahan_stok');

                $result = [
                    'data' => $getData->toArray(),
                    'totalStok' => $totalStok
                ];

                $this->stokData = $result;
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    public function setSelect2()
    {
        $data = [
            'toko' => [
                'selectId' => 'toko',
                'value' => '',
                'option' => []
            ],
            
            'gudang' => [
                'selectId' => 'gudang',
                'value' => '',
                'option' => []
            ]
        ];

        $this->emit('setSelect2', $data);
    }

    public function dummy()
    {
        dd([$this->barang, $this->showFilter]);
    }
}
