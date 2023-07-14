<?php

namespace App\Http\Livewire\PermintaanBarang;

use App\Models\Barang;
use App\Models\PermintaanBarangDetail;
use App\Models\PermintaanBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $permintaanBarang = [];

    public $state = [];
    public $params = [
        'id' => null,

        'id_toko' => null,
        'id_gudang' => null,
        
        'id_toko_tujuan' => null,
        'id_gudang_tujuan' => null,
        
        'tanggal_permintaan' => null,
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

        if ($key == 'id_toko_tujuan') {
            if ($this->state['id_toko_tujuan'] != null) {
                $this->emit('initSelect2GudangTujuan', $this->state['id_toko_tujuan']);
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
            $this->getPermintaan($id);
        }
    }

    public function render()
    {
        return view('livewire.permintaan-barang.main-form');
    }

    public function getPermintaan($id)
    {
        try {
            $getData = PermintaanBarang::with([
                'detail',
                'detail.barang',
                'toko',
                'gudang',
                'toko_tujuan',
                'gudang_tujuan',
                'pengirimanBarang'
            ])->where('id', '=', $id)->firstOrFail();

            $this->permintaanBarang = $getData->toArray();

            $this->state['id'] = $getData->id;
            $this->state['id_toko'] = $getData->id_toko;
            $this->state['id_gudang'] = $getData->id_gudang;
            $this->state['id_toko_tujuan'] = $getData->id_toko_tujuan;
            $this->state['id_gudang_tujuan'] = $getData->id_gudang_tujuan;
            $this->state['tanggal_permintaan'] = date('Y-m-d', strtotime($getData->tanggal_permintaan));
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
            $this->dirty = true;
        }
    }

    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.id_toko' => 'required|exists:tokos,id',
            'state.id_gudang' => 'required|exists:gudangs,id',

            'state.id_toko_tujuan' => 'required|exists:tokos,id',
            'state.id_gudang_tujuan' => 'required|exists:gudangs,id',

            'state.tanggal_permintaan' => 'required|date',
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
            $insertHeader = PermintaanBarang::create([
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang'],
                'id_toko_tujuan' => $this->state['id_toko_tujuan'],
                'id_gudang_tujuan' => $this->state['id_gudang_tujuan'],
                'tanggal_permintaan' => date('Y-m-d', strtotime($this->state['tanggal_permintaan'])),
                'keterangan' => $this->state['keterangan'],
                'status' => false,
            ]);

            foreach ($this->state['detail'] as $key => $value) {
                $insertDetail = PermintaanBarangDetail::create([
                    'id_permintaan_barang' => $insertHeader->id,
                    'id_barang' => $value['id_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
            session()->flash('success', 'Data Transaksi Permintaan Berhasil di-Buat !');
            return redirect()->route('permintaan-barang.detail', $insertHeader->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function resetInput()
    {
        $id = $this->permintaanBarang;
        $this->reset('dirty', 'state', 'permintaanBarang');
        $this->state = $this->params;
        $this->getPermintaan($id);
    }
    
    public function updateData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.id_toko' => 'required|exists:tokos,id',
            'state.id_gudang' => 'required|exists:gudangs,id',
            'state.id_toko_tujuan' => 'required|exists:tokos,id',
            'state.id_gudang_tujuan' => 'required|exists:gudangs,id',
            'state.tanggal_permintaan' => 'required|date',
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
            $getHeader = PermintaanBarang::where('id', '=', $this->permintaanBarang['id'])->firstOrFail();

            $updateHeader = $getHeader->update([
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang'],
                'id_toko_tujuan' => $this->state['id_toko_tujuan'],
                'id_gudang_tujuan' => $this->state['id_gudang_tujuan'],
                'tanggal_permintaan' => date('Y-m-d', strtotime($this->state['tanggal_permintaan'])),
                'keterangan' => $this->state['keterangan'],
                'status' => false,
            ]);
            $deleteDetail = $getHeader->detail()->delete();

            foreach ($this->state['detail'] as $key => $value) {
                $insertDetail = PermintaanBarangDetail::create([
                    'id_permintaan_barang' => $getHeader->id,
                    'id_barang' => $value['id_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
            session()->flash('success', 'Perubahan Data Transaksi Permintaan Berhasil di-Simpan !');
            return redirect()->route('permintaan-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function confirmData()
    {
        DB::beginTransaction();
        try {
            $getHeader = PermintaanBarang::whereHas('detail')
                ->whereHas('gudang')
                ->whereHas('toko')
                ->whereHas('toko_tujuan')
                ->whereHas('gudang_tujuan')
                ->where('id', '=', $this->permintaanBarang['id'])
                ->firstOrFail();

            $updateHeader = $getHeader->update([
                'status' => true
            ]);
            DB::commit();
            session()->flash('success', 'Transaksi Permintaan Barang di-Konfirmasi !');
            return redirect()->route('permintaan-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function cancelData()
    {
        DB::beginTransaction();
        try {
            $getHeader = PermintaanBarang::whereHas('detail')
                ->whereHas('gudang')
                ->whereHas('toko')
                ->whereHas('toko_tujuan')
                ->whereHas('gudang_tujuan')
                ->where('id', '=', $this->permintaanBarang['id'])
                ->firstOrFail();

            $updateHeader = $getHeader->update([
                'status' => 2
            ]);
            DB::commit();
            session()->flash('success', 'Transaksi Permintaan Barang di-Batalkan !');
            return redirect()->route('permintaan-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function dummy()
    {
        dd($this->permintaanBarang);
    }
}
