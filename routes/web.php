<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('bussiness.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Business resource routes
Route::middleware(['auth'])->group(function () {
    Route::resource('bussiness', BusinessController::class);
});
Route::middleware(['auth'])->group(function () {
Route::resource('customers', CustomerController::class);});
Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');

// Nested Platform routes
Route::prefix('bussiness/{business}')->group(function () {
    Route::get('platforms', [PlatformController::class, 'index'])->name('platform.index');
    Route::get('platforms/create', [PlatformController::class, 'create'])->name('platform.create');
    Route::post('platforms', [PlatformController::class, 'store'])->name('platform.store');
    Route::get('platforms/{platform}', [PlatformController::class, 'show'])->name('platform.show');
    Route::get('platforms/{platform}/edit', [PlatformController::class, 'edit'])->name('platform.edit');
    Route::put('platforms/{platform}', [PlatformController::class, 'update'])->name('platform.update');
    Route::delete('platforms/{platform}', [PlatformController::class, 'destroy'])->name('platform.destroy');



 Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');

    Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

});
// in web.php



Route::get('bussiness/{business}/platform/{platform}/google/connect', 
    [PlatformController::class, 'connectGoogle']
)->name('platform.google.connect');

Route::get('bussiness/{business}/platform/{platform}/google/callback', 
    [PlatformController::class, 'googleCallback']
)->name('platform.google.callback');




require __DIR__.'/auth.php';
