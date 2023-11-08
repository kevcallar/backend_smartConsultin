<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InvoiceModal extends Component
{

    public $invoices;
    public function render()
    {
        return view('livewire.invoice-modal');
    }
}
