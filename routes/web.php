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

Route::prefix('elasticsearch')->group(function(){
  Route::get('test',['uses'=>'ClientController@elasticsearchTest']);
  Route::get('data',['uses'=>'ClientController@elasticsearchData']);

});


Route::prefix('elastica')->group(function(){
  Route::get('test',['uses'=>'ClientController@elasticaTest']);
  Route::get('data',['uses'=>'ClientController@elasticaData']);

});
