<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ExpenseModal extends Component
{

    public $expenses;
    public function render()
    {
        return view('livewire.expense-modal');
    }
}
