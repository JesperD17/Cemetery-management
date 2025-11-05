<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;

Route::inertia('/', 'Home')
    ->name('home');

Route::inertia('/begraafplaatsen', 'Cemeteries')
    ->middleware(['auth'])
    ->name('begraafplaatsen');

Route::get('/begraafplaatsen/overzicht/{name}', function ($name) {
    return Inertia::render('Overview', ['name' => $name]);
})->middleware(['auth'])->name('begraafplaatsen.overzicht');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware([EnsureAdminRole::class])
    ->name('admin');

// Route::inertia('/import', 'Import')
//     ->middleware(['auth', 'verified'])
//     ->name('import');

Route::post('/import', [ExcelController::class, 'import'])->name('import');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';