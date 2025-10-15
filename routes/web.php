<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->name('admin');

Route::get('/users', function () {
    return response()->json(
        User::orderBy('created_at', 'desc')->get()
    );
});
Route::get('/users', function () {
    return response()->json(User::orderBy('created_at', 'desc')->get());
});

Route::delete('/users/{id}', [AdminController::class, 'destroy']);

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
