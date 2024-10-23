<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReasonFormSwitcher extends Component
{
    public $selectedReason = ''; // Track the selected reason

    // Renders the view when data changes
    public function render()
    {
        return view('livewire.reason-form-switcher');
    }
}
