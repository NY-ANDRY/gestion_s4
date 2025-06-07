<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_lignes_ecritures extends Model
{
    protected $fillable = ['numero_compte', 'libelle_ligne', 'debit', 'credit', 'id_ecriture'];
}
