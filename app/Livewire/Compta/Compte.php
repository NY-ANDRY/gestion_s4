<?php
namespace App\Livewire\Compta;

use App\Models\Compta\Compta_comptes;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Compte extends Component
{
    public $comptes;
    public $num_update, $updating, $isEdit;
    public $label_numero_compte = "code";

    public $new_numero_compte = '', $new_intitule = '', $new_classe = '';
    public $update_numero_compte = '', $update_intitule = '', $update_classe = '';
    public $search_value;

    public function mount()
    {
        $this->loadComptes();
    }

    public function loadComptes()
    {
        $this->comptes = Compta_comptes::getAllOrdered();
    }

    public function delete($id)
    {
        $compte = Compta_comptes::find($id);
        if ($compte) {
            $compte->delete();
            session()->flash('status', 'Compte supprimé.');
        } else {
            session()->flash('error', 'Compte introuvable.');
        }
        $this->loadComptes();
    }

    public function save()
    {
        $this->validate([
            'new_numero_compte' => 'required|max:4',
            'new_intitule' => 'required',
            'new_classe' => 'required|max:1',
        ]);

        if (Compta_comptes::existsWithNumero($this->new_numero_compte)) {
            session()->flash('error', "Compte déjà existant.");
            return;
        }

        if ($this->new_classe !== substr($this->new_numero_compte, 0, 1)) {
            session()->flash('error', "Le numéro ne correspond pas à la classe.");
            return;
        }

        Compta_comptes::create([
            'numero_compte' => $this->new_numero_compte,
            'intitule' => $this->new_intitule,
            'classe' => $this->new_classe,
        ]);

        session()->flash('status', 'Compte créé.');
        $this->reset(['new_numero_compte', 'new_intitule', 'new_classe']);
        $this->loadComptes();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;

        $compte = Compta_comptes::find($id);
        $this->update_numero_compte = $compte->numero_compte;
        $this->update_intitule = $compte->intitule;
        $this->update_classe = $compte->classe;
    }

    public function updateOne()
    {
        $this->validate([
            'update_numero_compte' => 'required|max:4',
            'update_intitule' => 'required',
            'update_classe' => 'required|max:1',
        ]);

        if (Compta_comptes::existsWithNumero($this->update_numero_compte, $this->num_update)) {
            session()->flash('error', "Compte déjà existant.");
            return;
        }

        if ($this->update_classe !== substr($this->update_numero_compte, 0, 1)) {
            session()->flash('error', "Numéro invalide pour cette classe.");
            return;
        }

        $compte = Compta_comptes::find($this->num_update);
        if (!$compte) {
            session()->flash('error', 'Compte non trouvé.');
            return;
        }

        $compte->update([
            'numero_compte' => $this->update_numero_compte,
            'intitule' => $this->update_intitule,
            'classe' => $this->update_classe,
        ]);

        session()->flash('status', 'Compte mis à jour.');
        $this->updating = false;
        $this->loadComptes();
    }

    public function updateClose()
    {
        $this->updating = false;
        $this->reset(['update_numero_compte', 'update_intitule', 'update_classe']);
    }

    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
    }

    public function doFilter()
    {
        if (!empty($this->search_value)) {
            $this->comptes = Compta_comptes::search($this->search_value);
        } else {
            $this->loadComptes();
        }
    }
}
