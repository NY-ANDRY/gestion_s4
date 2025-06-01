<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Irsa_dettes;

class IrsaEdit extends Component
{

    public $irsa_dettes;

    public $newRange = 0;
    public $newRate = 0;

    public function mount()
    {
        $irsa_dette = new Irsa_dettes();
        $this->irsa_dettes = $irsa_dette->getDetails();
    }

    public function delete($id)
    {
        $irsa_dette = Irsa_dettes::find($id);
        if (!empty($irsa_dette)) {
            $irsa_dette->delete();
        }
        session()->flash('status', 'Post successfully updated.');
        $this->redirect('/irsa/edit');
    }
    public function save()
    {
        $irsa_dette = new Irsa_dettes();
        $irsa_dette->rate = $this->newRate;
        if (empty($this->newRange)) {
            $irsa_dette->range = null;
            $existing = Irsa_dettes::where('range', null)->first();
            if ($existing) {
                session()->flash('error', 'there should be only one rate without a range. Please delete the last one before adding a new one.');
                return;
            }
        } else {
            $irsa_dette->range = (int)$this->newRange;
        }
        $irsa_dette->save();
        session()->flash('status', 'Post successfully updated.');
        $this->redirect('/irsa/edit');
    }

    #[Layout('components.layouts.irsa')]
    public function render()
    {
        return view('livewire.irsa-edit');
    }
}
