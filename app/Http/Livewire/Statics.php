<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Statics extends Component
{
    public function mount($counts)
    {
        $this->counts = $counts;
    }

    public function render()
    {
        $counts = $this->counts;
        return view('livewire.statics', compact('counts'));
    }
}
