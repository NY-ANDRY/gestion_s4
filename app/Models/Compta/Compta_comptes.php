<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_comptes extends Model
{
    protected $fillable = ['numero_compte', 'intitule', 'classe'];

    public static function getAllOrdered()
    {
        return self::orderBy('classe')->orderBy('numero_compte')->get();
    }

    public static function search($value)
    {
        return self::where('classe', 'like', "%{$value}%")
            ->orWhere('numero_compte', 'like', "%{$value}%")
            ->orWhere('intitule', 'like', "%{$value}%")
            ->orderBy('classe')
            ->orderBy('numero_compte')
            ->get();
    }

    public static function existsWithNumero($numero, $excludeId = null)
    {
        $query = self::where('numero_compte', $numero);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->first();
    }
}
