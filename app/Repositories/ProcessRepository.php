<?php

namespace App\Repositories;


use Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Sastrawi\Stemmer\StemmerFactory;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use App\Repositories\SlangRepositories;



class ProcessRepository {

    public function __construct(SlangRepositories $slangRepositories)
    {
        $this->slangRepositories = $slangRepositories;
    }


    public function preProcessing($data){

        // ini diatas karena mention harus dihilangkan dulu karena jika stopword dulu maka nama nya akan tetap disana karena tidak ada penanda @
        //hashtag juga dihilangkan sebelum # nya saja yang di remove
        //stopword dan stemmer diletakkan dibawah karena mereka akan menganggu untuk proses yang lain
        $data = $this->removeRT($data);
        $data = $this->removeAdd($data);
        $data = $this->removeHashtag($data);
        $data = $this->removeURL($data);
        $data = $this->removeSymbolandNumber($data);
        $data = $this->replaceSlangWord($data);


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



        return $data;

    }

    public function getTFIDF($data){

        $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
        $tf->fit($data);
        $tf->transform($data);


        $tfidf = new TfIdfTransformer($data);
        $tfidf->transform($data);

        return $data;
    }

    public function removeSymbolandNumber($data){

        foreach  ($data as $key => $value) {
            $data[$key] = preg_replace('/[^a-zA-Z\s]+/', '', $value);
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

        $regex = "@(https?://([-\w\.]+)(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";

        foreach ($data as $key => $value){
            $data[$key] = preg_replace($regex, '', $value);
        }

        return $data;

    }

    public function removeAdd($data){
        $regex = '/@[a-z_0-9:]+/i';

        foreach ($data as $key => $value){
            $data[$key] = preg_replace($regex, '', $value);
        }

        return $data;
    }

    public function removeHashtag($data){
        $regex = '/#[a-z0-9]+/i';

        foreach ($data as $key => $value){
            $data[$key] = preg_replace($regex, '', $value);
        }

        return $data;
    }

    public function replaceSlangWord($data){
        $slang = $this->slangRepositories->getSlang();
        $slangConversion = $this->slangRepositories->getSlangConversion();

        for ($i = 0 ; $i < count($data) ; $i++)
        {

            $dataSplit = explode(" ", $data[$i]);
            $storeForImplode  =array();

            for ($j = 0 ; $j < count($dataSplit) ; $j++)
            {
                $index = array_search($dataSplit[$j], $slang);

                if($index != false)
                {
                    $slangConversionData = $slangConversion[$index];
                    array_push($storeForImplode,$slangConversionData);
                }
                else
                {
                    array_push($storeForImplode, $dataSplit[$j]);
                }

            }

            $implodeResult = implode(" ", $storeForImplode);
            $data[$i] = $implodeResult;

        }
        return $data;
    }



}





