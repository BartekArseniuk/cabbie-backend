<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;

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

require __DIR__.'/auth.php';