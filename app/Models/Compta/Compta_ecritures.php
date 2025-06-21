<?php
namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Compta_ecritures extends Model
{
    protected $fillable = [
        'id_exercice',
        'libelle_ecriture',
        'journal_code',
        'date_ecriture'
    ];

    public static function getByExerciceId(int $id_exercice)
    {
        return self::where('id_exercice', $id_exercice)
            ->orderByDesc('date_ecriture')
            ->get();
    }

    public static function convertData($data)
    {
        Carbon::setLocale('fr');
        return $data->map(function ($ecriture) {
            return [
                'id' => $ecriture->id,
                'date_ecriture' => Carbon::parse($ecriture->date_ecriture)->translatedFormat('j F Y'),
                'libelle_ecriture' => $ecriture->libelle_ecriture,
                'journal_code' => $ecriture->journal_code,
                'id_exercice' => $ecriture->id_exercice,
            ];
        });
    }

    public static function searchByValue(string $value)
    {
        return self::where(function ($query) use ($value) {
            $query->where('date_ecriture', 'like', '%' . $value . '%')
                  ->orWhere('libelle_ecriture', 'like', '%' . $value . '%');
        })
        ->orderByDesc('date_ecriture')
        ->get();
    }
}
