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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


/**
 *  Front APIs without jwt
 */
Route::group(['prefix' => '/api/v1'], function() {
    Route::post('/get_initial_samples', 'ISamplesController@ajax_samples')->name('front_api_browse_i_samples');
    Route::group(['prefix' => '/samples'], function() {
        Route::post('/add', 'Api\V1\SamplesController@add')->name('front_api_add_sample');
    });
});
