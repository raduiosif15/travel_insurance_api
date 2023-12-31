<?php

use App\Http\Controllers\AuthController;
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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


Route::group([
    'middleware' => 'auth'
], function ($router) {
    Route::get('/offers', [\App\Http\Controllers\OfferController::class, 'all']);
    Route::post('/offers', [\App\Http\Controllers\OfferController::class, 'create']);
    Route::get('/offers/{id}', [\App\Http\Controllers\OfferController::class, 'offerById']);
    Route::put('/offers/{id}', [\App\Http\Controllers\OfferController::class, 'edit']);
    Route::patch('/offers/{id}/cancel', [\App\Http\Controllers\OfferController::class, 'cancel']);
});

