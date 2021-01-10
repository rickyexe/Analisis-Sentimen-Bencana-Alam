<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//main program
Route::get('/', 'TugasAkhirController@index');
Route::get('/preprocessing', 'TugasAkhirController@preprocessing');
Route::get('/hasil-analisa/{query}', 'TugasAkhirController@processing')->name('hasil-analisa');
Route::get('/training', function(){
    return view('training');
});
Route::get('/training-result/{k}', 'TugasAkhirController@training');



//additional program
Route::get('/training-result2/{k}', 'TugasAkhirController@training2');
Route::get('/validation', 'TugasAkhirController@validation');
Route::get('/validation2', 'TugasAkhirController@validation2');
Route::get('/move', 'TugasAkhirController@move');
Route::get('/graph', 'TugasAkhirController@graphdata');
Route::get('/proofing', 'TugasAkhirController@proofing');
Route::get('/crawl/{crawl}', 'TugasAkhirController@crawl');
Route::get('/home', 'HomeController@index')->name('home');
