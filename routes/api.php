<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/demo','ApiDemoController@index');

Route::get('/rgps','ApiDemoController@rgps');

Route::get('/cookie-look','ApiDemoController@cookieLook');


Route::get('/showCode','ApiDemoController@showCode');


Route::post('/uploadFile','ApiDemoController@uploadFile');