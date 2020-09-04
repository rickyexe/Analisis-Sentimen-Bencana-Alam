<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysql_xdevapi\Result;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Math\Distance\Cosine;
use Phpml\FeatureExtraction\TfIdfTransformer;

class TugasAkhirController extends Controller
{
    public  function index(){
//        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
//        $labels = ['b', 'b', 'b', 'b', 'b', 'b'];

        $samples = [
            [0 => 1, 1 => 1, 2 => 2, 3 => 1, 4 => 0, 5 => 0],
            [0 => 1, 1 => 1, 2 => 0, 3 => 0, 4 => 2, 5 => 3],
        ];

        $transformer = new TfIdfTransformer($samples);
        $hello = $transformer->transform($samples);
        dd($hello);





        $samples = [[0.0,0.22184875,0.698970004,0.0,0.0,0.0,0.0,0.0,0.0],[0,0,0,0.698970004,0,0,0,0,0],[0,0.22184875,0,0,0.698970004,0.6990,0,0,0],[0,0,0,0,0,0,0.698970004,0.398,0]];
        $labels = ['negatif', 'negatif','positif', 'positif'];

//        $a = [0,0.22184875,0,0,0,0,0,0.398,0.699];
//        $b = [0,0.22184875,0,0,0.698970004,0.6990,0,0,0];


        $predict = [0.0,0.22184875,0.0,0.0,0.0,0.0,0.0,0.398,0.699];


//        $cosine = new Cosine();
//        $test = $cosine->distance($a, $b);
//dd($this->distance($a,$b));





        for ($i = 0 ; $i < count($samples); $i++)
        {
            $cosine = new Cosine();
            $array[$i] = $cosine->distance($predict, $samples[$i]);
            $forLabel[$i] = $cosine->distance($predict, $samples[$i]);

        }

        rsort($array);
        $indexLabel = array_search($array[0], $forLabel);

        $result = [];
        array_push($result, $labels[$indexLabel]);









//        $classifier = new KNearestNeighbors($k=2, new Cosine());
//        $classifier->train($samples, $labels);
//
//        $hello = $classifier->predict([0,0,0,0,0,0,0.698970004,0.398,0]);
////        $hello = $classifier->predict([0.0,0.22184875,0.0,0.0,0.0,0.0,0.0,0.398,0.699]);
//
//        dd($hello);





    }


    public function tfidf()
    {

    }
}
