<?php

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\LoginForm;
use App\Livewire\Forms\RegisterForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $login;

    public RegisterForm $register;

    public string $mode = 'register';

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirectRoute('dashboard');
        }
    }

    public function submit(): void
    {
        if ($this->mode === 'login') {
            $this->login();

            return;
        }

        $this->register();
    }

    public function login(): void
    {
        $this->login->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt([
            'email' => Str::lower($this->login->email),
            'password' => $this->login->password,
        ], $this->login->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login.email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        $this->regenerateSession();

        $this->redirectRoute('dashboard');
    }

    public function register(): void
    {
        $this->register->validate();

        $user = User::create([
            'name' => $this->register->username,
            'email' => Str::lower($this->register->email),
            'password' => Hash::make($this->register->password),
        ]);

        Auth::login($user);

        $this->regenerateSession();

        $this->redirectRoute('dashboard');
    }

    private function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->login->email).'|'.request()->ip());
    }

    private function regenerateSession(): void
    {
        if (request()->hasSession()) {
            request()->session()->regenerate();
        }
    }

    public function render(): View
    {
        return view('livewire.pages.auth.login')
            ->extends('layouts.app')
            ->section('content');
    }
}
