<?php

namespace App\Livewire;

use App\Models\Batch;
use Livewire\Component;

class PrintLabelPreview extends Component
{
    public $formData = [];

    protected $listeners = [
        'form-updated' => 'formUpdated',
        'print' => 'print'
    ];

    public function formUpdated($data)
    {
        $this->formData = $data['formData']; // Acessa os dados do evento
    }


    public function print()
    {
        $this->dispatch('print-content');
    }

    public function render()
    {
        return view('livewire.print-label-preview');
    }


}
