<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Irsa_dettes extends Model
{
    public function getDetails()
    {
        $result = [];
        $dettes = Irsa_dettes::orderBy('range', 'asc')->get();
        $size = count($dettes);
        foreach ($dettes as $key => $dette) {
            $begin = 0;
            $end = 0;
            switch ($key) {
                case 0:
                    $begin = 0;
                    $end = $dette->range;
                    break;
                case $size - 1:
                    $begin = $dettes[$key - 1]->range + 1;
                    $end = "et plus";
                    break;
                default:
                    $begin = $dettes[$key - 1]->range + 1;
                    $end = $dette->range;
                    break;
            }
            $result[] = [
                'begin' => $begin,
                'end' => $end,
                'rate' => $dette->rate,
                'id' => $dette->id
            ];
        }
        return $result;
    }
}
