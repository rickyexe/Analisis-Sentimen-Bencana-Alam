<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepositories;
use App\Repositories\ProcessRepository;
use App\Repositories\SlangRepositories;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Math\Distance\Cosine;


class TugasAkhirController extends Controller
{

    public function __construct(DataRepositories $dataRepositories, ProcessRepository $processRepository, SlangRepositories $slangRepositories)
    {
        $this->dataRepositories = $dataRepositories;
        $this->processRepositories = $processRepository;
        $this->slangRepositories = $slangRepositories;
    }


    public  function index(){

        return view('homepage');

    }

    public function processing($query){

        $tweets = $this->dataRepositories->getTweets($query);
        $trainingData = $this->dataRepositories->getTrainingData();
        $sentimenValue = $this->dataRepositories->getSentimenValue();


        $trainingData = $this->processRepositories->preProcessing($trainingData);

        $tweets = $this->processRepositories->preProcessing($tweets);


        $combinedData = array_merge($trainingData, $tweets);


        $tfidf = $this->processRepositories->getTFIDF($combinedData); // 2 dimensional array


        $trainingTFIDF  = array();
        $tweetsTFIDF = array();

        for ($i = 0 ; $i < count($trainingData) ; $i++)
        {
            array_push($trainingTFIDF, $tfidf[$i]);
        }

        for ($i = count($trainingData) ; $i < count($tfidf) ; $i++)
        {
            array_push($tweetsTFIDF, $tfidf[$i]);
        }



        $classifier = new KNearestNeighbors($k=1, new Cosine());
        $classifier->train($trainingTFIDF, $sentimenValue);

        $kecil = 0;
        $sedang = 0;
        $besar = 0;


        for ($i = 0 ; $i < count($tweetsTFIDF) -1 ; $i++)
        {
            $result = $classifier->predict($tweetsTFIDF[$i]);
            if($result ==  'kecil'){
               $kecil++;
            }
            else if ($result == 'sedang'){
                $sedang++;
            }
            else if ($result == 'besar')
            {
                $besar++;
            }
        }

        return view('hasil-analisa', compact('kecil', 'sedang', 'besar'));
    }


    public function training(){

    }


}
