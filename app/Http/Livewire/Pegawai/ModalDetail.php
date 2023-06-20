<?php

namespace App\Http\Livewire\Pegawai;

use App\Models\Pegawai;
use Livewire\Component;

class ModalDetail extends Component
{

    public $pegawai = [];

    public $form = false;

    protected $listeners = [
        'openDetailModal'
    ];

    public function render()
    {
        return view('livewire.pegawai.modal-detail');
    }

    public function openDetailModal($id)
    {
        $this->getPegawai($id);

        $this->emit('modal-detail', 'show');
    }

    public function getPegawai($id)
    {
        try {
            $getPegawai = Pegawai::with('user', 'toko')->where('id', '=' , $id)->firstOrFail();
            $this->pegawai = $getPegawai->toArray();
        } catch (\Exception $e) {
            dd($e);
            $this->emit('error', 'Terjadi Kesalahan ! <br> Silahkan Hubungi Administrator !');
        }
    }

    public function dummy()
    {
        dd($this->pegawai);
    }
}
