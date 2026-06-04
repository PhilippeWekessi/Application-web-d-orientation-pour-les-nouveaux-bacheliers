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
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminFiliereController;
use App\Http\Controllers\Admin\AdminResponsableController;
use App\Http\Controllers\Admin\AdminActualiteController;
use App\Http\Controllers\Admin\AdminTemoignageController;
use App\Http\Controllers\Admin\AdminUniversiteController;
use App\Http\Controllers\Responsable\ResponsableAuthController;
use App\Http\Controllers\Responsable\ResponsableDashboardController;

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

// Témoignages
Route::get('/temoignages', [TemoignageController::class, 'index'])->name('temoignages.index');
Route::get('/temoignages/create', [TemoignageController::class, 'create'])->name('temoignages.create');
Route::post('/temoignages', [TemoignageController::class, 'store'])->name('temoignages.store');

// ===== AUTHENTIFICATION BACHELIER =====
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/password/forgot', [AuthController::class, 'forgotForm'])->name('password.request');
Route::post('/password/forgot', [AuthController::class, 'forgotSubmit'])->name('password.email');
Route::get('/password/reset', [AuthController::class, 'resetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetSubmit'])->name('password.update');

// ===== ESPACE BACHELIER =====
Route::get('/profil', [ProfilController::class, 'dashboard'])->name('profil');
Route::get('/profil/editer', [AuthController::class, 'editProfile'])->name('profil.edit');
Route::post('/profil/editer', [AuthController::class, 'updateProfile'])->name('profil.update');
Route::post('/abonnements/{id}', [AbonnementController::class, 'ajouter'])->name('abonnements.ajouter');
Route::delete('/abonnements/{id}', [AbonnementController::class, 'retirer'])->name('abonnements.retirer');

// ===== ROUTES ADMIN =====
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/password/forgot', [AdminAuthController::class, 'forgotForm'])->name('password.request');
    Route::post('/password/forgot', [AdminAuthController::class, 'forgotSubmit'])->name('password.email');
    Route::get('/password/reset', [AdminAuthController::class, 'resetForm'])->name('password.reset');
    Route::post('/password/reset', [AdminAuthController::class, 'resetSubmit'])->name('password.update');
    Route::get('/universites/{id}', [AdminUniversiteController::class, 'show'])->name('universites.show');
    Route::post('/universites/{id}/assigner', [AdminUniversiteController::class, 'assignerResponsable'])
         ->name('universites.assigner');
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // ===== PROFIL =====
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminController::class, 'updateProfil'])->name('profil.update');

    // ===== FILIÈRES =====
    Route::get('/filieres', [AdminFiliereController::class, 'index'])->name('filieres');
    Route::get('/filieres/create', [AdminFiliereController::class, 'create'])->name('filieres.create');
    Route::post('/filieres', [AdminFiliereController::class, 'store'])->name('filieres.store');
    Route::get('/filieres/{id}/edit', [AdminFiliereController::class, 'edit'])->name('filieres.edit');
    Route::put('/filieres/{id}', [AdminFiliereController::class, 'update'])->name('filieres.update');
    Route::delete('/filieres/{id}', [AdminFiliereController::class, 'destroy'])->name('filieres.destroy');
    Route::post('/filieres/{id}/valider', [AdminFiliereController::class, 'valider'])->name('filieres.valider');
    Route::get('/filieres/{id}/valider', function () {
        return redirect()->route('admin.filieres')->with('error', 'La validation doit être effectuée via le bouton du tableau.');
    });
    Route::post('/filieres/{id}/rejeter', [AdminFiliereController::class, 'rejeter'])->name('filieres.rejeter');
    Route::get('/filieres/{id}/rejeter', function () {
        return redirect()->route('admin.filieres')->with('error', 'Le rejet doit être effectué via le bouton du tableau.');
    });

    // ===== UNIVERSITÉS =====
    Route::get('/universites', [AdminUniversiteController::class, 'index'])->name('universites');
    Route::get('/universites/create', [AdminUniversiteController::class, 'create'])->name('universites.create');
    Route::post('/universites', [AdminUniversiteController::class, 'store'])->name('universites.store');
    Route::get('/universites/{id}/edit', [AdminUniversiteController::class, 'edit'])->name('universites.edit');
    Route::put('/universites/{id}', [AdminUniversiteController::class, 'update'])->name('universites.update');
    Route::delete('/universites/{id}', [AdminUniversiteController::class, 'destroy'])->name('universites.destroy');
    Route::post('/universites/{id}/valider', [AdminUniversiteController::class, 'valider'])->name('universites.valider');
    Route::post('/universites/{id}/rejeter', [AdminUniversiteController::class, 'rejeter'])->name('universites.rejeter');

    // ===== ACTUALITÉS =====
    Route::get('/actualites', [AdminActualiteController::class, 'index'])->name('actualites');
    Route::get('/actualites/create', [AdminActualiteController::class, 'create'])->name('actualites.create');
    Route::post('/actualites', [AdminActualiteController::class, 'store'])->name('actualites.store');
    Route::delete('/actualites/{id}', [AdminActualiteController::class, 'destroy'])->name('actualites.destroy');

    // ===== TÉMOIGNAGES =====
    Route::get('/temoignages', [AdminTemoignageController::class, 'index'])->name('temoignages');
    Route::post('/temoignages/{id}/valider', [AdminTemoignageController::class, 'valider'])->name('temoignages.valider');
    Route::post('/temoignages/{id}/rejeter', [AdminTemoignageController::class, 'rejeter'])->name('temoignages.rejeter');

    // ===== RESPONSABLES =====
    Route::get('/responsables', [AdminResponsableController::class, 'index'])->name('responsables');
    Route::get('/responsables/create', [AdminResponsableController::class, 'create'])->name('responsables.create');
    Route::post('/responsables', [AdminResponsableController::class, 'store'])->name('responsables.store');
    Route::post('/responsables/{id}/valider', [AdminResponsableController::class, 'valider'])->name('responsables.valider');
    Route::post('/responsables/{id}/rejeter', [AdminResponsableController::class, 'rejeter'])->name('responsables.rejeter');
});

// ===== ESPACE RESPONSABLE =====
Route::prefix('responsable')->name('responsable.')->group(function () {
    Route::get('/login', [ResponsableAuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [ResponsableAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [ResponsableAuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [ResponsableAuthController::class, 'register'])->name('register.post');
    Route::post('/logout', [ResponsableAuthController::class, 'logout'])->name('logout');
    Route::get('/password/forgot', [ResponsableAuthController::class, 'forgotForm'])->name('password.request');
    Route::post('/password/forgot', [ResponsableAuthController::class, 'forgotSubmit'])->name('password.email');
    Route::get('/password/reset', [ResponsableAuthController::class, 'resetForm'])->name('password.reset');
    Route::post('/password/reset', [ResponsableAuthController::class, 'resetSubmit'])->name('password.update');

    Route::get('/dashboard', [ResponsableDashboardController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::get('/profil', [ResponsableDashboardController::class, 'profil'])->name('profil');
    Route::put('/profil', [ResponsableDashboardController::class, 'updateProfil'])->name('profil.update');

    // Université
    Route::get('/universite/create', [ResponsableDashboardController::class, 'createUniversite'])->name('universite.create');
    Route::post('/universite', [ResponsableDashboardController::class, 'storeUniversite'])->name('universite.store');
    
    // Route pour afficher le formulaire (GET)
    Route::get('/filiere/ajouter', [ResponsableDashboardController::class, 'createFiliere'])->name('filiere.create');

    // Route pour ENREGISTRER les données (POST)
    Route::post('/filiere/enregistrer', [ResponsableDashboardController::class, 'storeFiliere'])->name('filiere.store');
});

