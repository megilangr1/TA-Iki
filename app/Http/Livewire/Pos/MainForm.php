<?php

namespace App\Http\Livewire\Pos;

use App\Models\Barang;
use App\Models\Pos;
use App\Models\PosDetail;
use App\Models\StokBarang;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $search = null;
    public $toko = null;
    public $gudang = null;
    
    public $pos = [];

    public $total = 0;

    public function updatedPos($value, $key)
    {
        $ex = explode('.', $key);
        if (isset($ex[1]) && $ex[1] == 'jumlah') {
            if ($value <= 0) {
                $this->pos[$ex[0]][$ex[1]] = 1;
            }
        }

        $this->sumTotal();
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

            $this->sumTotal();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function removeBarang($key)
    {
        if (isset($this->pos[$key])) {
            unset($this->pos[$key]);

            $this->sumTotal();
        }
    }

    public function sumTotal()
    {
        $total = 0;
        foreach ($this->pos as $key => $value) {
            $total += (double) $value['harga'] * (double) $value['jumlah'];
        }

        $this->total = $total;
    }

    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'toko' => 'required|exists:tokos,id',
            'gudang' => 'required|exists:gudangs,id',
            'pos' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $save = true;
            $invStok = [];

            foreach ($this->pos as $key => $value) {
                $getBarang = Barang::where('id', '=', $value['id_barang'])->firstOrFail();
                $getStokBarang = StokBarang::groupBy('id_toko')->groupBy('id_gudang')->groupBy('id_barang')
                    ->selectRaw('sum(perubahan_stok) as sisa_stok')
                    ->orderBy('stok_barangs.id_toko', 'ASC')
                    ->orderBy('stok_barangs.id_gudang', 'ASC')
                    ->where('stok_barangs.id_barang', '=', $value['id_barang'])
                    ->where('stok_barangs.id_toko', '=', $this->toko)
                    ->where('stok_barangs.id_gudang', '=', $this->gudang);
                $getStokBarang = $getStokBarang->firstOrFail();

                $stok = $getStokBarang->sisa_stok;
                $jumlah = (double) $value['jumlah'];

                if ($jumlah > $stok) {
                    $this->emit('error', 'Stok Untuk Barang ' . $value['nama_barang'] . ' Tidak Mencukupi Untuk Transaksi !');
                    $save = false;
                } else {
                    $invStok[$getBarang->id] = [
                        'jenis_transaksi' => 2,
                        'id_transaksi' => null,
                        'id_transaksi_detail' => null,
                        'id_toko' => $this->toko,
                        'id_gudang' => $this->gudang,
                        'id_barang' => $getBarang->id,
                        'nominal_stok' => $jumlah,
                        'perubahan_stok' => -1 * $jumlah,

                        'harga' => $value['harga'],
                        'sub_total' => ($value['harga'] * $jumlah),
                    ];
                }
            }


            if ($save) {
                $createPos = Pos::create([
                    'tanggal_transaksi' => now(),
                    'user_id' => auth()->user()->id,
                    'id_toko' => $this->toko,
                    'id_gudang' => $this->gudang,
                ]);

                foreach ($invStok as $key => $value) {
                    $createDetail = PosDetail::create([
                        'id_pos' => $createPos->id,
                        'id_barang' => $value['id_barang'],
                        'jumlah' => $value['nominal_stok'],
                        'harga' => $value['harga'],
                        'sub_total' => $value['sub_total'],
                    ]);

                    $invData = $value;
                    $invData['id_transaksi'] = $createPos->id;
                    $invData['id_transaksi_detail'] = $createDetail->id;
                    unset($invData['harga'], $invData['sub_total']);

                    $insertStok = StokBarang::create($invData);

                    DB::commit();
                    $this->emit('success', 'Transaksi Berhasil di-Catatan dan Di-Simpan !');
                    $this->reset('pos', 'total');
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
