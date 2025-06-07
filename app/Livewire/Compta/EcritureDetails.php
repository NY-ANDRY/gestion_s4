<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_ecritures;
use App\Models\Compta\Compta_exercices;
use App\Models\Compta\Compta_journaux;
use App\Models\Compta\Compta_lignes_ecritures;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class EcritureDetails extends Component
{
    public $id_ecriture;
    public $ecriture;
    public $journal;
    public $exercice;
    public $total_debit;
    public $total_credit;

    public function mount($id)
    {
        $this->id_ecriture = $id;
        $this->ecriture = $this->convertData(Compta_ecritures::find($id));
        $this->journal = Compta_journaux::where("code_journal", $this->ecriture['journal_code'])->first();
        $this->exercice = Compta_exercices::find($this->ecriture['id_exercice']);
        $this->setTotal();
    }

    #[On('updateDetails')]
    public function setTotal()
    {
        $this->total_debit = Compta_lignes_ecritures::where('id_ecriture', $this->id_ecriture)
            ->where('debit', '>', 0)
            ->sum('debit');
        $this->total_credit = Compta_lignes_ecritures::where('id_ecriture', $this->id_ecriture)
            ->where('credit', '>', 0)
            ->sum('credit');
    }

    public function convertData($ecriture)
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
