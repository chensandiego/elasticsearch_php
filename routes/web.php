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
  Route::get('queries',['uses'=>'ClientController@elasticsearchQueries']);
  Route::get('advanced',['uses'=>'ClientController@elasticsearchAdvanced']);



});


Route::prefix('elastica')->group(function(){
  Route::get('test',['uses'=>'ClientController@elasticaTest']);
  Route::get('data',['uses'=>'ClientController@elasticaData']);
  Route::get('queries',['uses'=>'ClientController@elasticaQueries']);
  Route::get('advanced',['uses'=>'ClientController@elasticaAdvanced']);


});


Route::prefix('duck')->group(function(){
  Route::get('search',['uses'=>'DuckController@search','as' => 'duck_search']);
});
