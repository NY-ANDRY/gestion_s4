<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

use App\Models\Irsa_dettes;

class Irsa extends Component
{
    public $montant;
    public $total_dettes;

    public function test()
    {
        $this->total_dettes = $this->montant;
    }

    public function calcul() {
        $irsa_model = new Irsa_dettes();
        $result = $irsa_model->calculDettes($this->montant);

        $this->total_dettes = $result;
    }

    #[Layout('components.layouts.irsa')]
    public function render()
    {
        return view('livewire.irsa');
    }
}
