<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepositories;
use App\Repositories\ProcessRepository;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Math\Distance\Cosine;
use Phpml\Metric\Accuracy;


class TugasAkhirController extends Controller
{

    public function __construct(DataRepositories $dataRepositories, ProcessRepository $processRepository)
    {
        $this->dataRepositories = $dataRepositories;
        $this->processRepositories = $processRepository;
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


        for ($i = 0 ; $i < count($tweetsTFIDF) ; $i++)
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
        $trainingData = $this->dataRepositories->getTrainingForTesting();
        $sentimenValue = $this->dataRepositories->getSentimenValueTraining();
        $testingData = $this->dataRepositories->getTestingData();
        $sentimenValueTesting = $this->dataRepositories->getSentimenValueTesting();

        $trainingData = $this->processRepositories->preProcessing($trainingData);
        $testingData =$this->processRepositories->preProcessing($testingData);

        $combinedData = array_merge($trainingData, $testingData);

        $tfidf = $this->processRepositories->getTFIDF($combinedData); // 2 dimensional array




        $trainingTFIDF  = array();
        $testingTFIDF = array();

        for ($i = 0 ; $i < count($trainingData) ; $i++)
        {
            array_push($trainingTFIDF, $tfidf[$i]);
        }

        for ($i = count($trainingData) ; $i < count($tfidf) ; $i++)
        {
            array_push($testingTFIDF, $tfidf[$i]);
        }




        $accuracyResult = array();

        for ($i = 1 ; $i <= 10 ; $i++)
        {
            $classifier = new KNearestNeighbors($k=$i, new Cosine());
            $classifier->train($trainingTFIDF, $sentimenValue);
            $predictedSentiment = array();


            for ($j = 0 ; $j < count($testingTFIDF) ; $j++)
            {
                $result = $classifier->predict($testingTFIDF[$j]);
                if($result ==  'kecil'){
                    array_push($predictedSentiment, 'kecil');
                }
                else if ($result == 'sedang'){
                    array_push($predictedSentiment, 'sedang');
                }
                else if ($result == 'besar') {
                    array_push($predictedSentiment, 'besar');
                }
            }

            $resultAccuracy = Accuracy::score($sentimenValueTesting, $predictedSentiment );
            $resultAccuracy = $resultAccuracy * 100;
            $result = "Accuracy for k=".$i." is ".$resultAccuracy." %";
            array_push($accuracyResult, $result);

        }



        dd($accuracyResult);



    }


}
