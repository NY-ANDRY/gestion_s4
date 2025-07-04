<?php

namespace App\Livewire\Compta;

use Livewire\Component;
use App\Models\Compta\Compta_ecritures;
use App\Models\Compta\Compta_exercices;
use App\Models\Compta\Compta_journaux;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Ecritures extends Component
{
    public $ecritures;
    public $journaux;
    public $exercice;
    public $num_update;
    public $updating;

    public $isEdit;

    public $new_piece_reference = '';
    public $new_libelle_ecriture = '';
    public $new_journal_code = '';
    public $new_id_exercice = '';
    public $journaux_search = [];

    public $search_value;

    public $update_libelle_ecriture = '';
    public $update_journal_code = '';
    public $update_id_exercice = '';
    public $update_date_ecriture = '';

    public function mount()
    {
        $this->journaux = Compta_journaux::all()->sortBy('code_journal');
        $this->exercice = Compta_exercices::getCurrent();

        if (empty($this->exercice)) {
            session()->flash('error', 'exercice non defini');
            return;
        }

        $this->updateTable1();
    }

    public function updateTable1()
    {
        if (!empty($this->exercice?->id)) {
            $data = Compta_ecritures::getByExerciceId($this->exercice->id);
            $this->ecritures = Compta_ecritures::convertData($data);
        }
    }

    public function delete($id)
    {
        $compte = Compta_ecritures::find($id);
        if ($compte) {
            $compte->delete();
            session()->flash('status', 'Compte successfully deleted.');
        } else {
            session()->flash('error', 'Compte not found.');
        }
        $this->updateTable1();
    }

    public function save()
    {
        $this->validate([
            'new_libelle_ecriture' => 'required',
            'new_journal_code' => 'required'
        ]);
        Compta_ecritures::create([
            'id_exercice' => $this->exercice->id,
            'libelle_ecriture' => $this->new_libelle_ecriture,
            'journal_code' => $this->new_journal_code
        ]);
        session()->flash('status', 'Compte successfully created.');
        $this->reset(['new_libelle_ecriture', 'new_journal_code']);
        $this->updateTable1();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;
        $cur_ecriture = Compta_ecritures::find($id);
        $this->update_libelle_ecriture = $cur_ecriture->libelle_ecriture;
        $this->update_journal_code = $cur_ecriture->journal_code;
        $this->update_date_ecriture = $cur_ecriture->date_ecriture;
    }

    public function updateOne()
    {
        $this->validate([
            'update_libelle_ecriture' => 'required',
            'update_journal_code' => 'required'
        ]);
        $new_compte = Compta_ecritures::find($this->num_update);
        if ($new_compte) {
            $new_compte->update([
                'date_ecriture' => $this->update_date_ecriture,
                'journal_code' => $this->update_journal_code,
                'libelle_ecriture' => $this->update_libelle_ecriture,
            ]);
            session()->flash('status', 'Compte successfully updated.');
        } else {
            session()->flash('error', 'Compte not found.');
        }

        $this->updating = false;
        $this->updateTable1();
    }

    public function updateClose()
    {
        $this->updating = false;
        $this->reset(['update_journal_code', 'update_libelle_ecriture', 'update_journal_code']);
    }

    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
        $this->new_id_exercice = $this->exercice->nom;
    }

    public function doFilter()
    {
        $value = $this->search_value;

        if (!empty($value)) {
            $data = Compta_ecritures::searchByValue($value);
            $this->ecritures = Compta_ecritures::convertData($data);
        } else {
            $this->updateTable1();
        }
    }

    public function searchJournal($value)
    {
        if (empty($value) && $value != 0) {
            $this->journaux_search = [];
        } else {
            $result = [];
            foreach ($this->journaux as $journal) {
                if (str_contains(strtolower($journal->code_journal), strtolower($value))) {
                    $result[] = $journal;
                }
            }
            $this->journaux_search = $result;
        }
    }

    public function searchJournalForNew()
    {
        $this->searchJournal($this->new_journal_code);
    }
    public function searchJournalForUpdate()
    {
        $this->searchJournal($this->update_journal_code);
    }

    public function setNew_journal_code($nom)
    {
        $this->new_journal_code = $nom;
        $this->journaux_search = [];
    }

    public function setUpdate_journal_code($nom)
    {
        $this->update_journal_code = $nom;
        $this->journaux_search = [];
    }
}
