<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Middleware\CheckSessionExpiry;
use App\Http\Controllers\BlogController;


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::middleware([CheckSessionExpiry::class])->group(function () {
    
    Route::get('/csrf-token', function () {
        return response()->json(['csrfToken' => csrf_token()]);
    });
    
    Route::get('/verify/{id}/{token}', [VerificationController::class, 'verify'])
        ->name('verification.verify');
    
    Route::get('/verify-thankyou', function () {
        return view('auth.verify-thankyou');
    })->name('verify-thankyou');
    
    Route::post('/resend-verification/{id}', [VerificationController::class, 'resendVerificationEmail']);
    
    Route::get('/verify-expired', function () {
        return view('auth.verify-expired');
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
    
    Route::get('/password-reset-expired', function () {
        return view('auth.password-reset-expired');
    })->name('password.reset.expired');


});

Route::get('/test-session', function () {
    return response()->json(['message' => 'Session is valid']);
})->middleware(CheckSessionExpiry::class);

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);

require __DIR__.'/auth.php';