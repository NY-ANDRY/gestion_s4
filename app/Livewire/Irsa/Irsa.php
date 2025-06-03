<?php

namespace App\Livewire\Irsa;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Irsa\Irsa_dettes;

#[Layout('components.layouts.irsa')]
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

}
