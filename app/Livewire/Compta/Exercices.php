<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_exercices;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.compta')]
class Exercices extends Component
{

    public $exercices;
    public $num_update;
    public $updating;

    public $isEdit;

    public $new_date_debut = '';
    public $new_date_fin = '';

    public $search_value;

    public $update_date_debut = '';
    public $update_date_fin = '';


    public function mount()
    {
        $this->updateTable1();
    }

    public function updateTable1()
    {
        $this->exercices = Compta_exercices::all()->sortBy('date_debut');
    }


    public function delete($id)
    {
        $compte = Compta_exercices::find($id);
        if (!empty($compte)) {
            $compte->delete();
            session()->flash('status', 'Execice successfully deleted.');
        } else {
            session()->flash('error', 'Execice not found.');
        }
        $this->updateTable1();
    }

    public function save()
    {
        $this->validate([
            'new_date_debut' => ['required', 'date', 'before:new_date_fin'],
            'new_date_fin'   => ['required', 'date', 'after:new_date_debut'],
        ]);

        $exist = Compta_exercices::where(function ($query) {
            $query->where('date_debut', '<=', $this->new_date_fin)
                ->where('date_fin', '>=', $this->new_date_debut);
        })->first();
        if (!empty($exist)) {
            session()->flash('error', "'" . $exist['date_debut'] . " - " . $exist['date_fin'] . "' existe deja.");
            return;
        }
        $new_compte = new Compta_exercices();
        $new_compte->date_debut = $this->new_date_debut;
        $new_compte->date_fin = $this->new_date_fin;
        $new_compte->save();
        session()->flash('status', 'Execice successfully created.');
        $this->reset(['new_date_debut', 'new_date_fin']);
        $this->updateTable1();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;
        $cur_compte = Compta_exercices::find($id);
        $this->update_date_debut = $cur_compte->date_debut;
        $this->update_date_fin = $cur_compte->date_fin;
    }

    public function updateOne()
    {
        $this->validate([
            'update_date_debut' => ['required', 'date', 'before:update_date_fin'],
            'update_date_fin' => ['required', 'date', 'after:update_date_debut']
        ]);
        $exist = Compta_exercices::where(function ($query) {
            $query->where('date_debut', '<=', $this->update_date_fin)
                ->where('date_fin', '>=', $this->update_date_debut);
        })->first();
        if (!empty($exist)) {
            session()->flash('error', "'" . $exist['date_debut'] . " - " . $exist['date_fin'] . "' existe deja.");
            return;
        }
        $new_compte = Compta_exercices::find($this->num_update);
        if (!empty($new_compte)) {
            $new_compte->date_debut = $this->update_date_debut;
            $new_compte->date_fin = $this->update_date_fin;
            $new_compte->save();
            session()->flash('status', 'Execice successfully updated.');
        } else {
            session()->flash('error', 'Execice not found.');
        }
        $this->updating = false;
        $this->updateTable1();
    }

    public function updateClose()
    {
        $this->updating = false;
        $this->reset(['update_date_debut', 'update_date_fin']);
    }
    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
    }

    public function doFilter()
    {
        $value = $this->search_value;

        if (!empty($value)) {
            $this->exercices = Compta_exercices::where(function ($query) use ($value) {
                $query->where('date_debut', 'like', '%' . $value . '%')
                    ->orWhere('date_fin', 'like', '%' . $value . '%');
            })
                ->orderBy('date_debut')
                ->get();
        } else {
            $this->updateTable1();
        }
    }
}
