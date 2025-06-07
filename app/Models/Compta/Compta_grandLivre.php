<?php

namespace App\Models\Compta;

class Compta_grandLivre
{

    public static function getFromExerciceCompte($id_exercice, $numero_compte)
    {
        $result = Compta_lignes_ecritures::join('compta_ecritures', 'compta_lignes_ecritures.id_ecriture', '=', 'compta_ecritures.id')
            ->where('compta_ecritures.id_exercice', $id_exercice)
            ->where('compta_lignes_ecritures.numero_compte', $numero_compte)
            ->get();

        return $result;
    }

    public static function getDataForExercice($id_exercice)
    {
        $result = [];
        $i = 0;

        $comptes = Compta_comptes::all();

        foreach ($comptes as $compte) {
            $cur_data = self::getFromExerciceCompte($id_exercice, $compte['id']);

            if ($cur_data->isNotEmpty()) {
                $result[$i]['compte'] = $compte;
                $result[$i]['items'] = $cur_data;
                $i++;
            }
        }

        return $result;
    }

    public static function getTotalSolde($id_exercice, $numero_compte)
    {
        $result = [
            'total' => ['debit' => 0, 'credit' => 0],
            'solde' => ['debit' => 0, 'credit' => 0]
        ];

        $data = self::getFromExerciceCompte($id_exercice, $numero_compte);

        foreach ($data as $item) {
            $result['total']['debit'] += $item['debit'];
            $result['total']['credit'] += $item['credit'];
        }

        if ($result['total']['debit'] > $result['total']['credit']) {
            $result['solde']['debit'] = abs($result['total']['debit'] - $result['total']['credit']);
        } else {
            $result['solde']['credit'] = abs($result['total']['debit'] - $result['total']['credit']);
        }

        return $result;
    }

    public static function getTotalSoldeAll($id_exercice)
    {
        $result = [
            'debit' => 0,
            'credit' => 0
        ];

        $comptes = Compta_comptes::all();

        foreach ($comptes as $compte) {
            $cur_res = self::getTotalSolde($id_exercice, $compte['numero_compte']);
            $result['debit'] += $cur_res['solde']['debit'];
            $result['credit'] += $cur_res['solde']['credit'];
        }

        return $result;
    }
}
