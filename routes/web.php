<?php

use Illuminate\Support\Facades\Route;

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

Route::any('/', function () {
    return view('welcome');
});

Route::any('/phpinfo', fn() => phpinfo());

Route::prefix('demo')->group(function () {
    Route::any('/', 'WebDemoController@index');
    Route::any('form', 'WebDemoController@form');
    Route::any('/email', fn() => new App\Mail\UserWelcome());
});




