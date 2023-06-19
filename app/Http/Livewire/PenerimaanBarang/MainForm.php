<?php

namespace App\Http\Livewire\PenerimaanBarang;

use App\Models\Barang;
use App\Models\PenerimaanBarang;
use App\Models\PenerimaanBarangDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $state = [];
    public $params = [
        'id' => null,

        'id_toko' => null,
        'id_gudang' => null,
        
        'tanggal_penerimaan' => null,
        'keterangan' => null,

        'detail' => [],
    ];

    public $barang = null;

    protected $listeners = [
        'resetSelect2Barang'
    ];

    public function updatedState($value, $key)
    {
        if ($key == 'id_toko') {
            if ($this->state['id_toko'] != null) {
                $this->emit('initSelect2Gudang', $this->state['id_toko']);
            }
        }

        $ex = explode('.', $key);
        if (count($ex) > 0) {
            $this->resetErrorBag('state.'. $ex[0]);
            
            if ($ex[0] == 'detail' && $ex[2] == 'jumlah') {
                $this->resetErrorBag('state.'. $ex[0] . '.' . $ex[1] . '.' . $ex[2]);
                $this->state[$ex[0]][$ex[1]][$ex[2]] = (double) $value > 0 ? (double) $value : 0;
            }
        }
    }

    public function updatedBarang($id)
    {
        if ($id != null) {
            try {
                $getData = Barang::where('id', '=', $id)->firstOrFail();

                if (isset($this->state['detail'][$id])) {
                    $this->state['detail'][$id]['jumlah'] = (double) $this->state['detail'][$id]['jumlah'] + 1; 
                } else {
                    $this->state['detail'][$id] = [
                        'id_barang' => $getData->id,
                        'nama_barang' => $getData->nama_barang,
                        'jumlah' => 0,
                        'keterangan' => null,
                    ];
                }
            } catch (\Exception $e) {
                $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Pilih Ulang Data ! atau, <br> Silahkan Hubungi Administrator !');
            }
    
            // $this->emit('resetSelect2Barang');
        }
    }

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        return view('livewire.penerimaan-barang.main-form');
    }

    public function removeDetail($key)
    {
        if (isset($this->state['detail'][$key])) {
            unset($this->state['detail'][$key]);
        }
    }

    public function dummy()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.id_toko' => 'required|exists:tokos,id',
            'state.id_gudang' => 'required|exists:gudangs,id',
            'state.tanggal_penerimaan' => 'required|date',
            'state.keterangan' => 'nullable|string',
            
            'state.detail' => 'required|array',
            'state.detail.*.id_barang' => 'required|exists:barangs,id',
            'state.detail.*.jumlah' => 'required|numeric|min:1',
            'state.detail.*.keterangan' => 'nullable|string',
        ], [
            'required' => 'Input / Data Tidak Boleh Kosong !',
            'date' => 'Format Input Harus Berupa Tanggal !',
        ]);
        
        DB::beginTransaction();
        try {
            $insertHeader = PenerimaanBarang::create([
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang'],
                'tanggal_penerimaan' => date('Y-m-d', strtotime($this->state['tanggal_penerimaan'])),
                'keterangan' => $this->state['keterangan'],
                'status' => false,
            ]);

            foreach ($this->state['detail'] as $key => $value) {
                $insertDetail = PenerimaanBarangDetail::create([
                    'id_penerimaan_barang' => $insertHeader->id,
                    'id_barang' => $value['id_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                ]);
            }

            DB::commit();
            session()->flash('success', 'Data Transaksi Penerimaan Berhasil di-Buat !');
            return redirect()->route('penerimaan-barang.index');
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
