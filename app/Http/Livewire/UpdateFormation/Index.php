<?php

namespace App\Http\Livewire\UpdateFormation;

use Livewire\Component;

class Index extends Component
{
    public $formation, $selectedTab = 'details';

    public function mount($formation)
    {
        $this->formation = $formation;
        session()->forget('actual_formation');
    }

    public function selectTab($tab)
    {
        $this->selectedTab = $tab;
        $this->emit('scrollTop');
    }

    public function render()
    {
        return view('livewire.formation.update-formation.index');
    }
}
