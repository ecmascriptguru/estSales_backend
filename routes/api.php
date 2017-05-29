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

Route::post('/v1/register', 'Api\v1\AuthController@signup')->name('api_register');

Route::post('/v1/login', 'Api\v1\AuthController@signin')->name('api_login');

Route::group(['prefix' => '/v1/iSamples', 'middleware' => ['jwt']], function() {
    Route::post('/', 'Api\v1\InitialSamplesController@index')->name('browse_i_samples');
});
Route::post('/v1/get_initial_samples', 'ISamplesController@ajax_samples')->name('front_api_samples');