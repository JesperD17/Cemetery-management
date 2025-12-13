<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\EnsureMangerRole;
use App\Http\Middleware\EnsureNotRightHolder;


Route::inertia('/', 'Home')
    ->name('home');

Route::inertia('/begraafplaatsen', 'Cemeteries')
    ->middleware(['auth'])
    ->name('begraafplaatsen');

Route::get('/begraafplaatsen/bewerk/{id}', function ($id) {
    return Inertia::render('EditCemetery', ['id' => $id]);
})->middleware(['auth', EnsureMangerRole::class])->name('begraafplaatsen.bewerk');

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
})->middleware(['auth', EnsureMangerRole::class])->name('nieuw-graf');

// Route::post('/import', [ExcelController::class, 'import'])->name('import');

Route::inertia('/begraafplaats-aanmaken', 'CemeteryCreate')
    ->middleware(['auth', EnsureMangerRole::class])
    ->name('begraafplaats-aanmaken');

Route::inertia('/profiel', 'Profile')
    ->middleware(['auth'])
    ->name('profiel');

Route::inertia('/nieuwe-overledene', 'NewDeceased')
    ->middleware(['auth', EnsureMangerRole::class])
    ->name('nieuwe-overledene');

Route::inertia('/gemeentes', 'Municipality')
    ->middleware(['auth', EnsureMangerRole::class])
    ->name('gemeentes');

Route::middleware('auth')->get('/meldingen', fn() => Inertia::render('Notifications'))->name('meldingen');
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';