<?php

namespace App\Repositories;


use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Sastrawi\Stemmer\StemmerFactory;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Math\Distance\Cosine;
use Phpml\FeatureExtraction\TfIdfTransformer;



class ProcessRepository {

    public function preProcessing($data){

        $stopwordFactory = new StopWordRemoverFactory();
        $stopword = $stopwordFactory->createStopWordRemover();

        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();

        foreach ($data as $key => $value) {
            $data[$key] = $stemmer->stem($value);
        }

        foreach  ($data as $key => $value) {
            $data[$key] = $stopword->remove($value);
        }

        $data = $this->removeSymbolandNumber($data);
        $data = $this->removeRT($data);
        $data = $this->removeURL($data);





        return $data;

    }

    public function removeSymbolandNumber($data){

        foreach  ($data as $key => $value) {
            $data[$key] = preg_replace('/[^A-Za-z\-]/', '', $value); //ad 0-9 if you want number to be added
        }

        return $data;

    }

    public function removeRT($data)
    {
        foreach ($data as $key => $value){
            $data[$key] = str_replace('RT', '', $value);
        }

        return $data;
    }

    public function removeURL($data)
    {

        $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";

        foreach ($data as $key => $value){
            $data[$key] = preg_replace($regex, ' ', $value);
        }

        return $data;

    }

    public function removeSlangWord($data){

    }



}





