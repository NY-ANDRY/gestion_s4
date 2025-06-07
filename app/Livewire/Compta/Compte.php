<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_comptes;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.compta')]
class Compte extends Component
{

    public $comptes;
    public $num_update;
    public $updating;
    public $label_numero_compte = "code";

    public $isEdit;

    public $new_numero_compte = '';
    public $new_intitule = '';
    public $new_classe = '';

    public $search_value;

    public $update_numero_compte = '';
    public $update_intitule = '';
    public $update_classe = '';


    public function mount()
    {
        $this->updateTable1();
    }

    public function updateTable1()
    {
        $this->comptes = Compta_comptes::all()->sortBy('numero_compte')->sortBy('classe');
    }

    public function delete($id)
    {
        $compte = Compta_comptes::find($id);
        if (!empty($compte)) {
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
            'new_numero_compte' => 'required|max:4',
            'new_intitule' => 'required',
            'new_classe' => 'required|max:1',
        ]);

        $exist = Compta_comptes::where('numero_compte', $this->new_numero_compte)->first();

        if ($exist) {
            session()->flash('error', "Compte '{$exist->numero_compte}: {$exist->intitule}' existe déjà.");
            return;
        }

        if ($this->new_classe !== substr($this->new_numero_compte, 0, 1)) {
            session()->flash('error', "{$this->label_numero_compte} {$this->new_numero_compte} ne convient pas à la classe {$this->new_classe}.");
            return;
        }

        Compta_comptes::create([
            'numero_compte' => $this->new_numero_compte,
            'intitule' => $this->new_intitule,
            'classe' => $this->new_classe,
        ]);

        session()->flash('status', 'Compte successfully created.');

        $this->reset(['new_numero_compte', 'new_intitule', 'new_classe']);
        $this->updateTable1();
    }


    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;
        $cur_compte = Compta_comptes::find($id);
        $this->update_numero_compte = $cur_compte->numero_compte;
        $this->update_intitule = $cur_compte->intitule;
        $this->update_classe = $cur_compte->classe;
    }

    public function updateOne()
    {
        $this->validate([
            'update_numero_compte' => 'required|max:4',
            'update_intitule' => 'required',
            'update_classe' => 'required|max:1',
        ]);

        $exist = Compta_comptes::where('numero_compte', $this->update_numero_compte)
            ->where('id', '!=', $this->num_update)
            ->first();

        if ($exist) {
            session()->flash('error', "Compte '{$exist->numero_compte}: {$exist->intitule}' existe déjà.");
            return;
        }

        if ($this->update_classe !== substr($this->update_numero_compte, 0, 1)) {
            session()->flash('error', "{$this->label_numero_compte} {$this->update_numero_compte} ne convient pas à la classe {$this->update_classe}.");
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

        session()->flash('status', 'Compte mis à jour avec succès.');
        $this->updating = false;
        $this->updateTable1();
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
        $value = $this->search_value;

        if (!empty($value)) {
            $this->comptes = Compta_comptes::where(function ($query) use ($value) {
                $query->where('classe', 'like', '%' . $value . '%')
                    ->orWhere('numero_compte', 'like', '%' . $value . '%')
                    ->orWhere('intitule', 'like', '%' . $value . '%');
            })
                ->orderBy('classe')
                ->orderBy('numero_compte')
                ->get();
        } else {
            $this->updateTable1();
        }
    }
}
