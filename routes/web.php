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

Route::get('/', 'TugasAkhirController@index');
Route::get('/hasil-analisa/{query}', 'TugasAkhirController@processing')->name('hasil-analisa');
Route::get('/training','TugasAkhirController@trainingPage' );
Route::get('/training-result/{k}', 'TugasAkhirController@training');

Route::get('/home', 'HomeController@index')->name('home');
