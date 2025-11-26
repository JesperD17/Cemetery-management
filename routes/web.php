<?php

use App\Http\Controllers\AccountsController;
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

Route::get('/begraafplaatsen/bewerk/{id}', function ($id) {
    return Inertia::render('EditCemetery', ['id' => $id]);
})->middleware(['auth'])->name('begraafplaatsen.bewerk');

Route::get('/begraafplaatsen/overzicht/{id}', function ($id) {
    return Inertia::render('Overview', ['id' => $id]);
})->middleware(['auth'])->name('begraafplaatsen.overzicht');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware([EnsureAdminRole::class])
    ->name('admin');

Route::inertia('/accounts', 'Accounts')
    ->middleware(['auth'])
    ->name('accounts');

// Route::inertia('/import', 'Import')
//     ->middleware(['auth', 'verified'])
//     ->name('import');

Route::post('/import', [ExcelController::class, 'import'])->name('import');

Route::inertia('/CemeteryCreate', 'CemeteryCreate')
    ->name('CemeteryCreate');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';