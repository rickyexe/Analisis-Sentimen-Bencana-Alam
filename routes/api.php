<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/user/register', 'ApiController@store');
Route::post('/user/login', 'ApiController@login');

Route::get('/user/edit/{id}', 'ApiController@edit')->middleware('auth:api');
Route::get('/user/delete/{id}', 'ApiController@destroy')->middleware('auth:api');
Route::post('/user/update/{id}', 'ApiController@update')->middleware('auth:api');


