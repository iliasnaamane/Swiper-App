<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', "PhotoController@index")->name("index");

Route::get('/map/{photo}', "PhotoController@map")->name("photo.map");
Route::get('/create', "PhotoController@create")->name("photos.create");
Route::post('/', "PhotoController@store")->name("photo.store");

Route::get('/cards.json', "PhotoController@cards")->name("photos.json");
Route::get('/previous.json', "PhotoController@previousCards")->name("previous.json");