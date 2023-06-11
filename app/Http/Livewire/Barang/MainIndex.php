<?php

namespace App\Http\Livewire\Barang;

use App\Models\Barang;
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
        'id_kategori' => null,
        'nama_barang' => null,
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
        $getData = Barang::with('kategori')->orderBy('created_at', 'ASC')->paginate('10');

        return view('livewire.barang.main-index', [
            'dataBarang' => $getData
        ])->layout('backend.layouts.master');
    }

    public function showForm($show, $data = [])
    {
        $this->resetErrorBag();
        $this->reset('state');
        $this->form = $show;
        $this->state = $this->params;
        $select2Data = [
            'value' => '',
            'option' => null
        ];

        if ($data != null) {
            $this->state['id'] = $data['id'];
            $this->state['nama_barang'] = $data['nama_barang'];
            $this->state['keterangan'] = $data['keterangan'];

            if ($data['kategori'] != null) {
                $this->state['id_kategori'] = $data['id_kategori']; 

                $select2Data['value'] = $data['id_kategori'];
                $select2Data['option'] = [
                    'value' => $data['kategori']['id'],
                    'text' => $data['kategori']['nama_kategori'] 
                ];
            }
        }

        $this->emit('setSelect2', $select2Data);
    }
    
    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.id_kategori' => 'required|numeric|exists:kategoris,id',
            'state.nama_barang' => 'required|string',
            'state.keterangan' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $createData = Barang::create([
                'id_kategori' => $this->state['id_kategori'],
                'nama_barang' => $this->state['nama_barang'],
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
            $getData = Barang::with('kategori')->where('id', '=', $id)->firstOrFail();

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
            'state.id_kategori' => 'required|numeric|exists:kategoris,id',
            'state.nama_barang' => 'required|string',
            'state.keterangan' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $getData = Barang::where('id', '=', $this->state['id'])->firstOrFail();

            $updateData = $getData->update([
                'id_kategori' => $this->state['id_kategori'],
                'nama_barang' => $this->state['nama_barang'],
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
            $getData = Barang::where('id', '=', $id)->firstOrFail();
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
            $getData = Barang::onlyTrashed()->where('id', '=', $id)->firstOrFail();
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
