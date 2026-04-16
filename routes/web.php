<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\UniversiteController;
use App\Http\Controllers\ActualiteController;
use App\Http\Controllers\TemoignageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminFiliereController;
use App\Http\Controllers\Responsable\ResponsableAuthController;
use App\Http\Controllers\Responsable\ResponsableDashboardController;
use App\Http\Controllers\Admin\AdminResponsableController;
use App\Http\Controllers\Admin\AdminActualiteController;
use App\Http\Controllers\Admin\AdminTemoignageController;
use App\Http\Controllers\Admin\AdminUniversiteController;

// Accueil
Route::get('/', [AccueilController::class, 'index'])->name('accueil');

// Filières
Route::get('/filieres', [FiliereController::class, 'index'])->name('filieres.index');
Route::get('/filieres/{id}', [FiliereController::class, 'show'])->name('filieres.show');

// Universités
Route::get('/universites', [UniversiteController::class, 'index'])->name('universites.index');
Route::get('/universites/{id}', [UniversiteController::class, 'show'])->name('universites.show');

// Questionnaire
Route::get('/questionnaire', [QuestionnaireController::class, 'index'])->name('questionnaire');
Route::post('/questionnaire', [QuestionnaireController::class, 'submit'])->name('questionnaire.submit');

// Résultats
Route::get('/resultats', [ResultatController::class, 'index'])->name('resultats');

// Actualités
Route::get('/actualites', [ActualiteController::class, 'index'])->name('actualites.index');
Route::get('/actualites/{id}', [ActualiteController::class, 'show'])->name('actualites.show');
Route::post('/actualites/{id}/subscribe', [ActualiteController::class, 'subscribe'])->name('actualites.subscribe')->middleware('auth');

// Témoignages
Route::get('/temoignages', [TemoignageController::class, 'index'])->name('temoignages.index');
Route::post('/temoignages', [TemoignageController::class, 'store'])->name('temoignages.store');

// Profil
Route::get('/profil', fn() => abort(404))->name('profil');

// Authentification
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== ROUTES ADMIN =====
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Filières
    Route::get('/filieres', [AdminFiliereController::class, 'index'])->name('filieres');
    Route::get('/filieres/create', fn() => abort(404))->name('filieres.create');
    Route::get('/filieres/{id}/edit', fn() => abort(404))->name('filieres.edit');
    Route::delete('/filieres/{id}', fn() => abort(404))->name('filieres.destroy');
    Route::post('/filieres/{id}/valider', [AdminFiliereController::class, 'valider'])->name('filieres.valider');
    Route::post('/filieres/{id}/rejeter', [AdminFiliereController::class, 'rejeter'])->name('filieres.rejeter');

    Route::get('/filieres/create', [AdminFiliereController::class, 'create'])->name('filieres.create');
    Route::post('/filieres', [AdminFiliereController::class, 'store'])->name('filieres.store');
    Route::get('/filieres/{id}/edit', [AdminFiliereController::class, 'edit'])->name('filieres.edit');
    Route::put('/filieres/{id}', [AdminFiliereController::class, 'update'])->name('filieres.update');
    Route::delete('/filieres/{id}', [AdminFiliereController::class, 'destroy'])->name('filieres.destroy');

    // Universités
    Route::get('/universites', [AdminUniversiteController::class, 'index'])->name('universites');
    Route::get('/universites/create', [AdminUniversiteController::class, 'create'])->name('universites.create');
    Route::post('/universites', [AdminUniversiteController::class, 'store'])->name('universites.store');
    Route::get('/universites/{id}/edit', [AdminUniversiteController::class, 'edit'])->name('universites.edit');
    Route::put('/universites/{id}', [AdminUniversiteController::class, 'update'])->name('universites.update');
    Route::delete('/universites/{id}', [AdminUniversiteController::class, 'destroy'])->name('universites.destroy');

    // Actualités
    Route::get('/actualites', [AdminActualiteController::class, 'index'])->name('actualites');
    Route::get('/actualites/create', [AdminActualiteController::class, 'create'])->name('actualites.create');
    Route::post('/actualites', [AdminActualiteController::class, 'store'])->name('actualites.store');
    Route::delete('/actualites/{id}', [AdminActualiteController::class, 'destroy'])->name('actualites.destroy');

    // Témoignages
    Route::get('/temoignages', [AdminTemoignageController::class, 'index'])->name('temoignages');
    Route::post('/temoignages/{id}/valider', [AdminTemoignageController::class, 'valider'])->name('temoignages.valider');
    Route::post('/temoignages/{id}/rejeter', [AdminTemoignageController::class, 'rejeter'])->name('temoignages.rejeter');

    // Responsables
    Route::get('/responsables', [AdminResponsableController::class, 'index'])->name('responsables');
    Route::get('/responsables/create', [AdminResponsableController::class, 'create'])->name('responsables.create');
    Route::post('/responsables', [AdminResponsableController::class, 'store'])->name('responsables.store');
    Route::post('/responsables/{id}/valider', [AdminResponsableController::class, 'valider'])->name('responsables.valider');
    Route::post('/responsables/{id}/rejeter', [AdminResponsableController::class, 'rejeter'])->name('responsables.rejeter');
});


// ===== ESPACE RESPONSABLE =====
Route::prefix('responsable')->name('responsable.')->group(function () {

    // Auth
    Route::get('/login', [ResponsableAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [ResponsableAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [ResponsableAuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [ResponsableAuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [ResponsableAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [ResponsableDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/filiere/create', [ResponsableDashboardController::class, 'createFiliere'])->name('filiere.create');
    Route::post('/filiere', [ResponsableDashboardController::class, 'storeFiliere'])->name('filiere.store');
});