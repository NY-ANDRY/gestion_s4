<?php
namespace App\Livewire\Compta;

use App\Models\Compta\Compta_journaux;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Journaux extends Component
{
    public $journaux;
    public $num_update, $updating, $isEdit;

    public $new_code_journal = '', $new_libelle = '';
    public $update_code_journal = '', $update_libelle = '';
    public $search_value;

    public function mount()
    {
        $this->loadJournaux();
    }

    public function loadJournaux()
    {
        $this->journaux = Compta_journaux::getAllOrdered();
    }

    public function delete($id)
    {
        $journal = Compta_journaux::find($id);

        if ($journal) {
            $journal->delete();
            session()->flash('status', 'Journal supprimé.');
        } else {
            session()->flash('error', 'Journal introuvable.');
        }

        $this->loadJournaux();
    }

    public function save()
    {
        $this->validate([
            'new_code_journal' => 'required',
            'new_libelle' => 'required',
        ]);

        if (Compta_journaux::existsWithCode($this->new_code_journal)) {
            session()->flash('error', "Le journal '{$this->new_code_journal}' existe déjà.");
            return;
        }

        Compta_journaux::create([
            'code_journal' => $this->new_code_journal,
            'libelle' => $this->new_libelle,
        ]);

        session()->flash('status', 'Journal créé avec succès.');
        $this->reset(['new_code_journal', 'new_libelle']);
        $this->loadJournaux();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;

        $journal = Compta_journaux::find($id);
        $this->update_code_journal = $journal->code_journal;
        $this->update_libelle = $journal->libelle;
    }

    public function updateOne()
    {
        $this->validate([
            'update_code_journal' => 'required',
            'update_libelle' => 'required',
        ]);

        if (Compta_journaux::existsWithCode($this->update_code_journal, $this->num_update)) {
            session()->flash('error', "Ce code journal existe déjà.");
            return;
        }

        $journal = Compta_journaux::find($this->num_update);
        if (!$journal) {
            session()->flash('error', 'Journal non trouvé.');
            return;
        }

        $journal->update([
            'code_journal' => $this->update_code_journal,
            'libelle' => $this->update_libelle,
        ]);

        session()->flash('status', 'Journal mis à jour.');
        $this->updating = false;
        $this->loadJournaux();
    }

    public function updateClose()
    {
        $this->updating = false;
        $this->reset(['update_code_journal', 'update_libelle']);
    }

    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
    }

    public function doFilter()
    {
        if (!empty($this->search_value)) {
            $this->journaux = Compta_journaux::search($this->search_value);
        } else {
            $this->loadJournaux();
        }
    }
}
