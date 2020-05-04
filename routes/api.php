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

Route::any('/demo', 'ApiDemoController@index');
Route::any('/show-request', 'ApiDemoController@showRequest');
Route::get('/cookie-look', 'ApiDemoController@cookieLook');
Route::get('/showCode', 'ApiDemoController@showCode');
Route::post('/upload', 'ApiDemoController@uploads');

Route::prefix('/tool')->group(function () {
    Route::get('', 'ToolController@index');
    Route::get('opCacheClean', 'ToolController@opCacheClean');
});
