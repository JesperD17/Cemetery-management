<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;
use App\Models\User;

Route::get('/', fn() => Inertia::render('Home'))->name('home');

Route::get('/begraafplaatsen', function () {
    return Inertia::render('Cemeteries');
})->middleware(['auth'])->name('begraafplaatsen');

Route::get('/begraafplaatsen/overzicht/{name}', function ($name) {
    return Inertia::render('Overview', ['name' => $name]);
})->middleware(['auth'])->name('begraafplaatsen.overzicht');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [AdminController::class, 'index'])
->middleware([EnsureAdminRole::class]);

Route::get('/import', function() {
    return Inertia::render('Import');
})->middleware(['auth', 'verified'])->name('import');

Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('admin');

Route::get('/users', function () {
    return response()->json(
        User::orderBy('created_at', 'desc')->get()
    );
});
Route::get('/users', function () {
    return response()->json(User::orderBy('created_at', 'desc')->get());
});

Route::get('/users', fn() => response()->json(User::latest()->get()));

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::post('/import', [ExcelController::class, 'import'])->name('import');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
