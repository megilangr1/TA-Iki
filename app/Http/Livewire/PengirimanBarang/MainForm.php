<?php

namespace App\Http\Livewire\PengirimanBarang;

use App\Models\Barang;
use App\Models\PengirimanBarang;
use App\Models\PengirimanBarangDetail;
use App\Models\PermintaanBarang;
use App\Models\StokBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MainForm extends Component
{
    public $pengirimanBarang = [];
    public $permintaanBarang = [];

    public $state = [];
    public $params = [
        'id' => null,
        'id_permintaan_barang' => null,

        'id_toko' => null,
        'id_gudang' => null,
        
        'id_toko_tujuan' => null,
        'id_gudang_tujuan' => null,
        
        'tanggal_pengiriman' => null,
        'keterangan' => null,

        'detail' => [],
    ];
    public $dirty = false;

    public $barang = null;

    protected $listeners = [
        'resetSelect2Barang',
        'selectedPermintaanBarang'
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
                dd("OK");
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
            $this->getPengiriman($id);
        }
    }

    public function render()
    {
        return view('livewire.pengiriman-barang.main-form');
    }

    public function getPengiriman($id)
    {
        try {
            $getData = PengirimanBarang::with([
                'detail',
                'detail.barang',
                'toko',
                'gudang',
                'toko_tujuan',
                'gudang_tujuan',
                'permintaanBarang',
                'permintaanBarang.toko',
                'permintaanBarang.gudang',
                'permintaanBarang.toko_tujuan',
                'permintaanBarang.gudang_tujuan',
            ])->where('id', '=', $id)->firstOrFail();

            $this->pengirimanBarang = $getData->toArray();

            $this->state['id'] = $getData->id;
            $this->state['id_toko'] = $getData->id_toko;
            $this->state['id_gudang'] = $getData->id_gudang;
            $this->state['id_toko_tujuan'] = $getData->id_toko_tujuan;
            $this->state['id_gudang_tujuan'] = $getData->id_gudang_tujuan;
            $this->state['tanggal_pengiriman'] = date('Y-m-d', strtotime($getData->tanggal_pengiriman));
            $this->state['keterangan'] = $getData->keterangan;

            foreach ($getData->detail as $key => $value) {
                $this->state['detail'][$value->id_barang] = [
                    'id_barang' => $value->id_barang,
                    'nama_barang' => $value->barang->nama_barang,
                    'jumlah' => $value->jumlah,
                    'keterangan' => $value->keterangan,
                ];
            }

            if ($getData->permintaanBarang != null) {
                $this->state['id_permintaan_barang'] = $getData->permintaanBarang->id;
                $this->permintaanBarang = $getData->permintaanBarang->toArray();
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function openModalStok($id)
    {
        if ($this->state['id_toko'] != null && $this->state['id_gudang'] != null) {
            $this->emitTo('barang.modal-stok-barang', 'openModalStokBarang', [
                'id_barang' => $id,
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang']
            ]);
        } else {
            $this->emit('warning', 'Silahkan Pilih Asal Toko & Asal Gudang Terlebih Dahulu !');
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
            'state.id_permintaan_barang' => 'nullable|exists:permintaan_barangs,id',
            'state.id_toko' => 'required|exists:tokos,id',
            'state.id_gudang' => 'required|exists:gudangs,id',

            'state.id_toko_tujuan' => 'required|exists:tokos,id',
            'state.id_gudang_tujuan' => 'required|exists:gudangs,id',

            'state.tanggal_pengiriman' => 'required|date',
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
            if ($this->state['id_permintaan_barang'] != null) {
                $checkPermintaan = PermintaanBarang::where('id', '=', $this->state['id_permintaan_barang'])->firstOrFail();
            }

            $insertHeader = PengirimanBarang::create([
                'id_permintaan' => $this->state['id_permintaan_barang'],
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang'],
                'id_toko_tujuan' => $this->state['id_toko_tujuan'],
                'id_gudang_tujuan' => $this->state['id_gudang_tujuan'],
                'tanggal_pengiriman' => date('Y-m-d', strtotime($this->state['tanggal_pengiriman'])),
                'keterangan' => $this->state['keterangan'],
                'status' => false,
            ]);

            foreach ($this->state['detail'] as $key => $value) {
                $insertDetail = PengirimanBarangDetail::create([
                    'id_pengiriman_barang' => $insertHeader->id,
                    'id_barang' => $value['id_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
            session()->flash('success', 'Data Transaksi Pengiriman Berhasil di-Buat !');
            return redirect()->route('pengiriman-barang.detail', $insertHeader->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function resetInput()
    {
        $id = $this->pengirimanBarang;
        $this->reset('dirty', 'state', 'pengirimanBarang');
        $this->state = $this->params;
        $this->getPengiriman($id);
    }
    
    public function updateData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.id_toko' => 'required|exists:tokos,id',
            'state.id_gudang' => 'required|exists:gudangs,id',
            'state.id_toko_tujuan' => 'required|exists:tokos,id',
            'state.id_gudang_tujuan' => 'required|exists:gudangs,id',
            'state.tanggal_pengiriman' => 'required|date',
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
            $getHeader = PengirimanBarang::where('id', '=', $this->pengirimanBarang['id'])->firstOrFail();

            $updateHeader = $getHeader->update([
                'id_toko' => $this->state['id_toko'],
                'id_gudang' => $this->state['id_gudang'],
                'id_toko_tujuan' => $this->state['id_toko_tujuan'],
                'id_gudang_tujuan' => $this->state['id_gudang_tujuan'],
                'tanggal_pengiriman' => date('Y-m-d', strtotime($this->state['tanggal_pengiriman'])),
                'keterangan' => $this->state['keterangan'],
                'status' => false,
            ]);
            $deleteDetail = $getHeader->detail()->delete();

            foreach ($this->state['detail'] as $key => $value) {
                $insertDetail = PengirimanBarangDetail::create([
                    'id_pengiriman_barang' => $getHeader->id,
                    'id_barang' => $value['id_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::commit();
            session()->flash('success', 'Perubahan Data Transaksi Pengiriman Berhasil di-Simpan !');
            return redirect()->route('pengiriman-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function confirmData()
    {
        DB::beginTransaction();
        try {
            $getHeader = PengirimanBarang::whereHas('detail')
                ->whereHas('gudang')
                ->whereHas('toko')
                ->whereHas('toko_tujuan')
                ->whereHas('gudang_tujuan')
                ->where('id', '=', $this->pengirimanBarang['id'])
                ->firstOrFail();
            
            $canConfirm = true;
            foreach ($getHeader->detail as $key => $value) {
                $checkStok = StokBarang::where('id_toko', '=', $getHeader->id_toko)
                    ->where('id_gudang', '=', $getHeader->id_gudang)
                    ->where('id_barang', '=', $value->id_barang)
                    ->sum('perubahan_stok');

                if ($checkStok >= $value->jumlah) {
                    $insertData[] = [
                        'jenis_transaksi' => 2,
                        'id_transaksi' => $getHeader->id,
                        'id_transaksi_detail' => $value->id,
                        'id_toko' => $getHeader->id_toko,
                        'id_gudang' => $getHeader->id_gudang,
                        'id_barang' => $value->id_barang,
                        'nominal_stok' => $value->jumlah,
                        'perubahan_stok' => -1 * $value->jumlah,
                    ];
                } else {
                    $canConfirm = false;
                }
            }

            if (!$canConfirm) {
                $this->emit('error', 'Tidak Dapat Mengkonfirmasi Pengiriman ! <br> Data Stok Salah Satu Barang Tidak Cukup ! <br> Silahkan Periksa Kembali Data !');
            } else {
                $insertStok = StokBarang::insert($insertData);
                $updateHeader = $getHeader->update([
                    'status' => true
                ]);
                DB::commit();
                session()->flash('success', 'Transaksi Pengiriman Barang di-Konfirmasi !');
                return redirect()->route('pengiriman-barang.detail', $getHeader->id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function cancelData()
    {
        DB::beginTransaction();
        try {
            $getHeader = PengirimanBarang::whereHas('detail')
                ->whereHas('gudang')
                ->whereHas('toko')
                ->whereHas('toko_tujuan')
                ->whereHas('gudang_tujuan')
                ->where('id', '=', $this->pengirimanBarang['id'])
                ->firstOrFail();

            $deleteStok = StokBarang::where('jenis_transaksi', '=', 2)->where('id_transaksi', '=', $getHeader->id)->delete();
            $updateHeader = $getHeader->update([
                'status' => 2
            ]);
            DB::commit();
            session()->flash('success', 'Transaksi Pengiriman Barang di-Batalkan !');
            return redirect()->route('pengiriman-barang.detail', $getHeader->id);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function openModalPermintaanBarang()
    {
        $data = [
            'props' => 'show',
        ];
        $this->emitTo('permintaan-barang.modal-data', 'openModalDataPermintaan', $data);
    }

    public function selectedPermintaanBarang($data)
    {
        if ($data != null) {
            $this->state = $this->params;
            $this->permintaanBarang = $data;

            $this->state['id_permintaan_barang'] = $data['id'];
            $this->state['id_toko'] = $data['id_toko_tujuan'];
            $this->state['id_gudang'] = $data['id_gudang_tujuan'];
            $this->state['id_toko_tujuan'] = $data['id_toko'];
            $this->state['id_gudang_tujuan'] = $data['id_gudang'];
            $this->state['tanggal_pengiriman'] = null;
            $this->state['keterangan'] = null;

            foreach ($data['detail'] as $key => $value) {
                $this->state['detail'][$value['id_barang']] = [
                    'id_barang' => $value['id_barang'],
                    'nama_barang' => $value['barang']['nama_barang'],
                    'jumlah' => $value['jumlah'],
                    'keterangan' => $value['keterangan'],
                ];
            }
        }
    }

    public function resetForm()
    {
        $this->reset('permintaanBarang', 'state');
        $this->state = $this->params;
    }

    public function dummy()
    {
        dd($this->state);
    }
}
