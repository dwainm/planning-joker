<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Issues extends Component
{
	public $issues;

    public function render()
    {
        return view('livewire.issues');
    }
}
