<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
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

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth.jwt', 'limit.body.size', 'throttle:60,1'])->group(function () {
    Route::apiResource('users', UserController::class);
});

