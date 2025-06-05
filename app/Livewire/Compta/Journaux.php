<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_journaux;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Journaux extends Component
{

    public $journaux;
    public $num_update;
    public $updating;

    public $isEdit;

    public $new_code_journal = '';
    public $new_libelle = '';

    public $search_value;

    public $update_code_journal = '';
    public $update_libelle = '';


    public function mount()
    {
        $this->updateTable1();
    }

    public function updateTable1()
    {
        $this->journaux = Compta_journaux::all()->sortBy('code_journal');
    }


    public function delete($id)
    {
        $compte = Compta_journaux::find($id);
        if (!empty($compte)) {
            $compte->delete();
            session()->flash('status', 'Journal successfully deleted.');
        } else {
            session()->flash('error', 'Journal not found.');
        }
        $this->updateTable1();
    }

    public function save()
    {
        $this->validate([
            'new_code_journal' => 'required',
            'new_libelle' => 'required'
        ]);
        $exist = Compta_journaux::where('code_journal', $this->new_code_journal)->first();
        if (!empty($exist)) {
            session()->flash('error', "'" . $exist['code_journal'] . ":" . $exist['libelle'] . "' existe deja.");
            return;
        }
        $new_compte = new Compta_journaux();
        $new_compte->code_journal = $this->new_code_journal;
        $new_compte->libelle = $this->new_libelle;
        $new_compte->save();
        session()->flash('status', 'Journal successfully created.');
        $this->reset(['new_code_journal', 'new_libelle']);
        $this->updateTable1();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;
        $cur_compte = Compta_journaux::find($id);
        $this->update_code_journal = $cur_compte->code_journal;
        $this->update_libelle = $cur_compte->libelle;
    }

    public function updateOne()
    {
        $this->validate([
            'update_code_journal' => 'required',
            'update_libelle' => 'required'
        ]);
        $exist = Compta_journaux::where('code_journal', $this->update_code_journal)
            ->where('id', '!=', $this->num_update)
            ->first();
        if (!empty($exist)) {
            session()->flash('error', "'" . $exist['code_journal'] . ": " . $exist['libelle'] . "' existe deja.");
            return;
        }
        $new_compte = Compta_journaux::find($this->num_update);
        if (!empty($new_compte)) {
            $new_compte->code_journal = $this->update_code_journal;
            $new_compte->libelle = $this->update_libelle;
            $new_compte->save();
            session()->flash('status', 'Journal successfully updated.');
        } else {
            session()->flash('error', 'Journal not found.');
        }
        $this->updating = false;
        $this->updateTable1();
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
        $value = $this->search_value;

        if (!empty($value)) {
            $this->journaux = Compta_journaux::where(function ($query) use ($value) {
                $query->where('code_journal', 'like', '%' . $value . '%')
                    ->orWhere('libelle', 'like', '%' . $value . '%');
            })
                ->orderBy('code_journal')
                ->get();
        } else {
            $this->updateTable1();
        }
    }
}
