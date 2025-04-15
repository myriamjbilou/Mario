<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RentalController;

// Redirige la racine vers la page de connexion pour le staff
Route::get('/', function () {
    return view('login_staff');
})->name('login_staff_page');

// Route pour traiter la connexion du staff
Route::post('/login_staff', [LoginController::class, 'login'])->name('login_staff');

// Route de déconnexion personnalisée (vide la session)
Route::post('/logout', function () {
    session()->flush();
    return redirect()->route('login_staff_page')->with('success', 'Déconnexion réussie.');
})->name('logout');

// Route Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Routes de profil (non protégées pour l'instant)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Routes pour les films
Route::get('/films', [FilmController::class, 'index'])->name('films.index'); // Liste des films
Route::get('/films/create', [FilmController::class, 'create'])->name('films.create'); // Formulaire d'ajout
Route::post('/films', [FilmController::class, 'store'])->name('films.store'); // Soumission du formulaire d'ajout
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show'); // Détails d'un film
Route::get('/films/{id}/edit', [FilmController::class, 'edit'])->name('films.edit'); // Formulaire de modification
Route::put('/films/{id}', [FilmController::class, 'update'])->name('films.update'); // Mise à jour d'un film
Route::delete('/films/{id}', [FilmController::class, 'destroy'])->name('films.destroy'); // Suppression d'un film



Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::delete('/inventory/{film_id}/{store_id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

Route::get('/rental', [RentalController::class, 'index'])->name('rental.index');

// require __DIR__.'/auth.php';
