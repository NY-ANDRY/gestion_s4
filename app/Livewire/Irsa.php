<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Irsa extends Component
{

    #[Layout('components.layouts.irsa')]
    public function render()
    {
        return view('livewire.irsa');
    }
}
