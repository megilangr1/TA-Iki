<?php

namespace App\Http\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        'id_user' => null,
        'nama_pegawai' => null,
        
        'id_toko' => null,

        'email' => null,
        'password' => null,
        'password_confirmation' => null,
    ];

    protected $listeners = [
        'restoreData'
    ];

    public function mount() {
        $this->state = $this->params;
    }

    public function render()
    {
        $getData = Pegawai::with('user')->orderBy('created_at', 'ASC')->paginate(10);
        return view('livewire.pegawai.main-index', [
            'dataPegawai' => $getData
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
            $this->state['id_user'] = $data['id_user'];
            $this->state['nama_pegawai'] = $data['nama_pegawai'];
            $this->state['email'] = $data['user']['email'];
            
            if ($data['toko'] != null) {
                $this->state['id_toko'] = $data['id_toko'];
                
                $select2Data['value'] = $data['id_toko'];
                $select2Data['option'] = [
                    'value' => $data['toko']['id'],
                    'text' => $data['toko']['nama_toko']
                ];
            }
        }

        $this->emit('setSelect2', $select2Data);
    }

    public function createData()
    {
        $this->resetErrorBag();
        $this->validate([
            'state.nama_pegawai' => 'required|string',
            'state.email' => 'required|email|unique:users,email',
            'state.password' => 'required|string|confirmed'
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Alphanumerik !',
            'confirmed' => 'Konfirmasi Password Tidak Sesuai !',
            'email' => 'Format Input Harus Berupa Email !'
        ]);

        DB::beginTransaction();

        try {
            $addUser = User::create([
                'name' => $this->state['nama_pegawai'],
                'email' => $this->state['email'],
                'password' => Hash::make($this->state['password'])
            ]);

            $addPegawai = Pegawai::create([
                'id_toko' => $this->state['id_toko'],
                'nama_pegawai' => $this->state['nama_pegawai'],
                'id_user' => $addUser->id
            ]);

            DB::commit();
            $this->emit('success', 'Data Berhasil Disimpan !');
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
            $getData = Pegawai::with(['user', 'toko'])->where('id', '=', $id)->firstOrFail();

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
            'state.nama_pegawai' => 'required|string',
            'state.email' => 'required|email',
            'state.password' => 'nullable|string|confirmed'
        ], [
            'required' => 'Input Tidak Boleh Kosong !',
            'string' => 'Format Input Harus Berupa Alphanumerik !',
            'confirmed' => 'Konfirmasi Password Tidak Sesuai !',
            'email' => 'Format Input Harus Berupa Email !'
        ]);

        DB::beginTransaction();
        try {
            $getPegawai = Pegawai::where('id', '=', $this->state['id'])->firstOrFail();
            $getUser = User::where('id', '=', $getPegawai->id_user)->firstOrFail();
            $password = $getUser->password;

            if ($this->state['password'] != null) {
                $password = Hash::make($this->state['password']);
            }

            $updatePegawai = $getPegawai->update([
                'id_toko' => $this->state['id_toko'],
                'nama_pegawai' => $this->state['nama_pegawai'],
                'id_user' => $getUser->id,
            ]);

            $updateUser = $getUser->update([
                'name' => $this->state['nama_pegawai'],
                'email' => $this->state['email'],
                'password' => $password
            ]);

            DB::commit();
            $this->emit('success', 'Data Berhasil Di Ubah');
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
            dd($e);
        }
    }

    public function deleteData($id)
    {
        DB::beginTransaction();
        try {
            $getData = Pegawai::where('id', '=', $id)->firstOrFail();
            $getUser = User::where('id', '=', $getData->id_user)->firstOrFail();
            $deleteData = $getData->delete();
            $deleteUser = $getUser->delete();

            DB::commit();
            $this->emit('warning', 'Data di-Hapus !');
            $this->showForm(false);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
        }
    }

    public function restoreData($id)
    {
        DB::beginTransaction();
        try {
            $getPegawai = Pegawai::onlyTrashed()->where('id', '=', $id)->firstOrFail();
            $getUser = User::onlyTrashed()->where('id', '=', $getPegawai->id_user)->firstOrFail();

            $restorePegawai = $getPegawai->restore();
            $restoreUser = $getUser->restore();

            DB::commit();

            $this->emit('info', 'Data Dipulihkan !');
            $this->showForm(false);
            $this->emitTo('component.modal-trashed-data', 'refreshData');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
        }
    }
}
