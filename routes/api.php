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

/**
 *  JWT authentication based APIs
 */
Route::group(['prefix' => '/v1', 'middleware' => ['jwt']], function() {
    Route::post('/iSamples', 'Api\v1\InitialSamplesController@index')->name('api_browse_i_samples');
    Route::group(['prefix' => '/products'], function() {
        Route::post('/add', 'Api\v1\ProductsController@add')->name('api_add_product');
    });
});