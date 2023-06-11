<?php

namespace App\Http\Livewire\Toko;

use App\Models\Gudang;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalGudangToko extends Component
{
    public $toko = [];

    public $form = false;
    public $state = [];
    public $params = [
        'id' => null,
        'nama_gudang' => null,
        'alamat_gudang' => null
    ];

    protected $listeners = [
        'openGudangModal'
    ];

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        return view('livewire.toko.modal-gudang-toko');
    }

    public function openGudangModal($id)
    {
        $this->reset('toko', 'state');
        $this->state = $this->params;

        $this->getToko($id);

        $this->emit('gudang-toko-modal', 'show');
    }

    public function getToko($id)
    {
        try {
            $getData = Toko::with('gudangWithTrashed')->where('id', '=', $id)->firstOrFail();

            $this->toko = $getData->toArray();
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
            $this->state['nama_gudang'] = $data['nama_gudang'];
            $this->state['alamat_gudang'] = $data['alamat_gudang'];
        }
    }

    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.nama_gudang' => 'required|string',
            'state.alamat_gudang' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $createData = Gudang::create([
                'id_toko' => $this->toko['id'],
                'nama_gudang' => $this->state['nama_gudang'],
                'alamat_gudang' => $this->state['alamat_gudang']
            ]);

            DB::commit();
            $this->emit('success', 'Data Berhasil di-Tambahkan !');
            $this->getToko($this->toko['id']);
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
            $getData = Gudang::where('id', '=', $id)->firstOrFail();

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
            'state.nama_gudang' => 'required|string',
            'state.alamat_gudang' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $getData = Gudang::where('id', '=', $this->state['id'])->firstOrFail();
            $updateData = $getData->update([
                'nama_gudang' => $this->state['nama_gudang'],
                'alamat_gudang' => $this->state['alamat_gudang']
            ]);

            DB::commit();
            $this->emit('info', 'Perubahan Data di-Simpan !');
            $this->getToko($this->toko['id']);
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
            $getData = Gudang::where('id', '=', $id)->firstOrFail();

            $deleteData = $getData->delete();
            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
            $this->getToko($this->toko['id']);
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
            $getData = Gudang::onlyTrashed()->where('id', '=', $id)->firstOrFail();

            $restoreData = $getData->restore();
            DB::commit();
            $this->emit('info', 'Data di-Pulihkan !');
            $this->getToko($this->toko['id']);
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollback();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function dummy()
    {
        dd($this->toko);
    }
}
