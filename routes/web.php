<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\FiliereController;

Route::get('/', [AccueilController::class, 'index'])->name('accueil');

// Routes temporaires (on les complétera après)
Route::get('/questionnaire', fn() => view('questionnaire'))->name('questionnaire');
Route::get('/filieres', [FiliereController::class, 'index'])->name('filieres.index');
Route::get('/filieres/{id}', [FiliereController::class, 'show'])->name('filieres.show');
Route::get('/universites', fn() => abort(404))->name('universites.index');
Route::get('/actualites', fn() => abort(404))->name('actualites.index');
Route::get('/temoignages', fn() => abort(404))->name('temoignages.index');
Route::get('/resultats', fn() => abort(404))->name('resultats');
Route::get('/profil', fn() => abort(404))->name('profil');
Route::get('/login', fn() => abort(404))->name('login');
Route::get('/register', fn() => abort(404))->name('register');