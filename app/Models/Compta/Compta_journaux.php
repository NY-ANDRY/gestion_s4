<?php
namespace App\Models\Compta;

use Illuminate\Database\Eloquent\Model;

class Compta_journaux extends Model
{
    protected $table = 'compta_journaux';
    protected $fillable = ['code_journal', 'libelle'];

    public static function getAllOrdered()
    {
        return self::orderBy('code_journal')->get();
    }

    public static function search($value)
    {
        return self::where('code_journal', 'like', "%{$value}%")
            ->orWhere('libelle', 'like', "%{$value}%")
            ->orderBy('code_journal')
            ->get();
    }

    public static function existsWithCode($code, $excludeId = null)
    {
        $query = self::where('code_journal', $code);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->first();
    }
}
