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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post('new-api', 'TestController@newAPI');

Route::post('api_response', 'TestController@apiResponse');

Route::post('api_move', 'TestController@apiMoveFile');

Route::get('api_get', 'TestController@apiAuth');
