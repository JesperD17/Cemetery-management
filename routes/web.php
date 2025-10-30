<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/begraafplaatsen', function () {
    return Inertia::render('Cemeteries');
})->middleware(['auth'])->name('begraafplaatsen');

Route::get('/begraafplaatsen/overzicht/{name}', function ($name) {
    return Inertia::render('Overview', ['name' => $name]);
})->middleware(['auth'])->name('begraafplaatsen.overzicht');

Route::get('/admin', [AdminController::class, 'index'])
->middleware([EnsureAdminRole::class])
->name('admin');

Route::get('/import', function() {
    return Inertia::render('Import');
})->middleware(['auth', 'verified'])->name('import');

Route::get('/Begraafplaatshome', [App\Http\Controllers\homepage\BegraafplaatsController::class, 'index']);

Route::post('/import', [ExcelController::class, 'import'])->name('import');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';