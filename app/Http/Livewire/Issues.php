<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Issues extends Component
{
	/**
	 *  NOTE! These public methods allow for variables to be pased.
	 */
	public $issues;
	public $VotingSession;
	public $votes;

    public function render()
    {
        return view('livewire.issues');
    }
}
