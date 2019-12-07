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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/v1/basket', 'API\V1\BasketController@store');
Route::patch('/v1/basket/{user}', 'API\V1\BasketController@update');
Route::delete('/v1/basket/{user}', 'API\V1\BasketController@destroy');
Route::get('/v1/basket/{user}', 'API\V1\BasketController@index');
