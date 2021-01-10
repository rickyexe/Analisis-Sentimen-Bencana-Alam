<?php

namespace App\Repositories;

use Abraham\TwitterOAuth\TwitterOAuth;
use DB;
use App\Post;



class DataRepositories {


    public function getTweets($query){
        $consumer_key = env('CONSUMER_KEY', 'abcde');
        $consumer_secret = env('CONSUMER_SECRET', 'abcde');
        $access_token = env('ACCESS_TOKEN', 'abcde');
        $access_token_secret = env('ACCESS_TOKEN_SECRET','abcde');
        $connection = new TwitterOAuth($consumer_key,$consumer_secret, $access_token , $access_token_secret);
        $connection->setTimeouts(20, 30);
        $status = $connection->get("search/tweets", ["q" => $query, 'count' => 100 ,'lang' => 'id', 'result_type' => 'recent', 'tweet_mode' => 'extended']);
        $convertedStatus = (array)$status;
        $data = array();

        if(isset($convertedStatus['errors']) )
        {
           return 'error';
        }

        for ($i = 0 ; $i < count($convertedStatus['statuses']) ; $i++)
        {
         array_push($data,$convertedStatus['statuses'][$i]->full_text );
        }

        for ($i = 0 ; $i < count($convertedStatus['statuses']) ; $i++)
        {
            array_push($data,$convertedStatus['statuses'][$i]->user->screen_name );
        }
        return $data;
    }

    public function getTrainingData(){

        $trainingData = Post::select('post')->get();

        $data = array();
        foreach ($trainingData as $item) {

            array_push($data, $item->post);
        }

        return $data;
    }

    public function getSentimenValue()
    {

        $sentimenValue = Post::select('nilai_sentimen')->get();

        $data = array();
        foreach ($sentimenValue as $item) {

            array_push($data, $item->nilai_sentimen);
        }

        return $data;
    }


    public function getTrainingForTesting(){
        $post1 = Post::select('post')->where('id', '>' , 30)->where('id', '<', 225)->get();
        $post2 = Post::select('post')->where('id', '>' , 254)->where('id', '<', 354)->get();
        $post3 = Post::select('post')->where('id', '>' , 383)->get();

        $data = array();
        foreach ($post1 as $item) {
            array_push($data, $item->post);
        }
        foreach ($post2 as $item) {
            array_push($data, $item->post);
        }
        foreach ($post3 as $item) {
            array_push($data, $item->post);
        }

        return $data;
    }

    public function getSentimenValueTraining(){
        $sentimen1 = Post::select('nilai_sentimen')->where('id', '>' , 30)->where('id', '<', 225)->get();
        $sentimen2 = Post::select('nilai_sentimen')->where('id', '>' , 254)->where('id', '<', 354)->get();
        $sentimen3 = Post::select('nilai_sentimen')->where('id', '>' , 383)->get();

        $data = array();
        foreach ($sentimen1 as $item) {
            array_push($data, $item->nilai_sentimen);
        }
        foreach ($sentimen2 as $item) {
            array_push($data, $item->nilai_sentimen);
        }
        foreach ($sentimen3 as $item) {
            array_push($data, $item->nilai_sentimen);
        }

        return $data;
    }

    public function getTestingData(){
        //indeks 1-30
        // indeks 101 -130
        // indeks 201- 230
        $post1 = Post::select('post')->where('id', '<' , 31)->get();
        $post2 = Post::select('post')->where('id', '>' , 224)->where('id', '<', 255)->get();
        $post3 = Post::select('post')->where('id', '>' , 353)->where('id', '<', 384)->get();

        $data = array();
        foreach ($post1 as $item) {
            array_push($data, $item->post);
        }
        foreach ($post2 as $item) {
            array_push($data, $item->post);
        }
        foreach ($post3 as $item) {
            array_push($data, $item->post);
        }

        return $data;


    }

    public function getSentimenValueTesting(){
        $sentimen1 = Post::select('nilai_sentimen')->where('id', '<' , 31)->get();
        $sentimen2 = Post::select('nilai_sentimen')->where('id', '>' , 224)->where('id', '<', 255)->get();
        $sentimen3 = Post::select('nilai_sentimen')->where('id', '>' , 353)->where('id', '<', 384)->get();

        $data = array();
        foreach ($sentimen1 as $item) {
            array_push($data, $item->nilai_sentimen);
        }
        foreach ($sentimen2 as $item) {
            array_push($data, $item->nilai_sentimen);
        }
        foreach ($sentimen3 as $item) {
            array_push($data, $item->nilai_sentimen);
        }

        return $data;
    }

    public function getTrainingForValidation($iteration){
        $data = array();
//        if($iteration == 1)
//        {
//            $firstID = 29;
//            $trainingData1 = Post::select('post')->where('id', '>' , $firstID)->get();
//
//            foreach ($trainingData1 as $item) {
//                array_push($data, $item->post);
//            }
//        }
//        else if($iteration == 16)
//        {
//            $firstID = 435;
//            $trainingData1 = Post::select('post')->where('id', '<=' , $firstID)->get();
//            foreach ($trainingData1 as $item) {
//                array_push($data, $item->post);
//            }
//
//        }
//        else
//        {
//            $firstID = ($iteration - 1) * 29;
//            $secondID = $iteration * 29;
//
//
//            $trainingData1 = Post::select('post')->where('id', '<=' , $firstID)->get();
//            $trainingData2 = Post::select('post')->where('id', '>' , $secondID)->get();
//
//
//
//
//            foreach ($trainingData1 as $item) {
//                array_push($data, $item->post);
//            }
//
//            foreach ($trainingData2 as $item) {
//                array_push($data, $item->post);
//            }
//
//        }

        if($iteration == 1)
        {
            $firstID = 35;
            $trainingData1 = Post::select('post')->where('id', '>' , $firstID)->get();

            foreach ($trainingData1 as $item) {
                array_push($data, $item->post);
            }
        }
        else if($iteration == 12)
        {
            $firstID = 385;
            $trainingData1 = Post::select('post')->where('id', '<=' , $firstID)->get();
            foreach ($trainingData1 as $item) {
                array_push($data, $item->post);
            }

        }
        else
        {
            $firstID = ($iteration - 1) * 35;
            $secondID = $iteration * 35;


            $trainingData1 = Post::select('post')->where('id', '<=' , $firstID)->get();
            $trainingData2 = Post::select('post')->where('id', '>' , $secondID)->get();




            foreach ($trainingData1 as $item) {
                array_push($data, $item->post);
            }

            foreach ($trainingData2 as $item) {
                array_push($data, $item->post);
            }

        }

        return $data;
    }

    public function getSentimenValueValidation($iteration){
        $data = array();
//        if($iteration == 1)
//        {
//            $firstID = 29;
//            $trainingData1 = Post::select('nilai_sentimen')->where('id', '>' , $firstID)->get();
//
//            foreach ($trainingData1 as $item) {
//                array_push($data, $item->nilai_sentimen);
//            }
//        }
//        else if($iteration == 16)
//        {
//            $firstID = 435;
//            $trainingData1 = Post::select('nilai_sentimen')->where('id', '<=' , $firstID)->get();
//            foreach ($trainingData1 as $item) {
//                array_push($data, $item->nilai_sentimen);
//            }
//
//        }
//        else
//        {
//            $firstID = ($iteration - 1 )* 29;
//            $secondID = $iteration * 29;
//
//            $trainingData1 = Post::select('nilai_sentimen')->where('id', '<=' , $firstID)->get();
//            $trainingData2 = Post::select('nilai_sentimen')->where('id', '>' , $secondID)->get();
//
//
//            foreach ($trainingData1 as $item) {
//                array_push($data, $item->nilai_sentimen);
//            }
//
//            foreach ($trainingData2 as $item) {
//                array_push($data, $item->nilai_sentimen);
//            }
//
//        }

        if($iteration == 1)
        {
            $firstID = 35;
            $trainingData1 = Post::select('nilai_sentimen')->where('id', '>' , $firstID)->get();

            foreach ($trainingData1 as $item) {
                array_push($data, $item->nilai_sentimen);
            }
        }
        else if($iteration == 12)
        {
            $firstID = 385;
            $trainingData1 = Post::select('nilai_sentimen')->where('id', '<=' , $firstID)->get();
            foreach ($trainingData1 as $item) {
                array_push($data, $item->nilai_sentimen);
            }

        }
        else
        {
            $firstID = ($iteration - 1 )* 35;
            $secondID = $iteration * 35;

            $trainingData1 = Post::select('nilai_sentimen')->where('id', '<=' , $firstID)->get();
            $trainingData2 = Post::select('nilai_sentimen')->where('id', '>' , $secondID)->get();


            foreach ($trainingData1 as $item) {
                array_push($data, $item->nilai_sentimen);
            }

            foreach ($trainingData2 as $item) {
                array_push($data, $item->nilai_sentimen);
            }

        }

        return $data;
    }

    public function getTestingDataValidation($iteration){
//        if($iteration == 1)
//        {
//            $firstID = 0;
//            $secondID = 29;
//        }
//        else
//        {
//            $firstID = ($iteration - 1) * 29;
//            $secondID = $iteration * 29;
//        }
//
//        $testingData = Post::select('post')->where('id', '>' , $firstID)->where('id', '<=', $secondID)->get();
//
//
//        $data = array();
//        foreach ($testingData as $item) {
//            array_push($data, $item->post);
//        }

        if($iteration == 1)
        {
            $firstID = 0;
            $secondID = 35;
        }
        else
        {
            $firstID = ($iteration - 1) * 35;
            $secondID = $iteration * 35;
        }

        $testingData = Post::select('post')->where('id', '>' , $firstID)->where('id', '<=', $secondID)->get();


        $data = array();
        foreach ($testingData as $item) {
            array_push($data, $item->post);
        }

        return $data;



    }

    public function getSentimenValueTestingValidation($iteration){
//        if($iteration == 1)
//        {
//            $firstID = 0;
//            $secondID = 29;
//        }
//        else
//        {
//            $firstID = ($iteration - 1) * 29;
//            $secondID = $iteration * 29;
//        }
//
//        $sentimenData = Post::select('nilai_sentimen')->where('id', '>' , $firstID)->where('id', '<=', $secondID)->get();
//
//
//        $data = array();
//        foreach ($sentimenData as $item) {
//            array_push($data, $item->nilai_sentimen);
//        }

//        if($iteration == 1)
//        {
//            $firstID = 0;
//            $secondID = 35;
//        }
//        else
//        {
//            $firstID = ($iteration - 1) * 35;
//            $secondID = $iteration * 35;
//        }
//
//        $sentimenData = Post::select('nilai_sentimen')->where('id', '>' , $firstID)->where('id', '<=', $secondID)->get();
//
//
//        $data = array();
//        foreach ($sentimenData as $item) {
//            array_push($data, $item->nilai_sentimen);
//        }


        return $data;
    }

    public function getTrainingProof(){
        $post1 = Post::select('post')->where('id', '<' , 4)->get();

        $data = array();
        foreach ($post1 as $item) {
            array_push($data, $item->post);
        }

        return $data;
    }

    public function getSentimenProof(){
        $post1 = Post::select('nilai_sentimen')->where('id', '<' , 4)->get();

        $data = array();
        foreach ($post1 as $item) {
            array_push($data, $item->nilai_sentimen);
        }

        return $data;
    }

    public function getTestingDataProof(){
//        $post1 = Post::select('post')->where('id','>', 199)->where('id','<', 203)->get();
        $post1 = Post::select('post')->where('id', 200)->get();

        $data = array();
        foreach ($post1 as $item) {
            array_push($data, $item->post);
        }

        return $data;
    }

    public function getSentimenValueProof(){
//        $post1 = Post::select('nilai_sentimen')->where('id','>', 199)->where('id','<', 203)->get();
        $post1 = Post::select('nilai_sentimen')->where('id',200)->get();

        $data = array();
        foreach ($post1 as $item) {
            array_push($data, $item->nilai_sentimen);
        }

        return $data;
    }


}





