<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('events', EventController::class);
//     Route::resource('events.participants', ParticipantController::class);
// });

Route::middleware(['auth', 'verified'])->group(function () {
    // Route per gli eventi
    Route::resource('events', EventController::class);
    
    // Route per i partecipanti (nested dentro events)
    Route::resource('events.participants', ParticipantController::class);
});

require __DIR__.'/auth.php';
