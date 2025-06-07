<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_exercices extends Model
{
    protected $fillable = ['nom', 'date_debut', 'date_fin'];
}
