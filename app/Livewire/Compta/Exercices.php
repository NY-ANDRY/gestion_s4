<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_exercices;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('components.layouts.compta')]
class Exercices extends Component
{

    public $exercices;
    public $num_update;
    public $updating;

    public $isEdit;

    public $new_nom = '';
    public $new_date_debut = '';
    public $new_date_fin = '';

    public $search_value;

    public $update_nom = '';
    public $update_date_debut = '';
    public $update_date_fin = '';


    public function mount()
    {
        $this->updateTable1();
    }

    public function updateTable1()
    {
        $data = Compta_exercices::all()->sortByDesc('date_debut');
        $this->exercices = $this->convertData($data);
    }

    public function convertData($data)
    {
        Carbon::setLocale('fr');
        return $data->map(
            fn($exercice) => [
                'id' => $exercice->id,
                'nom' => $exercice->nom,
                'date_debut' => $exercice->date_debut,
                'date_fin' => $exercice->date_fin,
                'en_cours' => $exercice->en_cours,
                'date_debut_fr' => Carbon::parse($exercice->date_debut)->translatedFormat('j F Y'),
                'date_fin_fr' => Carbon::parse($exercice->date_fin)->translatedFormat('j F Y'),
            ]
        );
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
            'new_nom' => ['required'],
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
        $new_compte->nom = $this->new_nom;
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
        $this->update_nom = $cur_compte->nom;
        $this->update_date_debut = $cur_compte->date_debut;
        $this->update_date_fin = $cur_compte->date_fin;
    }

    public function updateOne()
    {
        $this->validate([
            'update_nom' => ['required'],
            'update_date_debut' => ['required', 'date', 'before:update_date_fin'],
            'update_date_fin' => ['required', 'date', 'after:update_date_debut']
        ]);
        $exist = Compta_exercices::where(function ($query) {
            $query->where('date_debut', '<=', $this->update_date_fin)
                ->where('date_fin', '>=', $this->update_date_debut);
        })
            ->where('id', '!=', $this->num_update)
            ->first();
        if (!empty($exist)) {
            session()->flash('error', "'" . $exist['date_debut'] . " - " . $exist['date_fin'] . "' existe deja.");
            return;
        }
        $new_compte = Compta_exercices::find($this->num_update);
        if (!empty($new_compte)) {
            $new_compte->nom = $this->update_nom;
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
            $data = Compta_exercices::where(function ($query) use ($value) {
                $query->where('nom', 'like', '%' . $value . '%')
                    ->orWhere('date_fin', 'like', '%' . $value . '%')
                    ->orWhere('date_debut', 'like', '%' . $value . '%');
            })
                ->orderBy('date_debut')
                ->get();
            $this->exercices = $this->convertData($data);
        } else {
            $this->updateTable1();
        }
    }

    public function setOn($id)
    {
        $cur = Compta_exercices::where('id', $id)->exists();
        if ($cur) {
            Compta_exercices::query()->update(['en_cours' => false]);
            Compta_exercices::where('id', $id)->update(['en_cours' => true]);
        }
        $this->updateTable1();
    }
    public function setOff($id)
    {
        Compta_exercices::where('id', $id)->update(['en_cours' => false]);
        $this->updateTable1();
    }
}
