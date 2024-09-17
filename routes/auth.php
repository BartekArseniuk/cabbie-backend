<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckSessionExpiry::class])->group(function () {
    
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');
    
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login');
    
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('emails.reset_password');
    
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('logout');
    
    Route::post('/submit-survey', [SurveyController::class, 'submitSurvey'])
        ->middleware('auth:sanctum')
        ->name('submit-survey');
    
    Route::get('/first-login-status', [AuthenticatedSessionController::class, 'getFirstLoginStatus'])
    ->middleware('auth:sanctum')
    ->name('first-login-status');
    
    Route::middleware('auth:sanctum')->get('/user-status', function (Request $request) {
        return response()->json([
            'authenticated' => true,
            'user' => $request->user()
        ]);
    });
    
    Route::get('/user-status', function () {
        return response()->json([
            'authenticated' => false
        ]);
    });
    
    Route::get('/api/check-session', function () {
        return response()->json(['logged_in' => auth()->check()]);
    });
});