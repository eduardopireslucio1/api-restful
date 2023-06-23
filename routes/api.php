<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\ClientController;

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

Route::prefix('liberfly')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::prefix('me')->group(function () {
        Route::get('', [MeController::class, 'index']);
    });

    Route::prefix('clients')->group(function () {
        Route::get('', [ClientController::class, 'index']);
        Route::post('', [ClientController::class, 'store']);
        Route::get('{client}', [ClientController::class, 'show']);
        Route::put('{client}', [ClientController::class, 'update']);
        Route::delete('{client}', [ClientController::class, 'destroy']);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
