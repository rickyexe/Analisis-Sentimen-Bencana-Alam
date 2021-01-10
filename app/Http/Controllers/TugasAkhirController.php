<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepositories;
use App\Repositories\ProcessRepository;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Classification\NaiveBayes;
use Phpml\Math\Distance\Cosine;
use Phpml\Math\Distance\Euclidean;
use Phpml\Math\Distance\Manhattan;
use Phpml\Metric\Accuracy;
use DB;


class TugasAkhirController extends Controller
{

    public function __construct(DataRepositories $dataRepositories, ProcessRepository $processRepository)
    {
        $this->dataRepositories = $dataRepositories;
        $this->processRepositories = $processRepository;
    }


    public function crawl($data){
        $dataTweet = $this->dataRepositories->getTweets($data);
        $jumlahTweet = count($dataTweet);
        $tweets = array_slice($dataTweet, 0 , ceil($jumlahTweet/2));

        for ($i = 0 ; $i < count($tweets) ; $i++)
        {
            $exist = DB::table('training_data')
                ->where('post', $tweets[$i])
                ->count();

            if ($exist == 0 )
            {
                DB::table('training_data')
                    ->insert([
                        "post" => $tweets[$i],
                        "nilai_sentimen" => "kecil"
                    ]);
            }

        }

        dd('done');
    }


    public  function index(){
        return view('homepage');
    }

    public function processing($query){
        $start = microtime(true);
        if ($query == "kosong")
        {
            session()->flash('fail', "Keyword pencarian tidak boleh kosong");
            return redirect('/');
        }
        $dataTweet = $this->dataRepositories->getTweets($query);

        if($dataTweet == 'error')
        {
            session()->flash('fail', "Sedang terjadi gangguan teknis, coba lagi dalam 10 menit");
            return redirect('/');
        }

        $jumlahTweet = count($dataTweet);
        if($jumlahTweet == 0)
        {
            session()->flash('fail', "Tidak ditemukan tweet yang sesuai dengan pencarian anda");
            return redirect('/');
        }

        $tweets = array_slice($dataTweet, 0 , ceil($jumlahTweet/2));
        $tweetsForResult = array_slice($dataTweet, 0 , ceil($jumlahTweet/2));
        $username = array_slice($dataTweet, ceil($jumlahTweet/2));

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
        $storageResult = array();

        $time1 = array();
        for ($i = 0 ; $i < count($tweetsTFIDF) ; $i++)
        {
            $result = $classifier->predict($tweetsTFIDF[$i]);

            if($result ==  'kecil'){
               $kecil++;
               array_push($storageResult, 'Kecil');
               array_push($time1,microtime(true) - $start);
            }
            else if ($result == 'sedang'){
                $sedang++;
                array_push($storageResult, 'Sedang');
                array_push($time1,microtime(true) - $start);
            }
            else if ($result == 'besar')
            {
                $besar++;
                array_push($storageResult, 'Besar');
                array_push($time1,microtime(true) - $start);
            }
        }

        $finalData = array();

        for ($i =0 ; $i < count($tweetsForResult); $i++)
        {
            $data = [$username[$i], $tweetsForResult[$i], $storageResult[$i]];
            array_push($finalData, $data);
        }

        $kesimpulan = [$kecil, $sedang, $besar];
        $hasilKesimpulan = "";
        rsort($kesimpulan);


        if($kesimpulan[0] == $kecil)
        {
            $hasilKesimpulan = "Kecil";
        }
        else if ($kesimpulan[0] == $sedang)
        {
            $hasilKesimpulan = "Sedang";
        }
        else{
            $hasilKesimpulan = "Besar";
        }


        return view('hasil-analisa', compact('kecil', 'sedang', 'besar', 'query', 'finalData', 'hasilKesimpulan'));
    }


    public function training($kValue){
        if(!preg_match('/^[0-9]+$/', $kValue)){
            session()->flash('fail', "Nilai K harus berupa angka");
            return redirect('/training');
        }

        $trainingData = $this->dataRepositories->getTrainingForTesting();
        $sentimenValue = $this->dataRepositories->getSentimenValueTraining();
        $testingData = $this->dataRepositories->getTestingData();
        $testingDataForResult = $this->dataRepositories->getTestingData();
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


            $classifier = new KNearestNeighbors($k=$kValue, new Cosine());
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

            $finalData = array();


            for ($i =0 ; $i < count($sentimenValueTesting); $i++)
            {
                $status = true;
                if($sentimenValueTesting[$i] != $predictedSentiment[$i] )
                {
                 $status = false;
                }
                $data = [$testingDataForResult[$i], $sentimenValueTesting[$i], $predictedSentiment[$i], $status];
                array_push($finalData, $data);
            }





        return view('training-result', compact('resultAccuracy', 'finalData', 'kValue'));

    }

    public function training2($kValue){
        if(!preg_match('/^[0-9]+$/', $kValue)){
            session()->flash('fail', "Nilai K harus berupa angka");
            return redirect('/training');
        }

        $trainingData = $this->dataRepositories->getTrainingForTesting();
        $sentimenValue = $this->dataRepositories->getSentimenValueTraining();
        $testingData = $this->dataRepositories->getTestingData();
        $testingDataForResult = $this->dataRepositories->getTestingData();
        $sentimenValueTesting = $this->dataRepositories->getSentimenValueTesting();

        $trainingData = $this->processRepositories->preProcessing($trainingData);
        $testingData =$this->processRepositories->preProcessing($testingData);

        $predictedSentiment = array();
        for ($x = 0 ; $x < count($testingData) ; $x++) {
            $combinedData = array_merge($trainingData, [$testingData[$x]]);

            $tfidf = $this->processRepositories->getTFIDF($combinedData); // 2 dimensional array

            $trainingTFIDF = array();
            $testingTFIDF = array();

            for ($i = 0; $i < count($trainingData); $i++) {
                array_push($trainingTFIDF, $tfidf[$i]);
            }

            for ($i = count($trainingData); $i < count($tfidf); $i++) {
                array_push($testingTFIDF, $tfidf[$i]);
            }


            $classifier = new KNearestNeighbors($k = $kValue, new Cosine());
            $classifier->train($trainingTFIDF, $sentimenValue);



            for ($j = 0; $j < count($testingTFIDF); $j++) {
                $result = $classifier->predict($testingTFIDF[$j]);


                if ($result == 'kecil') {
                    array_push($predictedSentiment, 'kecil');
                } else if ($result == 'sedang') {
                    array_push($predictedSentiment, 'sedang');
                } else if ($result == 'besar') {
                    array_push($predictedSentiment, 'besar');
                }
            }

        }
        $finalData = array();

        for ($i = 0; $i < count($sentimenValueTesting); $i++) {
            $status = true;
            if ($sentimenValueTesting[$i] != $predictedSentiment[$i]) {
                $status = false;
            }
            $data = [$testingDataForResult[$i], $sentimenValueTesting[$i], $predictedSentiment[$i], $status];
            array_push($finalData, $data);
        }

        $resultAccuracy = Accuracy::score($sentimenValueTesting, $predictedSentiment);
        $resultAccuracy = $resultAccuracy * 100;






        return view('training-result', compact('resultAccuracy', 'finalData', 'kValue'));

    }

    public function validation(){
        $test = 0.0;
        $resultAccuracyFinal = array();
        $validationSentimen = array();
        for ($z = 1 ; $z < 13 ; $z++)
        {
            $trainingData = $this->dataRepositories->getTrainingForValidation($z);
            $sentimenValue = $this->dataRepositories->getSentimenValueValidation($z);
            $testingData = $this->dataRepositories->getTestingDataValidation($z);
            $sentimenValueTesting = $this->dataRepositories->getSentimenValueTestingValidation($z);



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


            $classifier = new KNearestNeighbors($k=1, new Cosine());
//            $classifier = new NaiveBayes();
            $classifier->train($trainingTFIDF, $sentimenValue);
            $predictedSentiment = array();


            for ($j = 0 ; $j < count($testingTFIDF) ; $j++)
            {
                $result = $classifier->predict($testingTFIDF[$j]);
                if($z > 10 )
                {
                    array_push($validationSentimen, $result);
                }
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
            array_push($resultAccuracyFinal, "Akurasi untuk iterasi ke ".$z." : ".$resultAccuracy);
            $test +=$resultAccuracy;
        }

        dd($resultAccuracyFinal, $test/ 12, $validationSentimen);


        return view('training-result', compact('resultAccuracy', 'kValue'));

    }


        public function validation2(){
            $test = 0.0;
            $resultAccuracyFinal = array();
            $validationSentimen = array();
            for ($z = 1 ; $z < 13 ; $z++)
            {
                $trainingData = $this->dataRepositories->getTrainingForValidation($z);
                $sentimenValue = $this->dataRepositories->getSentimenValueValidation($z);
                $testingData = $this->dataRepositories->getTestingDataValidation($z);
                $sentimenValueTesting = $this->dataRepositories->getSentimenValueTestingValidation($z);



                $trainingData = $this->processRepositories->preProcessing($trainingData);
                $testingData =$this->processRepositories->preProcessing($testingData);
                $predictedSentiment = array();
                for ($x = 0 ; $x < count($testingData) ; $x++)
                {

                    $combinedData = array_merge($trainingData, [$testingData[$x]]);

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


                    $classifier = new KNearestNeighbors($k=2, new Cosine());
//                                $classifier = new NaiveBayes();
                    $classifier->train($trainingTFIDF, $sentimenValue);



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


                }
                $resultAccuracy = Accuracy::score($sentimenValueTesting, $predictedSentiment );
                $resultAccuracy = $resultAccuracy * 100;
                array_push($resultAccuracyFinal, "Akurasi untuk iterasi ke ".$z." : ".$resultAccuracy);
                $test +=$resultAccuracy;

            }

            dd($resultAccuracyFinal, $test/ 12);


            return view('training-result', compact('resultAccuracy', 'kValue'));

        }

        public function proofing(){
            $trainingData = $this->dataRepositories->getTrainingProof();
            $sentimenValue = $this->dataRepositories->getSentimenProof();
            $testingData = $this->dataRepositories->getTestingDataProof();
            $sentimenValueTesting = $this->dataRepositories->getSentimenValueProof();



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


            dd($trainingTFIDF, $testingTFIDF);

        }


    public function preprocessing(){

        $data = [
            'Polri Selalu Menganjurkan di masa pandemi Virus Corona ini untuk selalu rajin rajin mencuci tangan,untuk mencegah penyebaran Covid-19\n
    #Polsektoba\n
    #Polressanggau\n
    #Poldakalbar https://t.co/PEItryAfw1
',
            'Setelah 11 hari berturut-turut tanpa penularan baru virus corona, banyak warga Victoria mulai bertanya apakah mungkin memberantas virus COVID-19 sepenuhnya.\n
    https://t.co/XUbVUJWT3q
',
            'Covid-19: Vaksin \'tonggak bersejarah\', bisa mencegah penularan virus corona hingga 90% https://t.co/mNQyLKUCK9 https://t.co/y1A86wwkEL',
            'RT @detikcom: Barcelona mengaudit keuangan klub yang amburadul gara-gara pandemi virus corona. Dari situ terkuak fakta bahwa Neymar ternyat…',
            'Virus corona menyebabkan beberapa perusahan gulung tikar, yuu dicek foto dibawah, perusahan apa yang berhasil mempertahankan perusahaanya\n
    \n
    Kira-kira apa idemu jika kamu seorang sales/marketing? \n
    Komen dibawah yuk https://t.co/xJecKugUWR
'
        ];


        $trainingData = $this->processRepositories->preProcessing($data);


    }

    public function graphdata(){


        $trainingData = $this->dataRepositories->getTrainingData();
        $sentimenValue = $this->dataRepositories->getSentimenValue();


        $trainingData = $this->processRepositories->preProcessing($trainingData);



        $tfidf = $this->processRepositories->getTFIDF($trainingData); // 2 dimensional array


        $trainingTFIDF  = array();

        $resultBesar = array();
        $resultSedang = array();
        $resultKecil = array();

        for ($i = 0 ; $i < count($trainingData) ; $i++)
        {
            array_push($trainingTFIDF, $tfidf[$i]);
        }


        for ($i = 0 ; $i < count($trainingTFIDF) ; $i++)
        {
            $hasil =  0.0;
            for ($j = 0 ; $j < count($trainingTFIDF[$i]); $j++){
                $hasil += $trainingTFIDF[$i][$j];
            }

            if ($sentimenValue[$i] == 'besar'){
                   array_push($resultBesar,  ['x' => $hasil, 'y' => $hasil]);
            }else if($sentimenValue[$i] == 'sedang'){
                   array_push($resultSedang,  ['x' => $hasil, 'y' => $hasil]);
            }else{
                   array_push($resultKecil, ['x' => $hasil, 'y' => $hasil]);
            }
        }

        return view('graph', compact('resultBesar', 'resultSedang', 'resultKecil'));
    }

    public function move(){

        $data1 = DB::connection('mysql')->table('training_data')->get();

        foreach ($data1 as $item) {

            DB::connection('mysql2')->table('training_data')->insert([

                "post" => $item->post,
                "nilai_sentimen" => $item->nilai_sentimen
            ]);
        }
    }



}
