<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// ─── Public Routes ────────────────────────────────────────────
Route::get('/', function () {
    return view('store.home');
})->name('home');

// ─── Breeze Auth Routes ───────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Customer Routes ──────────────────────────────────────────
Route::middleware(['auth', 'customer'])->prefix('account')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin Routes ─────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});