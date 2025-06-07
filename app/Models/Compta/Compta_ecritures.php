<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_ecritures extends Model
{
    protected $fillable = [
        'id_exercice',
        'libelle_ecriture',
        'journal_code',
        'date_ecriture'
    ];
}
