<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\EnsureAdminRole;
use App\Models\User;

Route::get('/', fn() => Inertia::render('Home'))->name('home');


Route::middleware(['auth'])->group(function () {


    Route::get('dashboard', fn() => Inertia::render('Dashboard'))
        ->middleware('verified')
        ->name('dashboard');


    Route::get('/begraafplaatsen', fn() => Inertia::render('Cemeteries'))
        ->name('begraafplaatsen');

    Route::get('/begraafplaatsen/overzicht/{name}', fn($name) => Inertia::render('Overview', ['name' => $name]))
        ->name('begraafplaatsen.overzicht');

   
    Route::get('/import', fn() => Inertia::render('Import'))
        ->middleware('verified')
        ->name('import');

    Route::post('/import', [ExcelController::class, 'import'])
        ->middleware('verified')
        ->name('import.store');
});


Route::middleware(['auth', EnsureAdminRole::class])->group(function () {

   
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');


    Route::get('/users', fn() => response()->json(User::latest()->get()));

 
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
