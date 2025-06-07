<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_comptes;
use App\Models\Compta\Compta_exercices;
use App\Models\Compta\Compta_grandLivre;
use Carbon\Carbon;
use Livewire\Component;

class Livre extends Component
{
    public $exercice;
    public $fin_exercice;
    public $compte;
    public $mouvements = [];
    public $total = [
        'debit' => 0,
        'credit' => 0
    ];
    public $solde = [
        'debit' => 0,
        'credit' => 0
    ];

    public function mount($id_exercice, $numero_compte)
    {
        Carbon::setLocale('fr');

        $this->exercice = Compta_exercices::find($id_exercice);

        if (empty($this->exercice)) {
            session()->flash('error', 'exercice non defini');
            return;
        }
        $this->fin_exercice = Carbon::parse($this->exercice['date_fin'])->translatedFormat('j F Y');
        $this->compte = Compta_comptes::where('numero_compte', $numero_compte)->first();

        $this->mouvements = Compta_grandLivre::getFromExerciceCompte($id_exercice, $numero_compte);
        $this->mouvements = $this->formatMouvement($this->mouvements);
        $total_solde = Compta_grandLivre::getTotalSolde($id_exercice, $numero_compte);
        $this->total = $total_solde['total'];
        $this->solde = $total_solde['solde'];
    }


    public function formatMouvement($data)
    {
        Carbon::setLocale('fr');
        return $data->map(fn($e) => [
            'id' => $e->id,
            'date_ecriture' =>  Carbon::parse($e->date_ecriture)->translatedFormat('j F Y'),
            'libelle_ligne' => $e->libelle_ligne,
            'debit' => $e->debit,
            'credit' => $e->credit
        ]);
    }
}
