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

    public $isEdit;

    #[Validate('required|max:4')]
    public $new_numero_compte = '';
    #[Validate('required')]
    public $new_intitule = '';
    #[Validate('required|max:1')]
    public $new_classe = '';


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
        $verif = Compta_comptes::where('numero_compte', $this->new_numero_compte)->first();
        if (!empty($verif)) {
            session()->flash('error', 'Compte avec ce code existe deja.');
            return;
        }
        $new_compte = new Compta_comptes();
        $new_compte->numero_compte = $this->new_numero_compte;
        $new_compte->intitule = $this->new_intitule;
        $new_compte->classe = $this->new_classe;
        $new_compte->save();
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
        $verif = Compta_comptes::where('numero_compte', $this->update_numero_compte)
            ->where('id', '!=', $this->num_update)
            ->first();
        if (!empty($verif)) {
            session()->flash('error', 'Compte avec ce code existe deja.');
            return;
        }
        $new_compte = Compta_comptes::find($this->num_update);
        if (!empty($new_compte)) {
            $new_compte->numero_compte = $this->update_numero_compte;
            $new_compte->intitule = $this->update_intitule;
            $new_compte->classe = $this->update_classe;
            $new_compte->save();
            session()->flash('status', 'Compte successfully updated.');
        } else {
            session()->flash('error', 'Compte not found.');
        }
        $this->updating = false;
        $this->updateTable1();
    }

    public function updateClose(){
        $this->updating = false;
        $this->reset(['update_numero_compte', 'update_intitule', 'update_classe']);
    }
    public function swapEdit(){
        $this->isEdit = !$this->isEdit;
    }
}
