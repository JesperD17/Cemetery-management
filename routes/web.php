<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index']);

Route::get('/Begraafplaatshome', [App\Http\Controllers\homepage\BegraafplaatsController::class, 'index']);




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
