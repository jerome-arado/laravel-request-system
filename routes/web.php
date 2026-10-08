<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Request routes
    Route::get('/requests', [ServiceRequestController::class, 'index'])
        ->name('requests.index');

    Route::get('/requests/create', [ServiceRequestController::class, 'create'])
        ->name('requests.create');

    Route::post('/requests', [ServiceRequestController::class, 'store'])
        ->name('requests.store');

    Route::get('/requests/{serviceRequest}', [ServiceRequestController::class, 'show'])
        ->name('requests.show');

    Route::patch('/requests/{serviceRequest}/status', [ServiceRequestController::class, 'updateStatus'])
        ->name('requests.updateStatus');
});

require __DIR__ . '/auth.php';