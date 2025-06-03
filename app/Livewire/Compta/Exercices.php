<?php

namespace App\Livewire\Compta;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Exercices extends Component
{
    public function render()
    {
        return view('livewire.compta.exercices');
    }
}
