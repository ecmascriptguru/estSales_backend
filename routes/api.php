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

Route::post('/v1/register', 'Api\V1\AuthController@signup')->name('api_register');

Route::post('/v1/login', 'Api\V1\AuthController@signin')->name('api_login');

/**
 *  JWT authentication based APIs
 */
Route::group(['prefix' => '/v1', 'middleware' => ['jwt']], function() {
    Route::post('/iSamples', 'Api\V1\InitialSamplesController@index')->name('api_browse_i_samples');

    Route::group(['prefix' => '/products'], function() {
        Route::post('/add', 'Api\V1\ProductsController@add')->name('api_add_product');
    });
    
    Route::group(['prefix' => '/items'], function() {
        Route::post('/', 'Api\V1\ItemsController@index')->name('api_browse_items');
        Route::post('/get', 'Api\V1\ItemsController@get')->name('api_get_item');
        Route::post('/new', 'Api\V1\ItemsController@add')->name('api_new_item');
        Route::post('/del', 'Api\V1\ItemsController@del')->name('api_delete_item');
    });
});