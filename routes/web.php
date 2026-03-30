<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EvenementController;   
use App\Http\Controllers\LoyerController;  
use App\Http\Controllers\SubventionController;  
use App\Http\Controllers\AmicaleController;  
use App\Http\Controllers\LoginController;  

// Authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Zone protégée par authentification
Route::middleware('auth')->group(function () {
	Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

	Route::get('etudiants/export', [EtudiantController::class, 'export'])->name('etudiants.export');
	Route::resource('etudiants', EtudiantController::class);
	Route::get('cotisations/export', [CotisationController::class, 'export'])->name('cotisations.export');
	Route::resource('cotisations', CotisationController::class);
	Route::get('depenses/export', [DepenseController::class, 'export'])->name('depenses.export');
	Route::resource('depenses', DepenseController::class);
	Route::resource('evenements', EvenementController::class);
	Route::get('loyers/export', [LoyerController::class, 'export'])->name('loyers.export');
	Route::get('loyers/retards', [LoyerController::class, 'retards'])->name('loyers.retards');
	Route::resource('loyers', LoyerController::class);
	Route::get('subventions/export', [SubventionController::class, 'export'])->name('subventions.export');
	Route::resource('subventions', SubventionController::class);
	Route::resource('amicales', AmicaleController::class);
});