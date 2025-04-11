<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Users\UserController;
use App\Http\Middleware\AuthenticateToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(UserController::class)->group(function () {

    Route::post('signup', 'create');
    Route::post('signin', 'authenticate');
});

Route::middleware(AuthenticateToken::class)->group(function () {

    Route::get('/entries/en/{word}', [ApiController::class, 'get'])->name('get_word');
});
