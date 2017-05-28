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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Api\AuthController@signup')->name('api_register');

Route::post('/login', 'Api\AuthController@signin')->name('api_login');

Route::group(['prefix' => 'iSamples', 'middleware' => ['jwt']], function() {
    Route::post('/', 'Api\InitialSamplesController@index')->name('browse_i_samples');
});