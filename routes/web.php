<?php

use App\Livewire\Pages\Auth\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Login::class)
    ->middleware('guest')
    ->name('login-page');

Route::livewire('/dashboard', 'pages.dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login-page');
})->middleware('auth')->name('logout');
