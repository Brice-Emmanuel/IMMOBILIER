<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BatimentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Artisan;

// --- Routes d'authentification ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- Routes protégées par authentification ---
Route::middleware('auth')->group(function () {

    // Redirection racine vers Dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Bâtiments
    Route::resource('batiments', BatimentController::class);

    // Logements
    Route::resource('logements', LogementController::class);

    // Locataires
    Route::resource('locataires', LocataireController::class);

    // Dépenses
    Route::resource('depenses', DepenseController::class)->except(['edit', 'update']);

    // Paiements & Reçus
    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/create', [PaiementController::class, 'create'])->name('paiements.create');
    Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{paiement}/recu', [PaiementController::class, 'showRecu'])->name('paiements.showRecu');
    Route::get('/paiements/{paiement}/recu/download', [PaiementController::class, 'downloadRecu'])->name('paiements.downloadRecu');
});
// Route::get('/run-migrations', function () {
//     try {
//         Artisan::call('migrate', ['--force' => true]);
//         return '<h1>✅ Migrations exécutées avec succès !</h1><pre>' . Artisan::output() . '</pre>';
//     } catch (\Exception $e) {
//         return '<h1>❌ Erreur de migration :</h1><pre>' . $e->getMessage() . '</pre>';
//     }
// });