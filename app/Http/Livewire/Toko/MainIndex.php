<?php

namespace App\Http\Livewire\Toko;

use App\Models\Toko;
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
        'nama_toko' => null,
        'alamat_toko' => null,
    ];

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        $getData = Toko::orderBy('created_at', 'ASC')->paginate('10');

        return view('livewire.toko.main-index', [
            'dataToko' => $getData
        ]);
    }

    public function showForm($show, $data = [])
    {
        $this->resetErrorBag();
        $this->reset('state');
        $this->form = $show;
        $this->state = $this->params;

        if ($data != null) {
            $this->state['id'] = $data['id'];
            $this->state['nama_toko'] = $data['nama_toko'];
            $this->state['alamat_toko'] = $data['alamat_toko'];
        }
    }
    
    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.nama_toko' => 'required|string',
            'state.alamat_toko' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $createData = Toko::create([
                'nama_toko' => $this->state['nama_toko'],
                'alamat_toko' => $this->state['alamat_toko']
            ]);

            DB::commit();
            $this->emit('success', 'Data Toko Berhasil di-Tambahkan !');
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
            $getData = Toko::where('id', '=', $id)->firstOrFail();

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
            'state.nama_toko' => 'required|string',
            'state.alamat_toko' => 'nullable|string', 
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Aplhanumerik !'
        ]);

        DB::beginTransaction();
        try {
            $getData = Toko::where('id', '=', $this->state['id'])->firstOrFail();

            $updateData = $getData->update([
                'nama_toko' => $this->state['nama_toko'],
                'alamat_toko' => $this->state['alamat_toko']
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
            $getData = Toko::where('id', '=', $id)->firstOrFail();
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
}
