<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

Route::get('/verify/{id}/{token}', [VerificationController::class, 'verify'])
    ->name('verification.verify');

    Route::get('/verify-thankyou', function () {
        return view('emails.verify-thankyou');
    })->name('verify-thankyou');

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);

require __DIR__.'/auth.php';