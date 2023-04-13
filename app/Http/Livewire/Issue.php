<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Log;

use Livewire\Component;

class Issue extends Component
{
	public $issue;

    public function render()
    {
        return view('livewire.issue');
    }
}
