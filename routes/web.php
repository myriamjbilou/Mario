<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilmController; // Assurez-vous d'importer le FilmController
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour l'onglet Film
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('films/{id}', [FilmController::class, 'show'])->name('films.show');

require __DIR__.'/auth.php';

