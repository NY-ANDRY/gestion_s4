<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_lignes_ecritures extends Model
{
    protected $fillable = ['numero_compte', 'libelle_ligne', 'debit', 'credit', 'id_ecriture'];

    public static function getByEcritureId($id_ecriture)
    {
        return self::where('id_ecriture', $id_ecriture)
            ->orderBy('numero_compte')
            ->get();
    }

    public static function filterByValue($value)
    {
        return self::where(function ($query) use ($value) {
            $query->where('numero_compte', 'like', '%' . $value . '%')
                ->orWhere('libelle_ligne', 'like', '%' . $value . '%')
                ->orWhere('debit', 'like', '%' . $value . '%')
                ->orWhere('credit', 'like', '%' . $value . '%');
        })->orderBy('numero_compte')->get();
    }
}

