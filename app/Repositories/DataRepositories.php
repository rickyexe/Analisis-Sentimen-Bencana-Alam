<?php

namespace App\Repositories;

use Abraham\TwitterOAuth\TwitterOAuth;
use DB;
use App\Post;



class DataRepositories {


    public function getTweets($query){

        $consumer_key = 'HYbfpODBDP5xxEdBfAL0lgKOG';
        $consumer_secret = '8xyHpZ768t5XCeZPsPu8dXuQqBSFB5qQMe9UR1ORVdlhAKTrvX';
        $access_token = '1301891683093626884-MiHAhcwQZNwG1HqdynGjh1Lmg3cmqM';
        $access_token_secret = '3LwoyxP9LmyKoGQ0fwjeLbJ7ngTLOSHCPmFdvL0tml99i';
        $connection = new TwitterOAuth($consumer_key,$consumer_secret, $access_token , $access_token_secret);
        $content = $connection->get("account/verify_credentials");
        $status = $connection->get("search/tweets", ["q" => $query, 'count' => 100 ,'lang' => 'id', 'result_type' => 'mixed', 'tweet_mode' => 'extended']);
        $convertedStatus = (array)$status;

        $data = array();

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
        $post1 = Post::select('post')->where('id', '>' , 30)->where('id', '<', 101)->get();
        $post2 = Post::select('post')->where('id', '>' , 130)->where('id', '<', 201)->get();
        $post3 = Post::select('post')->where('id', '>' , 230)->get();

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
        $sentimen1 = Post::select('nilai_sentimen')->where('id', '>' , 30)->where('id', '<', 101)->get();
        $sentimen2 = Post::select('nilai_sentimen')->where('id', '>' , 130)->where('id', '<', 201)->get();
        $sentimen3 = Post::select('nilai_sentimen')->where('id', '>' , 230)->get();

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
        $post2 = Post::select('post')->where('id', '>' , 100)->where('id', '<', 131)->get();
        $post3 = Post::select('post')->where('id', '>' , 200)->where('id', '<', 231)->get();

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
        $sentimen2 = Post::select('nilai_sentimen')->where('id', '>' , 100)->where('id', '<', 131)->get();
        $sentimen3 = Post::select('nilai_sentimen')->where('id', '>' , 200)->where('id', '<', 231)->get();

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



}





