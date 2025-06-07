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
    public $total = [
        'debit' => 0,
        'credit' => 0
    ];

    public function mount()
    {
        $this->comptes = Compta_comptes::getAllOrdered();
        $this->exercice = Compta_exercices::where('en_cours', true)->first();

        if (empty($this->exercice)) {
            session()->flash('error', 'exercice non defini');
            return;
        }

        $this->id_exercice = $this->exercice->id;
        $this->total = Compta_grandLivre::getTotalSoldeAll($this->id_exercice);
    }
}
