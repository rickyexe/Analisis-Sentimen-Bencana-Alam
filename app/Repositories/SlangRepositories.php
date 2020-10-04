<?php

namespace App\Repositories;

use Rap2hpoutre\FastExcel\FastExcel;



class SlangRepositories {


    public function getSlang(){

        $collection = (new FastExcel)->configureCsv(',')->import('storage/dictionary/new_kamusalay.csv');

        $slang = array();
        foreach ($collection as $key =>$value)
        {
            array_push($slang, $value['from']);
        }

        return $slang;
    }

    public function getSlangConversion(){

        $collection = (new FastExcel)->configureCsv(',')->import('storage/dictionary/new_kamusalay.csv');

        $slangConversion = array();
        foreach ($collection as $key =>$value)
        {
            array_push($slangConversion, $value['to']);
        }

        return $slangConversion;

    }




}
