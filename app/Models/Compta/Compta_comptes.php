<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_comptes extends Model
{
    protected $fillable = ['numero_compte', 'intitule', 'classe'];
}
