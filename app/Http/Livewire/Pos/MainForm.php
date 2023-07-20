<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;

class MainForm extends Component
{
    public function render()
    {
        return view('livewire.pos.main-form')->layout('backend.layouts.pos');
    }
}
