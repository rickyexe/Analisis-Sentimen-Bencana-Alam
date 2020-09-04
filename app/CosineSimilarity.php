<?php

namespace App;
use App\Distance;

class CosineSimilarity extends Distance
{
    /**
     * @param array $a
     * @param array $b
     *
     * @return float
     */
    public function distance(array $a, array $b) : float
    {
        $distance = [];
        $count = count($a);
        $atas = 0.0;
        $bawah1 = 0.0;
        $bawah2 = 0.0;

        for ($i = 0; $i < $count; ++$i) {
            $atas += $a[$i] * $b[$i];
        }

        for ($i = 0; $i < $count; ++$i) {
            $bawah1 += pow($a[$i],2);
            $bawah2 += pow($a[$i],2);
        }

        $bawah1 = sqrt($bawah1);
        $bawah2 = sqrt($bawah2);


        $finalMath = $atas / ($bawah1 * $bawah2);



        return min($finalMath);
    }
}
