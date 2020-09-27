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
        $access_token_secret = env('ACCESS_TOKEN_SECRET', 'abcde');
        $connection = new TwitterOAuth($consumer_key,$consumer_secret, $access_token , $access_token_secret);
        $content = $connection->get("account/verify_credentials");
        $status = $connection->get("search/tweets", ["q" => $query, 'count' => 100 ,'lang' => 'id', 'result_type' => 'mixed', 'tweet_mode' => 'extended']);
        $convertedStatus = (array)$status;

        $data = array();

        for ($i = 0 ; $i < count($convertedStatus['statuses']) ; $i++)
        {
         array_push($data,$convertedStatus['statuses'][$i]->full_text );
        }

        return $data;

    }

    public function getTrainingData(){

        $trainingData = Post::select('post')->get();

        return $trainingData;
    }

    public function getSentimenValue()
    {

        $sentimenValue = Post::select('nilai_sentimen')->get();

        return $sentimenValue;
    }



}





