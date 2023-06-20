<?php

namespace App\Http\Livewire\PenerimaanBarang;

use App\Models\Barang;
use App\Models\PenerimaanBarang;
use App\Models\PenerimaanBarangDetail;
use App\Models\StokBarang;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $penerimaanBarang = [];

    public $state = [];
    public $params = [
        'id' => null,

        'id_toko' => null,
        'id_gudang' => null,
        
        'tanggal_penerimaan' => null,
        'keterangan' => null,

        'detail' => [],
    ];
    public $dirty = false;

    public $barang = null;

    protected $listeners = [
        'resetSelect2Barang'
    ];

    public function updatedState($value, $key)
    {
        $this->dirty = true;
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
            $this->dirty = true;
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

    public function mount($id = null)
    {
        $this->state = $this->params;
        if ($id != null) {
            $this->getPenerimaan($id);
        }
    }

    public function render()
    {
        return view('livewire.penerimaan-barang.main-form');
    }

    public function getPenerimaan($id)
    {
        try {
            $getData = PenerimaanBarang::with([
                'detail',
                'detail.barang',
                'toko',
                'gudang'
            ])->where('id', '=', $id)->firstOrFail();

            $this->penerimaanBarang = $getData->toArray();

            $this->state['id'] = $getData->id;
            $this->state['id_toko'] = $getData->id_toko;
            $this->state['id_gudang'] = $getData->id_gudang;
            $this->state['tanggal_penerimaan'] = date('Y-m-d', strtotime($getData->tanggal_penerimaan));
            $this->state['keterangan'] = $getData->keterangan;

            foreach ($getData->detail as $key => $value) {
                $this->state['detail'][$value->id_barang] = [
                    'id_barang' => $value->id_barang,
                    'nama_barang' => $value->barang->nama_barang,
                    'jumlah' => $value->jumlah,
                    'keterangan' => $value->keterangan,
                ];
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function removeDetail($key)
    {
        if (isset($this->state['detail'][$key])) {
            unset($this->state['detail'][$key]);
        }
    }

    public function createData()
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
            return redirect()->route('penerimaan-barang.detail', $insertHeader->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function resetInput()
    {
        $id = $this->penerimaanBarang;
        $this->reset('dirty', 'state', 'penerimaanBarang');
        $this->state = $this->params;
        $this->getPenerimaan($id);
    }
    
    public function updateData()
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
            $getHeader = PenerimaanBarang::where('id', '=', $this->penerimaanBarang['id'])->firstOrFail();

            $updateHeader = $getHeader->update([
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang'],
                'tanggal_penerimaan' => date('Y-m-d', strtotime($this->state['tanggal_penerimaan'])),
                'keterangan' => $this->state['keterangan'],
                'status' => false,
            ]);
            $deleteDetail = $getHeader->detail()->delete();

            foreach ($this->state['detail'] as $key => $value) {
                $insertDetail = PenerimaanBarangDetail::create([
                    'id_penerimaan_barang' => $getHeader->id,
                    'id_barang' => $value['id_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                ]);
            }

            DB::commit();
            session()->flash('success', 'Perubahan Data Transaksi Penerimaan Berhasil di-Simpan !');
            return redirect()->route('penerimaan-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function confirmData()
    {
        DB::beginTransaction();
        try {
            $getHeader = PenerimaanBarang::whereHas('detail')
                ->whereHas('gudang')
                ->whereHas('toko')
                ->where('id', '=', $this->penerimaanBarang['id'])
                ->firstOrFail();

            $insertData = [];
            foreach ($getHeader->detail as $key => $value) {
                $insertData[] = [
                    'id_transaksi' => $getHeader->id,
                    'id_transaksi_detail' => $value->id,
                    'id_toko' => $getHeader->id_toko,
                    'id_gudang' => $getHeader->id_gudang,
                    'id_barang' => $value->id_barang,
                    'nominal_stok' => $value->jumlah,
                    'perubahan_stok' => $value->jumlah,
                ];
            }

            $insertStok = StokBarang::insert($insertData);
            $updateHeader = $getHeader->update([
                'status' => true
            ]);
            DB::commit();
            $this->emit('success', 'Transaksi Penerimaan Barang di-Konfirmasi !');
            return redirect()->route('penerimaan-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function dummy()
    {
        dd($this->state);
    }
}
