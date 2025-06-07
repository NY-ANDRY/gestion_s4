<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_ecritures;
use App\Models\Compta\Compta_exercices;
use App\Models\Compta\Compta_journaux;
use Carbon\Carbon;
use Livewire\Component;

class EcritureDetails extends Component
{
    public $id_ecriture;
    public $ecriture;
    public $journal;
    public $exercice;

    public function mount($id)
    {
        $this->id_ecriture = $id;
        $this->ecriture = $this->convertDataEcriture(Compta_ecritures::find($id));
        $this->journal = Compta_journaux::where("code_journal", $this->ecriture['journal_code'])->first();
        $this->exercice = Compta_exercices::find($this->ecriture['id_exercice']);
    }
    public function convertDataEcriture($ecriture)
    {
        Carbon::setLocale('fr');
        return [
            'id' => $ecriture->id,
            'date_ecriture' => Carbon::parse($ecriture->date_ecriture)->translatedFormat('j F Y'),
            'libelle_ecriture' => $ecriture->libelle_ecriture,
            'journal_code' => $ecriture->journal_code,
            'id_exercice' => $ecriture->id_exercice
        ];
    }
}
