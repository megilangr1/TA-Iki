<?php

namespace App\Http\Livewire\Pegawai;

use Livewire\Component;

class ModalDetail extends Component
{

    public $pegawai = [];

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
        'openDetailModal'
    ];

    public function mount()
    {
        $this->state = $this->params;
    }

    public function render()
    {
        return view('livewire.pegawai.modal-detail');
    }

    public function openDetailModal($id)
    {
        
    }
}
