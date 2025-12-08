<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAdminRole;
use App\Http\Middleware\EnsureNotRightHolder;


Route::inertia('/', 'Home')
    ->name('home');

Route::inertia('/begraafplaatsen', 'Cemeteries')
    ->middleware(['auth'])
    ->name('begraafplaatsen');

Route::get('/begraafplaatsen/bewerk/{id}', function ($id) {
    return Inertia::render('EditCemetery', ['id' => $id]);
})->middleware(['auth', EnsureAdminRole::class])->name('begraafplaatsen.bewerk');

Route::get('/begraafplaatsen/overzicht/{id}', function ($id) {
    return Inertia::render('Overview', ['id' => $id]);
})->middleware(['auth'])->name('begraafplaatsen.overzicht');

Route::get('/graf/{id}', function ($id) {
    return Inertia::render('GraveDetails', ['id' => $id]);
})->middleware(['auth'])->name('graf');

Route::inertia('/accounts', 'Accounts')
    ->middleware(['auth'])
    ->name('accounts');

Route::get('/nieuw-graf', function () {
    return Inertia::render('NewGrave');
})->middleware(['auth', EnsureAdminRole::class])->name('nieuw-graf');

// Route::post('/import', [ExcelController::class, 'import'])->name('import');

Route::inertia('/begraafplaats-aanmaken', 'CemeteryCreate')
    ->middleware(['auth', EnsureAdminRole::class])
    ->name('begraafplaats-aanmaken');

Route::inertia('/profiel', 'Profile')
    ->middleware(['auth'])
    ->name('profiel');

Route::inertia('/nieuwe-overledene', 'NewDeceased')
    ->middleware(['auth', EnsureAdminRole::class])
    ->name('nieuwe-overledene');

Route::inertia('/gemeentes', 'Municipality')
    ->middleware(['auth', EnsureAdminRole::class])
    ->name('gemeentes');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';