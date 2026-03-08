<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// PUBLIC: Halaman Portofolio
// ──────────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'sendContact'])->name('contact.send');

// ──────────────────────────────────────────────
// AUTH: Login / Logout
// ──────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ──────────────────────────────────────────────
// ADMIN: Semua route dilindungi auth middleware
// ──────────────────────────────────────────────
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',         [AdminController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::get('/profile',  [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile',  [AdminController::class, 'updateProfile'])->name('profile.update');

    // Projects
    Route::get('/projects',          [AdminController::class, 'projects'])->name('projects');
    Route::get('/projects/create',   [AdminController::class, 'createProject'])->name('projects.create');
    Route::post('/projects',         [AdminController::class, 'storeProject'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
    Route::put('/projects/{project}',      [AdminController::class, 'updateProject'])->name('projects.update');
    Route::delete('/projects/{project}',   [AdminController::class, 'destroyProject'])->name('projects.destroy');

    // Pesan Kontak
    Route::get('/messages',                          [AdminController::class, 'messages'])->name('messages');
    Route::patch('/messages/{message}/read',         [AdminController::class, 'readMessage'])->name('messages.read');
    Route::delete('/messages/{message}',             [AdminController::class, 'destroyMessage'])->name('messages.destroy');
});