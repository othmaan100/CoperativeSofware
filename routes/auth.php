<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Auth\ForceChangePassword;
use App\Livewire\Members\CompleteProfile;
use App\Livewire\Members\RegisterApplication;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Route::get('register', RegisterApplication::class)
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('password/force-change', ForceChangePassword::class)
        ->name('password.force-change');

    Route::get('profile/complete', CompleteProfile::class)
        ->name('profile.complete');

    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
