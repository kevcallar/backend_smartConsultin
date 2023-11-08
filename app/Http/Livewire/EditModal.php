<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditModal extends Component
{
    public $adviser;
    public function render()
    {
        return view('livewire.edit-modal');
    }
}
