<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckSessionExpiry;
use App\Http\Controllers\PrivateMessageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GlobalMessageController;

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

    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::post('/blogs', [BlogController::class, 'store']);
        Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
        Route::put('/blogs/{id}', [BlogController::class, 'update']);
    });

    Route::middleware('auth:sanctum')->get('/messages', [PrivateMessageController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/messages/send', [PrivateMessageController::class, 'sendMessage']);

    Route::middleware('auth:sanctum')->get('/global-messages', [GlobalMessageController::class, 'index']);
    Route::middleware('auth:sanctum')->post('/global-messages/send', [GlobalMessageController::class, 'sendMessage']);

    Route::post('/global-messages/{id}/read', [GlobalMessageController::class, 'markAsRead']);
    Route::post('/private-messages/{id}/read', [PrivateMessageController::class, 'markAsRead']);
});