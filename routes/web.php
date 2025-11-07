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

// -----------------------------
// ✅ Authenticated Routes
// -----------------------------
Route::middleware(['auth'])->group(function () {

    // -----------------------------
    // ✅ Business CRUD
    // -----------------------------
    Route::resource('bussiness', BusinessController::class);

    // -----------------------------
    // ✅ Customer CRUD + Import
    // -----------------------------
    Route::resource('customers', CustomerController::class);
    Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');

    // -----------------------------
    // ✅ Nested Platform Routes (inside business)
    // -----------------------------
    Route::prefix('bussiness/{business}')->group(function () {
        // Platforms CRUD
        Route::get('platforms', [PlatformController::class, 'index'])->name('platform.index');
        Route::get('platforms/create', [PlatformController::class, 'create'])->name('platform.create');
        Route::post('platforms', [PlatformController::class, 'store'])->name('platform.store');
        Route::get('platforms/{platform}', [PlatformController::class, 'show'])->name('platform.show');
        Route::get('platforms/{platform}/edit', [PlatformController::class, 'edit'])->name('platform.edit');
        Route::put('platforms/{platform}', [PlatformController::class, 'update'])->name('platform.update');
        Route::delete('platforms/{platform}', [PlatformController::class, 'destroy'])->name('platform.destroy');

        // Reviews
        Route::get('reviews/{platform}', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
        Route::get('reviews/{reviewId}/replies', [ReviewController::class, 'showReplies'])->name('reviews.replies.view');

        // Google Connect
        Route::get('platform/{platform}/google/connect', [PlatformController::class, 'connectGoogle'])
            ->name('platform.google.connect');

        Route::get('platform/{platform}/google/callback', [PlatformController::class, 'googleCallback'])
            ->name('platform.google.callback');
    });
    Route::get('/business/{businessId}/google/connect', [PlatformController::class, 'connectGoogle'])->name('platform.google.connect');
    Route::get('/google/callback', [PlatformController::class, 'googleCallback'])->name('platform.google.callback');

    Route::get('/business/{business}/platform/{platform}/profiles', [PlatformController::class, 'showProfiles'])
        ->name('platform.google.profiles');


    // -----------------------------
    // ✅ All Reviews (Global)
    // -----------------------------
    Route::get('allreviews', [ReviewController::class, 'getAllSavedReviews'])->name('reviews.all');
});

// -----------------------------
// ✅ Auth Routes
// -----------------------------
require __DIR__ . '/auth.php';
