<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysql_xdevapi\Result;
use App\Repositories\DataRepositories;
use App\Repositories\ProcessRepository;
use App\Repositories\SlangRepositories;
use App\Post;


class TugasAkhirController extends Controller
{

    public function __construct(DataRepositories $dataRepositories, ProcessRepository $processRepository, SlangRepositories $slangRepositories)
    {
        $this->dataRepositories = $dataRepositories;
        $this->processRepositories = $processRepository;
        $this->slangRepositories = $slangRepositories;
    }


    public  function index(){
//
//        $consumer_key = '7hAaveHGkw3XZptGA7kO88mad';
//        $consumer_secret = 'Bv7W9aoZMfv1ftB5cDysuuCH4RAEDcTc4C5GkB6rjFBH5ZGs8y';
//        $access_token = '1301891683093626884-gjN9AevcuvysRZujwp3kiuHCBuO3Nm';
//        $access_token_secret = 'v9h9QOt0zWvlB1fTyWuF6QuEmfNXYtN7XD3Lkz8GtDTDC';
//        $connection = new TwitterOAuth($consumer_key,$consumer_secret, $access_token , $access_token_secret);
//        $content = $connection->get("account/verify_credentials");
//        $statuses = $connection->get("search/tweets", ["q" => "reza arap", 'count' => 100]);
//
//
//        dd($statuses);

//        $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
//        $labels = ['b', 'b', 'b', 'b', 'b', 'b'];

//        $samples = [
//            [0 => 1, 1 => 1, 2 => 2, 3 => 1, 4 => 0, 5 => 0],
//            [0 => 1, 1 => 1, 2 => 0, 3 => 0, 4 => 2, 5 => 3],
//        ];
//
//        $transformer = new TfIdfTransformer($samples);
//        $hello = $transformer->transform($samples);
//        dd($hello);
//
//
//
//
//
//        $samples = [[0.0,0.22184875,0.698970004,0.0,0.0,0.0,0.0,0.0,0.0],[0,0,0,0.698970004,0,0,0,0,0],[0,0.22184875,0,0,0.698970004,0.6990,0,0,0],[0,0,0,0,0,0,0.698970004,0.398,0]];
//        $labels = ['negatif', 'negatif','positif', 'positif'];
//
////        $a = [0,0.22184875,0,0,0,0,0,0.398,0.699];
////        $b = [0,0.22184875,0,0,0.698970004,0.6990,0,0,0];
//
//
//        $predict = [0.0,0.22184875,0.0,0.0,0.0,0.0,0.0,0.398,0.699];
//
//
////        $cosine = new Cosine();
////        $test = $cosine->distance($a, $b);
////dd($this->distance($a,$b));
//
//
//
//
//
//        for ($i = 0 ; $i < count($samples); $i++)
//        {
//            $cosine = new Cosine();
//            $array[$i] = $cosine->distance($predict, $samples[$i]);
//            $forLabel[$i] = $cosine->distance($predict, $samples[$i]);
//
//        }
//
//        rsort($array);
//        $indexLabel = array_search($array[0], $forLabel);
//
//        $result = [];
//        array_push($result, $labels[$indexLabel]);
//
//
//
//
//
//
//
//
//
////        $classifier = new KNearestNeighbors($k=2, new Cosine());
////        $classifier->train($samples, $labels);
////
////        $hello = $classifier->predict([0,0,0,0,0,0,0.698970004,0.398,0]);
//////        $hello = $classifier->predict([0.0,0.22184875,0.0,0.0,0.0,0.0,0.0,0.398,0.699]);
////
////        dd($hello);
///
///
///
///
///





        return view('homepage');

    }

    public function processing($query){

        $tweets = $this->dataRepositories->getTweets($query);
//        $trainingData = $this->dataRepositories->getTrainingData();
//        $sentimenValue = $this->dataRepositories->getSentimenValue();

//        $trainingData = $this->processRepositories->preProcessing($trainingData);



        $tweets = $this->processRepositories->preProcessing($tweets);















        return view('hasil-analisa');
    }


    public function tfidf()
    {
//        for ($i = 0 ; $i < count($convertedStatus['statuses']) ; $i++)
//        {
//            $checkPost = Post::where('post', $convertedStatus['statuses'][$i]->full_text)->first();
//            if($checkPost == null)
//            {
//                $post = new Post;
//                $post->post = $convertedStatus['statuses'][$i]->full_text;
//                $post->save();
//            }
//
//        }
    }
}
