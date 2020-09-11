<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\ApiDemoController;
use App\Http\Controllers\Api\ToolController;

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


Route::any('/demo', [ApiDemoController::class, 'index']);
Route::any('/show-request', [ApiDemoController::class, 'showRequest']);
Route::get('/cookie-look', [ApiDemoController::class, 'cookieLook']);
Route::get('/showCode', [ApiDemoController::class, 'showCode']);
Route::post('/upload', [ApiDemoController::class, 'uploads']);

Route::prefix('/tool')->group(function () {
    Route::get('', [ToolController::class, 'index']);
    Route::get('opCacheClean', [ToolController::class, 'opCacheClean']);
});
