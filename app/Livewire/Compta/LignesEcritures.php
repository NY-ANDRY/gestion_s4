<?php

namespace App\Livewire\Compta;

use App\Models\Compta\Compta_comptes;
use App\Models\Compta\Compta_lignes_ecritures;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.compta')]
class LignesEcritures extends Component
{
    public $id_ecriture;
    public $show_ecriture_details = true;

    public $lignes_ecritures;
    public $comptes;
    public $num_update;
    public $updating;

    public $isEdit;

    public $new_numero_compte = null, $new_libelle_ligne = '', $new_type = '', $new_value = '';

    public $comptes_search = [];
    public $search_value;

    public $update_numero_compte = null, $update_libelle_ligne = '', $update_type = '', $update_value = null;


    public function mount($id)
    {
        $this->id_ecriture = $id;

        $this->comptes = Compta_comptes::all();
        $this->updateTable1();
    }
    public function updateTable1()
    {
        $data = Compta_lignes_ecritures::getByEcritureId($this->id_ecriture);
        $this->lignes_ecritures = $this->convertData($data);
        $this->dispatch('updateDetails');
    }


    public function convertData($data)
    {
        Carbon::setLocale('fr');
        return $data->map(
            function ($lignes_ecritures) {
                $type = '';
                $value = 0;
                if (empty($lignes_ecritures['debit']) || $lignes_ecritures['debit'] == 0) {
                    $type = 'credit';
                    $value = $lignes_ecritures['credit'];
                } else {
                    $type = 'debit';
                    $value = $lignes_ecritures['debit'];
                }
                return [
                    'id' => $lignes_ecritures->id,
                    'numero_compte' => $lignes_ecritures->numero_compte,
                    'libelle_ligne' => $lignes_ecritures->libelle_ligne,
                    'type' => $type,
                    'value' => $value
                ];
            }
        );
    }

    public function delete($id)
    {
        $compte = Compta_lignes_ecritures::find($id);
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
            'new_libelle_ligne' => 'required',
            'new_numero_compte' => 'required',
            'new_type' => 'required|in:debit,credit',
            'new_value' => 'required'
        ]);

        Compta_lignes_ecritures::create([
            'id_ecriture' => $this->id_ecriture,
            'numero_compte' => $this->new_numero_compte,
            'libelle_ligne' => $this->new_libelle_ligne,
            $this->new_type => $this->new_value
        ]);
        session()->flash('status', 'mouvement successfully created.');
        $this->reset(['new_libelle_ligne', 'new_numero_compte', 'new_type', 'new_value']);
        $this->updateTable1();
    }

    public function edit($id)
    {
        $this->updating = true;
        $this->num_update = $id;
        $cur_ecriture = Compta_lignes_ecritures::find($id);
        $this->update_libelle_ligne = $cur_ecriture->libelle_ligne;
        $this->update_numero_compte = $cur_ecriture->numero_compte;
        $this->update_type = $cur_ecriture->debit == 0 ? 'credit' : 'debit';
        $this->update_value = $cur_ecriture->debit == 0 ? $cur_ecriture->credit : $cur_ecriture->debit;
    }

    public function updateOne()
    {
        $this->validate([
            'update_numero_compte' => 'required',
            'update_libelle_ligne' => 'required',
            'update_type' => 'required|in:debit,credit',
            'update_value' => 'required'
        ]);
        $new_compte = Compta_lignes_ecritures::find($this->num_update);
        $debit = $this->update_type == 'debit' ? $this->update_value : 0;
        $credit = $this->update_type == 'credit' ? $this->update_value : 0;
        if ($new_compte) {
            $new_compte->update([
                'numero_compte' => $this->update_numero_compte,
                'libelle_ligne' => $this->update_libelle_ligne,
                'debit' => $debit,
                'credit' => $credit
            ]);
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
        $this->reset(['update_numero_compte', 'update_libelle_ligne', 'update_type', 'update_value']);
    }
    public function swapEdit()
    {
        $this->isEdit = !$this->isEdit;
    }

    public function doFilter()
    {
        $value = $this->search_value;

        if (!empty($value)) {
            $data = Compta_lignes_ecritures::filterByValue($value);
            $this->lignes_ecritures = $this->convertData($data);
        } else {
            $this->updateTable1();
        }
    }

    public function searchCompte($value)
    {
        if (empty($value) && $value != 0) {
            $this->comptes_search = [];
        } else {
            $result = [];

            foreach ($this->comptes as $key => $compte) {
                if (str_contains(strtolower($compte->numero_compte), strtolower($value))) {
                    $result[] = $compte;
                }
            }

            $this->comptes_search = $result;
        }
    }

    public function searchCompteForNew()
    {
        $this->searchCompte($this->new_numero_compte);
    }
    public function searchCompteForUpdate()
    {
        $this->searchCompte($this->update_numero_compte);
    }

    public function setNew_numero_compte($value)
    {
        $this->new_numero_compte = $value;
        $this->comptes_search = [];
    }
    public function setNew_type($type)
    {
        if ($type != 'debit' && $type != 'credit') {
            return;
        }
        $this->new_type = $type;
    }

    public function setUpdate_numero_compte($value)
    {
        $this->update_numero_compte = $value;
        $this->comptes_search = [];
    }
    public function setUpdate_type($type)
    {
        if ($type != 'debit' && $type != 'credit') {
            return;
        }
        $this->update_type = $type;
    }


    public function swap_ecriture_details()
    {
        $this->show_ecriture_details = !$this->show_ecriture_details;
    }
}
