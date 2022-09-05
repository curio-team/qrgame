<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\LeaderboardController;

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

Route::view('/login', 'login')->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => 'teamlogin'], function () {
    
    Route::get('/', [LoginController::class, 'home']);
    Route::get('/qr/{slug}', [QrController::class, 'show']);
    Route::get('/loot/{slug}', [QrController::class, 'loot']);
    Route::get('/assignment/{slug}', [QrController::class, 'assignment']);
    Route::get('/question/{slug}/{answer_given}', [QrController::class, 'question']);

});

Route::get('/scores', [LeaderboardController::class, 'index']);
Route::get('/scores/game/{game}', [LeaderboardController::class, 'show']);
