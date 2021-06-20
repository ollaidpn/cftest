<?php

namespace App\Http\Livewire\AddFormation;

use Livewire\Component;

class Index extends Component
{
    public $selectedTab = 'details';

    public function selectTab($tab)
    {
        $this->selectedTab = $tab;
        $this->emit('scrollTop');
    }

    public function mount()
    {
        session()->forget('actual_formation');
    }

    public function render()
    {
        return view('livewire.formation.index');
    }
}
