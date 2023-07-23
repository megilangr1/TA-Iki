<?php

namespace App\Http\Livewire\Kategori;

use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MainIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $form = false;

    public $state = [];
    public $params = [
        'id' => null,
        'nama_kategori' => null,
        'keterangan' => null,
    ];

    protected $listeners = [
        'restoreData'
    ];

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        $getData = Kategori::orderBy('created_at', 'ASC')->paginate('10');

        return view('livewire.kategori.main-index', [
            'dataKategori' => $getData
        ])->layout('backend.layouts.master');
    }

    public function showForm($show, $data = [])
    {
        $this->resetErrorBag();
        $this->reset('state');
        $this->form = $show;
        $this->state = $this->params;

        if ($data != null) {
            $this->state['id'] = $data['id'];
            $this->state['nama_kategori'] = $data['nama_kategori'];
            $this->state['keterangan'] = $data['keterangan'];
        }
    }
    
    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.nama_kategori' => 'required|string|unique:kategoris,nama_kategori',
            'state.keterangan' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'unique' => 'Data Tersebut Sudah Ada!',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $createData = Kategori::create([
                'nama_kategori' => $this->state['nama_kategori'],
                'keterangan' => $this->state['keterangan']
            ]);

            DB::commit();
            $this->emit('success', 'Data Berhasil di-Tambahkan !');
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
            $getData = Kategori::where('id', '=', $id)->firstOrFail();

            $this->showForm(true, $getData->toArray());
        } catch (\Exception $e) {
            dd($e);
            abort(404);
        }
    }

    public function updateData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.nama_kategori' => 'required|string|unique:kategoris,nama_kategori,'. $this->state['id'],
            'state.keterangan' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'unique' => 'Data Tersebut Sudah Ada !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $getData = Kategori::where('id', '=', $this->state['id'])->firstOrFail();

            $updateData = $getData->update([
                'nama_kategori' => $this->state['nama_kategori'],
                'keterangan' => $this->state['keterangan']
            ]);
            
            DB::commit();
            $this->emit('info', 'Perubahan Data Berhasil di-Simpan !');
            $this->showForm(false);
        } catch (\Exception $e) {
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            DB::rollBack();
            dd($e);
        }
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = Kategori::where('id', '=', $id)->firstOrFail();
            $deleteData = $getData->delete();

            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function restoreData($id)
    {
        DB::beginTransaction();
        try {
            $getData = Kategori::onlyTrashed()->where('id', '=', $id)->firstOrFail();
            $restoreData = $getData->restore();

            DB::commit();
            $this->emit('info', 'Data di-Pulihkan !');
            $this->showForm(false);
            $this->emitTo('component.modal-trashed-data', 'refreshData'); 
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }
}
