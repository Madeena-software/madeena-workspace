<?php

use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');
