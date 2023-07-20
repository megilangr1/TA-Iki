<?php

namespace App\Http\Livewire\Pos;

use App\Models\Barang;
use App\Models\StokBarang;
use Livewire\Component;

class MainForm extends Component
{
    public $search = null;
    public $toko = null;
    public $gudang = null;
    
    public $pos = [];

    public function updatedPos($value, $key)
    {
        $ex = explode('.', $key);
        if (isset($ex[1]) && $ex[1] == 'jumlah') {
            if ($value <= 0) {
                $this->pos[$ex[0]][$ex[1]] = 1;
            }
        }
    }

    public function updatedToko($value)
    {
        if ($value != null) {
            $this->reset('pos');

            $this->emit('initSelect2Gudang', $this->toko);
        }
    }

    public function updatedGudang($value)
    {
        if ($value != null) {
            $this->reset('pos');
        }
    }

    public function render()
    {
        $getData = [];
        if ($this->toko != null && $this->gudang != null) {
            $getData = Barang::with('harga')->whereHas('harga')->selectRaw('barangs.*, sum(perubahan_stok) as total_stok');

            $getData = $getData->join('stok_barangs', 'stok_barangs.id_barang', '=', 'barangs.id') 
                ->groupBy('id_toko')->groupBy('id_gudang')->groupBy('id_barang')
                ->orderBy('stok_barangs.id_toko', 'ASC')
                ->orderBy('stok_barangs.id_gudang', 'ASC');

            if ($this->toko != null) {$getData = $getData->where('stok_barangs.id_toko', '=', $this->toko); }
            if ($this->gudang != null) { $getData = $getData->where('stok_barangs.id_gudang', '=', $this->gudang); }

            $getData = $getData->havingRaw('sum(perubahan_stok) > ?', [0]);

            if ($this->search != null) {
                $getData = $getData->where('nama_barang', 'like', '%'. $this->search .'%');
            }
    
            $getData = $getData->orderBy('nama_barang')->limit(10)->get();
        }

        return view('livewire.pos.main-form', [
            'dataBarang' => $getData
        ])->layout('backend.layouts.pos');
    }

    public function addBarang($id)
    {
        try {
            $getBarang = Barang::whereHas('harga')->where('id', '=', $id)->firstOrFail();

            if (isset($this->pos[$getBarang->id])) {
                $this->pos[$getBarang->id]['jumlah'] += 1;
            } else {
                $this->pos[$getBarang->id] = [
                    'id_barang' => $getBarang->id,
                    'nama_barang' => $getBarang->nama_barang,
                    'harga' => $getBarang->harga->harga - $getBarang->harga->diskon,
                    'jumlah' => 1
                ];
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function removeBarang($key)
    {
        if (isset($this->pos[$key])) {
            unset($this->pos[$key]);
        }
    }
}
