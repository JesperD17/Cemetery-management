<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/import', function() {
    return Inertia::render('Import');
})->middleware(['auth', 'verified'])->name('import');

Route::post('/import', [ExcelController::class, 'import'])->name('import');


Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index']);



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
