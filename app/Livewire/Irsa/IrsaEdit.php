<?php

namespace App\Livewire\Irsa;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Irsa\Irsa_dettes;
use App\Models\Irsa\Irsa_mins;

#[Layout('components.layouts.irsa')]
class IrsaEdit extends Component
{

    public $irsa_dettes;
    public $irsa_min;

    public $newRange = 0;
    public $newRate = 0;
    public $newMin = 0;

    public function mount()
    {
        $this->updateTable1();
        $this->irsa_min = Irsa_mins::first();
    }

    private function updateTable1()
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
        $this->updateTable1();
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
        $this->updateTable1();
    }

    public function updateMin()
    {
        if ((empty($this->newMin) && $this->newMin != 0) || (!is_numeric($this->newMin))) {
            session()->flash('errorMin', 'Please enter a valid minimum value. (' . $this->newMin . ')');
            return;
        }
        Irsa_mins::truncate();
        $irsa_mins = new Irsa_mins();
        $irsa_mins->value = $this->newMin;
        $irsa_mins->save();
        $this->irsa_min = Irsa_mins::first();
    }

}
