<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;

class ModalStokBarang extends Component
{
    public $barang = [];

    public $form = false;
    public $state = [];
    public $params = [
        'id' => null,
        'tanggal_harga' => null,
        'harga' => "0",
        'diskon' => "0",
        'keterangan' => null
    ];

    protected $listeners = [
        'openGudangModal'
    ];

    public function updatedState($value, $key)
    {
        if ($key == 'diskon') {
            $harga = (double) str_replace(',', '.', str_replace('.', '', $this->state['harga']));
            $diskon = (double) str_replace(',', '.', str_replace('.', '', $this->state['diskon']));

            if ($diskon > $harga) {
                $diskon = $harga;
                $this->state['diskon'] = $this->state['harga'];
            }
        }
    }

    public function discount($val)
    {
        $harga = (double) str_replace(',', '.', str_replace('.', '', $this->state['harga']));
        if ($harga != 0) {
            $this->state['diskon'] = number_format(($harga * $val) / 100, 0, ',', '.');
        }
    }

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        return view('livewire.barang.modal-stok-barang');
    }

    public function openGudangModal($id)
    {
        $this->reset('barang', 'state');
        $this->state = $this->params;

        $this->getBarang($id);

        $this->emit('harga-barang-modal', 'show');
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

    public function showForm($show, $data = [])
    {
        $this->reset('state');
        $this->state = $this->params;

        $this->form = $show;

        if ($data != null) {
            $this->state['id'] = $data['id'];
            
            $this->state['tanggal_harga'] = date('Y-m-d', strtotime($data['tanggal_harga'])); 
            $this->state['harga'] = number_format($data['harga'], 2, ',', '.'); 
            $this->state['diskon'] = number_format($data['diskon'], 2, ',', '.'); 
            $this->state['keterangan'] = $data['keterangan']; 
        }
    }

    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.tanggal_harga' => 'required|date|after:yesterday',
            'state.harga' => 'required|string', 
            'state.diskon' => 'required|string', 
            'state.keterangan' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !',
            'date' => 'Format Input Harus Berupa Tanggal (YYYY-MM-DD) !',
            'after' => 'Tanggal Tidak Boleh Kurang Dari Hari Ini ! (' . date('Y-m-d') . ')',
        ]);

        DB::beginTransaction();
        try {
            $harga = (double) str_replace(',', '.', str_replace('.', '', $this->state['harga']));
            $diskon = (double) str_replace(',', '.', str_replace('.', '', $this->state['diskon']));

            $createData = HargaBarang::create([
                'id_barang' => $this->barang['id'],
                'tanggal_harga' => $this->state['tanggal_harga'],
                'harga' => $harga,
                'diskon' => $diskon,
                'keterangan' => $this->state['keterangan']
            ]);

            DB::commit();
            $this->emit('success', 'Data Berhasil di-Tambahkan !');
            $this->getBarang($this->barang['id']);
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function editData($id)
    {
        try {
            $getData = HargaBarang::where('id', '=', $id)->firstOrFail();

            $this->showForm(true, $getData->toArray());
        } catch (\Exception $e) {
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function updateData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.tanggal_harga' => 'required|date|after:yesterday',
            'state.harga' => 'required|string', 
            'state.diskon' => 'required|string', 
            'state.keterangan' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !',
            'date' => 'Format Input Harus Berupa Tanggal (YYYY-MM-DD) !',
            'after' => 'Tanggal Tidak Boleh Kurang Dari Hari Ini ! (' . date('Y-m-d') . ')',
        ]);

        DB::beginTransaction();
        try {
            $harga = (double) str_replace(',', '.', str_replace('.', '', $this->state['harga']));
            $diskon = (double) str_replace(',', '.', str_replace('.', '', $this->state['diskon']));

            $getData = HargaBarang::where('id', '=', $this->state['id'])->firstOrFail();
            $updateData = $getData->update([
                'tanggal_harga' => $this->state['tanggal_harga'],
                'harga' => $harga,
                'diskon' => $diskon,
                'keterangan' => $this->state['keterangan']
            ]);

            DB::commit();
            $this->emit('info', 'Perubahan Data di-Simpan !');
            $this->getBarang($this->barang['id']);
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = HargaBarang::where('id', '=', $id)->firstOrFail();

            $deleteData = $getData->delete();
            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
            $this->getBarang($this->barang['id']);
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function restoreData($id)
    {
        DB::beginTransaction();
        try {
            $getData = HargaBarang::onlyTrashed()->where('id', '=', $id)->firstOrFail();

            $restoreData = $getData->restore();
            DB::commit();
            $this->emit('info', 'Data di-Pulihkan !');
            $this->getBarang($this->barang['id']);
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollback();
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
