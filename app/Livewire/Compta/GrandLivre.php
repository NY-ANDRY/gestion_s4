<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_comptes;
use App\Models\Compta\Compta_exercices;
use App\Models\Compta\Compta_grandLivre;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.compta')]
class GrandLivre extends Component
{
    public $debitResult = 0;
    public $creditResult = 0;
    public $id_exercice = 5, $exercice;
    public $comptes;

    public $total;

    public function mount()
    {
        $this->exercice = Compta_exercices::where('en_cours', true)->first();
        $this->id_exercice = $this->exercice->id;
        $this->comptes = Compta_comptes::getAllOrdered();

        $this->total = Compta_grandLivre::getTotalSoldeAll($this->id_exercice);
    }

}
