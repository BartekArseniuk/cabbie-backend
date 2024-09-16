<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordResetController;


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

Route::post('/resend-verification/{id}', [VerificationController::class, 'resendVerificationEmail']);

Route::get('/verify-expired', function () {
    return view('emails.verify-expired');
})->name('verify-expired');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);

Route::post('/reset-password', [NewPasswordController::class, 'reset'])
    ->name('password.update');

Route::get('/password-reset/{token}', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset.form');

Route::post('/password-reset', [PasswordResetController::class, 'reset'])
    ->name('password.reset');

Route::get('/password-reset-success', function () {
    return view('auth.password-reset-success');
})->name('password.reset.success');

require __DIR__.'/auth.php';