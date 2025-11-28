<?php

use App\Http\Controllers\AccountsController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;
use App\Http\Controllers\UserApiController;


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

Route::inertia('/accounts', 'Accounts')
    ->middleware(['auth'])
    ->name('accounts');

Route::get('/nieuw-graf', function () {
    return Inertia::render('NewGrave');
})->middleware(['auth'])->name('nieuw-graf');

Route::post('/import', [ExcelController::class, 'import'])->name('import');

Route::inertia('/CemeteryCreate', 'CemeteryCreate')
    ->name('CemeteryCreate');

Route::inertia('/profiel', 'Profile')
    ->name('profiel');

Route::middleware(['auth'])->get('/user', [UserApiController::class, 'profile']);
Route::middleware(['auth'])->put('/profile', [UserApiController::class, 'update']);

Route::inertia('/gemeentes', 'Municipality')
    ->middleware(['auth', EnsureAdminRole::class])
    ->name('gemeentes');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';