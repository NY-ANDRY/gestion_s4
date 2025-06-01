<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Irsa_dettes extends Model
{
    public function getDetails()
    {
        $result = [];
        $dettes = Irsa_dettes::orderBy('range', 'asc')->get();
        foreach ($dettes as $key => $dette) {
            $begin = 0;
            $end = 0;
            $begin = $key === 0 ? 0 : $dettes[$key - 1]->range + 1;
            $end = $dette->range;
            $result[] = [
                'begin' => $begin,
                'end' => $end,
                'rate' => $dette->rate,
                'id' => $dette->id
            ];
        }
        return $result;
    }

    public function calculDettes($montant)
    {
        $result = [];
        $result["value"] = 0;
        $details = $this->getDetails();

        $count = count($details);

        for ($i = 0; $i < $count; $i++) {
            $cur_value  = 0;

            if (empty($details[$i]['end']) && $i == 0) {
                $cur_value = $montant;
            } else if (empty($details[$i]['end']) && $i != 0) {
                $cur_value = $montant - $details[$i - 1]['end'];
            } else if ($montant > $details[$i]['end'] && $i == 0) {
                $cur_value = $details[$i]['end'];
            } else if ($montant > $details[$i]['end'] && $i != 0) {
                $cur_value = $details[$i]['end'] - $details[$i - 1]['end'];
            } else if ($montant <= $details[$i]['end'] && $i == 0) {
                $cur_value = $montant;
            } else {
                $cur_value = $montant - $details[$i - 1]['end'];
            }

            $cur_value = $cur_value >= 0 ? $cur_value : 0;
            $value_irsa = ($cur_value * $details[$i]['rate']) / 100;

            $result["details"][$i] = $details[$i];
            $result['details'][$i]['value'] = $cur_value;
            $result['details'][$i]['irsa'] = $value_irsa;
            $result["value"] += $value_irsa;
        }

        return $result;
    }
}
