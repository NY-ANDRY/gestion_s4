<?php

namespace App\Livewire\Compta;

use Livewire\Component;
use App\Models\Compta\Compta_ecritures;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Ecritures extends Component
{

    public $exercices;
    public $num_update;
    public $updating;

    public $isEdit;

    public $new_piece_reference = '';
    public $new_libelle_ecriture = '';
    public $new_journal_code = '';
    public $new_id_exercice = '';

    public $search_value;

    public $update_piece_reference = '';
    public $update_libelle_ecriture = '';
    public $update_journal_code = '';
    public $update_id_exercice = '';


    public function mount()
    {
        $this->updateTable1();
    }

    public function updateTable1()
    {
        $this->exercices = Compta_ecritures::all()->sortByDesc('date_ecriture');
    }

    public function delete($id)
    {
        $compte = Compta_ecritures::find($id);
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
            'new_libelle_ecriture' => 'required',
            'new_journal_code' => 'required',
            'new_id_exercice' => 'required',
        ]);
        $new_compte = new Compta_ecritures();
        $new_compte->numero_compte = $this->new_numero_compte;
        $new_compte->libelle_ecriture = $this->new_libelle_ecriture;
        $new_compte->journal_code = $this->new_journal_code;
        $new_compte->save();
        session()->flash('status', 'Compte successfully created.');
        $this->reset(['new_numero_compte', 'new_libelle_ecriture', 'new_journal_code']);
        $this->updateTable1();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;
        $cur_compte = Compta_ecritures::find($id);
        $this->update_libelle_ecriture = $cur_compte->libelle_ecriture;
        $this->update_journal_code = $cur_compte->journal_code;
    }

    public function updateOne()
    {
        $this->validate([
            'update_libelle_ecriture' => 'required',
            'update_journal_code' => 'required',
            'update_id_exercice' => 'required',
        ]);
        $exist = Compta_ecritures::where('numero_compte', $this->update_numero_compte)
            ->where('id', '!=', $this->num_update)
            ->first();
        $new_compte = Compta_ecritures::find($this->num_update);
        if (!empty($new_compte)) {
            $new_compte->numero_compte = $this->update_numero_compte;
            $new_compte->libelle_ecriture = $this->update_libelle_ecriture;
            $new_compte->journal_code = $this->update_journal_code;
            $new_compte->save();
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
        $this->reset(['update_numero_compte', 'update_libelle_ecriture', 'update_journal_code']);
    }
    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
    }

    public function doFilter()
    {
        $value = $this->search_value;

        if (!empty($value)) {
            $this->exercices = Compta_ecritures::where(function ($query) use ($value) {
                $query->where('journal_code', 'like', '%' . $value . '%')
                    ->orWhere('numero_compte', 'like', '%' . $value . '%')
                    ->orWhere('libelle_ecriture', 'like', '%' . $value . '%');
            })
                ->orderBy('journal_code')
                ->orderBy('numero_compte')
                ->get();
        } else {
            $this->updateTable1();
        }
    }
}
