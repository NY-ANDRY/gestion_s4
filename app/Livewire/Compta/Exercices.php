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

    public $new_nom = '', $new_date_debut = '', $new_date_fin = '';
    public $update_nom = '', $update_date_debut = '', $update_date_fin = '';
    public $search_value;

    public function mount()
    {
        $this->loadExercices();
    }

    public function loadExercices()
    {
        $this->exercices = $this->formatExercices(Compta_exercices::getAllOrdered());
    }

    public function formatExercices($data)
    {
        Carbon::setLocale('fr');
        return $data->map(fn($e) => [
            'id' => $e->id,
            'nom' => $e->nom,
            'date_debut' => $e->date_debut,
            'date_fin' => $e->date_fin,
            'en_cours' => $e->en_cours,
            'date_debut_fr' => Carbon::parse($e->date_debut)->translatedFormat('j F Y'),
            'date_fin_fr' => Carbon::parse($e->date_fin)->translatedFormat('j F Y'),
        ]);
    }

    public function save()
    {
        $this->validate([
            'new_nom' => 'required',
            'new_date_debut' => 'required|date|before:new_date_fin',
            'new_date_fin' => 'required|date|after:new_date_debut',
        ]);

        if ($conflict = Compta_exercices::isOverlapping($this->new_date_debut, $this->new_date_fin)) {
            session()->flash('error', "Un exercice existe déjà entre '{$conflict->date_debut}' et '{$conflict->date_fin}'");
            return;
        }

        Compta_exercices::create([
            'nom' => $this->new_nom,
            'date_debut' => $this->new_date_debut,
            'date_fin' => $this->new_date_fin,
        ]);

        session()->flash('status', 'Exercice créé avec succès.');
        $this->reset(['new_nom', 'new_date_debut', 'new_date_fin']);
        $this->loadExercices();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;

        $e = Compta_exercices::find($id);
        $this->update_nom = $e->nom;
        $this->update_date_debut = $e->date_debut;
        $this->update_date_fin = $e->date_fin;
    }

    public function updateOne()
    {
        $this->validate([
            'update_nom' => 'required',
            'update_date_debut' => 'required|date|before:update_date_fin',
            'update_date_fin' => 'required|date|after:update_date_debut',
        ]);

        if ($conflict = Compta_exercices::isOverlapping($this->update_date_debut, $this->update_date_fin, $this->num_update)) {
            session()->flash('error', "Un exercice existe déjà entre '{$conflict->date_debut}' et '{$conflict->date_fin}'");
            return;
        }

        $e = Compta_exercices::find($this->num_update);
        if (!$e) {
            session()->flash('error', 'Exercice non trouvé.');
            return;
        }

        $e->update([
            'nom' => $this->update_nom,
            'date_debut' => $this->update_date_debut,
            'date_fin' => $this->update_date_fin,
        ]);

        session()->flash('status', 'Exercice mis à jour.');
        $this->updating = false;
        $this->loadExercices();
    }

    public function delete($id)
    {
        $e = Compta_exercices::find($id);
        if ($e) {
            $e->delete();
            session()->flash('status', 'Exercice supprimé.');
        } else {
            session()->flash('error', 'Exercice non trouvé.');
        }

        $this->loadExercices();
    }

    public function updateClose()
    {
        $this->updating = false;
        $this->reset(['update_nom', 'update_date_debut', 'update_date_fin']);
    }

    public function doFilter()
    {
        $val = $this->search_value;

        if (!empty($val)) {
            $this->exercices = $this->formatExercices(Compta_exercices::search($val));
        } else {
            $this->loadExercices();
        }
    }

    public function setOn($id)
    {
        if (Compta_exercices::where('id', $id)->exists()) {
            Compta_exercices::setEnCours($id);
        }
        $this->loadExercices();
    }

    public function setOff($id)
    {
        Compta_exercices::setHorsCours($id);
        $this->loadExercices();
    }

    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
    }
}
