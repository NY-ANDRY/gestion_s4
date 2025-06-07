<?php

namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_exercices extends Model
{
    protected $fillable = ['nom', 'date_debut', 'date_fin', 'en_cours'];

    public static function getAllOrdered()
    {
        return self::orderByDesc('date_debut')->get();
    }

    public static function search($value)
    {
        return self::where('nom', 'like', "%{$value}%")
            ->orWhere('date_debut', 'like', "%{$value}%")
            ->orWhere('date_fin', 'like', "%{$value}%")
            ->orderByDesc('date_debut')
            ->get();
    }

    public static function isOverlapping($date_debut, $date_fin, $excludeId = null)
    {
        return self::where(function ($query) use ($date_debut, $date_fin) {
            $query->where('date_debut', '<=', $date_fin)
                ->where('date_fin', '>=', $date_debut);
        })
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->first();
    }

    public static function setEnCours($id)
    {
        self::query()->update(['en_cours' => false]);
        self::where('id', $id)->update(['en_cours' => true]);
    }

    public static function setHorsCours($id)
    {
        self::where('id', $id)->update(['en_cours' => false]);
    }

    public static function getCurrent()
    {
        return self::where('en_cours', true)->first();
    }
}
