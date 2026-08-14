<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BatimentController;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\PaiementController;

// Routes d'Authentification (Invités)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes Protégées (Utilisateurs connectés)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::resource('batiments', BatimentController::class);
    Route::resource('logements', LogementController::class);
    Route::resource('locataires', LocataireController::class);
    Route::resource('depenses', DepenseController::class);
    Route::resource('paiements', PaiementController::class);
});