<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CemeteriesController;
use App\Http\Controllers\DeceasedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GravesController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\RolesController;
use App\Http\Middleware\EnsureMangerRole;
use App\Http\Middleware\RequestTypes;
use App\Http\Controllers\GraveController;
use App\Http\Controllers\GraveDeceasedController;
use App\Http\Controllers\UserApiController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('nieuwe-gebruiker', [RegisteredUserController::class, 'create'])
        ->name('nieuwe-gebruiker');

    Route::post('nieuwe-gebruiker', [RegisteredUserController::class, 'store']);

    Route::get('/user', [UserApiController::class, 'profile']);
    Route::put('/profile', [UserApiController::class, 'update']);

        
    Route::post('/nieuw-graf', [GraveController::class, 'index']);

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

    Route::get('/api/cemeteries', [CemeteriesController::class, 'index']);
    Route::get('/cemeteryById', [CemeteriesController::class, 'id']);
    Route::put('/updateCemetery/{id}', [CemeteriesController::class, 'updateCemetery']);
    Route::get('/graves', [GravesController::class, 'index']);
    Route::get('/api/gravesByCemetery/{cemeteryID}', [GravesController::class, 'show']);
    Route::get('/api/graveDeceased/{graveID}/{deceasedID}', [GraveDeceasedController::class, 'store']);
    Route::get('/roles', [RolesController::class, 'index'])
        ->middleware(RequestTypes::class);
    Route::get('/getAccounts', [AccountsController::class, 'index'])
        ->middleware(RequestTypes::class);
    Route::put('/updateAccount/{id}', [AccountsController::class, 'update'])
        ->middleware(RequestTypes::class);

    Route::get('/municipalities', [MunicipalityController::class, 'show'])
        ->middleware(EnsureMangerRole::class);

    Route::post('/municipalities', [MunicipalityController::class, 'store'])
        ->middleware(EnsureMangerRole::class);

    Route::put('/municipalities/{id}', [MunicipalityController::class, 'update'])
        ->middleware(EnsureMangerRole::class);

    Route::post('/api/new-deceased', [DeceasedController::class, 'store'])
        ->middleware(EnsureMangerRole::class);
});