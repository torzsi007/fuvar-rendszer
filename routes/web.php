<?php

use App\Http\Controllers\Admin\MunkaController;
use App\Http\Controllers\Admin\FuvarozoController;
use App\Http\Controllers\Fuvarozo\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Átirányítás a szerepkörnek megfelelő dashboard-ra
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.munkak.index');
    }
    return redirect()->route('fuvarozo.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Munkák CRUD - MÓDOSÍTVA: explicit paraméter név megadása
    Route::resource('munkak', MunkaController::class)->parameters([
        'munkak' => 'munka'  // A {munkak} paramétert {munka}-ként bindoljuk
    ]);

    // Munkák hozzárendelése - MÓDOSÍTVA: konzisztens paraméter név
    Route::get('munkak/{munka}/assign', [MunkaController::class, 'assignForm'])->name('munkak.assign.form');
    Route::post('munkak/{munka}/assign', [MunkaController::class, 'assign'])->name('munkak.assign');

    // Fuvarozók listája
    Route::get('fuvarozok', [FuvarozoController::class, 'index'])->name('fuvarozok.index');
});

// FUVAROZO ROUTES
Route::middleware(['auth', 'role:fuvarozo'])->prefix('fuvarozo')->name('fuvarozo.')->group(function () {
    // Saját dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Státusz módosítás
    Route::patch('/munkak/{munka}/status', [DashboardController::class, 'updateStatus'])->name('update-status');
});

// Breeze auth routes (NE módosítsd!)
require __DIR__.'/auth.php';
