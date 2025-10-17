<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;

Route::get('/', function () {
    return Inertia::render('Home');
})->middleware(['auth'])->name('home');

Route::get('/cemeteries', function () {
    return Inertia::render('Cemeteries');
})->middleware(['auth'])->name('cemeteries');

Route::get('/cemeteries/overview/{name}', function ($name) {
    return Inertia::render('Overview', ['name' => $name]);
})->middleware(['auth'])->name('cemetery.overview');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [AdminController::class, 'index'])
->middleware([EnsureAdminRole::class]);

Route::get('/import', function() {
    return Inertia::render('Import');
})->middleware(['auth', 'verified'])->name('import');

Route::post('/import', [ExcelController::class, 'import'])->name('import');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
