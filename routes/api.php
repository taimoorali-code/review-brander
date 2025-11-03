<?php

// use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PlatformController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('businesses', BusinessController::class);
// });
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('businesses/{business}/platforms', [PlatformController::class, 'index']);
//     Route::post('businesses/{business}/platforms', [PlatformController::class, 'store']);
// });
