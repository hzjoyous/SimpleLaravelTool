<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebDemoController;
use App\Http\Controllers\Controller;

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

 Route::get('/', function () {
     return view('welcome');
 });

 Route::any('/login',function(){
     return '未开发';
 })->name('login');
 Route::get('/spa',function (){
    return view('spa');
 });

Route::get('/webtest',function (){
    return view('test');
});

Route::get('/work', Controller::class.'@index');

Route::any('/phpinfo', fn() => phpinfo());

Route::prefix('demo')->group(function () {
    Route::any('/', [WebDemoController::class, 'index']);
    Route::any('form', [WebDemoController::class, 'form']);
    Route::any('/email', fn() => new App\Mail\UserWelcome());
});




