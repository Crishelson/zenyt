<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Livewire\Component;

new class extends Component
{
    public string $mode = 'login';

    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;
    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $key = Str::lower($this->email).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'email' => __('auth.throttle'),
            ]);
        }

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], $this->remember)) {

            RateLimiter::hit($key);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($key);

        request()->session()->regenerate();

        $this->redirect(route('dashboard'));
    }

    public function register()
    {
        $validated = $this->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],

            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        request()->session()->regenerate();

        $this->redirect(route('dashboard'));
    }
};
?>

@extends('layouts.app')
@section('content')
    <div
        x-data="{ mobile: window.innerWidth < 768, register: true }"
        x-init=" window.addEventListener('resize', () => {mobile = window.innerWidth < 768})"
        class="relative h-dvh w-full overflow-hidden"
    >
        <img
            :src="mobile ? '{{ asset('MobileBg.png') }}' : '{{ asset('DesktopBg.png') }}'"
            class="absolute inset-0 size-full h-full object-cover -z-10"
        >
        <div class="absolute inset-0 z-10 bg-black/45"></div>
        <main class="flex h-full relative z-10 flex-row p-4 gap-4 text-gray-300">
            <div class="flex flex-col flex-1 hidden md:flex justify-center gap-[28%] pl-22 pr-8">
                <h3 class="text-xl tracking-widest">ZENYT</h3>
                <div class="flex flex-col gap-4 max-w-3xl">
                    <h1 class="text-8xl font-display">Alcance o seu <span class="text-blue-600">ápice</span></h1>
                    <h2 class="text-xl">Todo dia estudado é mais um passo em direção à melhor versão de si mesmo. Sem distrações, sem ruído — só evolução.</h2>
                </div>
                <div class="flex flex-row tracking-widest gap-24 justify-start">
                    <p>FOCO</p>
                    <p>HÁBITO</p>
                    <p>SUPERAÇÃO</p>
                </div>
            </div>
            <div class="flex flex-1 justify-center items-center md:pr-22">
                <div x-data="auth()" class="flex flex-col gap-2 w-full max-w-md" >
                    <div class="flex justify-center">
                        <div class="relative flex w-full max-w-sm p-1 rounded-xl bg-[#07192f]/90 border border-blue-700/30">
                            <div
                                class="absolute top-1 bottom-1 rounded-lg bg-blue-600 transition-all duration-300"
                                :class="mode === 'login' ? 'translate-x-full' : 'translate-x-0'">
                            </div>
                            <button
                                @click="setMode('register')"
                                class="relative z-10 flex-1 py-2 font-semibold transition-colors duration-300"
                                :class="mode === 'register' ? 'text-white bg-blue-600 rounded-lg' : 'text-gray-400'">
                                Cadastro
                            </button>
                            <button
                                @click="setMode('login')"
                                class="relative z-10 flex-1 py-2 font-semibold transition-colors duration-300 "
                                :class="mode === 'login' ? 'text-white bg-blue-600 rounded-lg' : 'text-gray-400'">
                                Login
                            </button>
                        </div>
                    </div>
                    <div class="relative z-20 bg-gradient-to-b from-[#0a316f] via-[#08295e] to-[#07234f] p-6 rounded-lg">
                        <div class="flex flex-col gap-2 max-w-md pb-4">
                            <div class="flex flex-row gap-2 items-center">
                                <h3 class="text-sm tracking-widest text-blue-600" x-text="text.welcome"></h3>
                                <div class="w-px h-4 bg-blue-600 -m-[6px] animate-cursor"></div>
                            </div>
                            <h1 class="text-4xl font-bold" x-text="text.title"></h1>
                            <h2 class="text-sm" x-text="text.subtitle"></h2>
                        </div>
                        <form @submit.prevent="
                                    if (mode === 'login') {
                                        $wire.login();
                                    } else {
                                        $wire.register();
                                    }
                        "
                        class="flex form-control max-w-md w-full flex-col gap-4"
                        >
                            @csrf
                            <div x-show="mode === 'register'" class="flex flex-col gap-2">
                                <div class="flex flex-col gap-2">
                                    <label for="username" class="label-text text-sm tracking-widest">Como podemos te chamar</label>
                                    <input wire:model="username" type="text" name="username" placeholder="Nome de Usuário" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                                    @error('username')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="email" class="label-text text-sm tracking-widest">Email</label>
                                    <input wire:model="email" type="email" name="email" placeholder="Email" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="password" class="label-text text-sm tracking-widest">Senha</label>
                                    <input wire:model="password" type="password" name="password" placeholder="Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                                    @error('password')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label for="confirm_password" class="label-text text-sm tracking-widest">Confirmar Senha</label>
                                    <input wire:model="confirm_password" type="password" name="confirm_password" placeholder="Confirmar Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                                    @error('confirm_password')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                    <label class="label-text text-sm flex flex-row pt-2">
                                        <input wire:model="terms" type="checkbox" name="terms" class="checkbox checkbox-primary checkbox-md md:checkbox-sm rounded-full mr-2" required>
                                        <p>Concordo com os <a href="#" class="link text-blue-600">termos de uso</a> e <a href="#" class="link text-blue-600">política de privacidade</a></p>

                                    </label>
                            </div>
                            <div x-show="mode === 'login'" class="flex flex-col gap-2">
                                <div class="flex flex-col gap-2">
                                <label for="email" class="label-text text-sm tracking-widest">Email</label>
                                <input wire:model="email" type="email" name="email" placeholder="Email" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="password" class="label-text text-sm tracking-widest">Senha</label>
                                <input wire:model="password" type="password" name="password" placeholder="Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                            </div>
                                <label class="label-text text-sm flex flex-row pt-2">
                                    <input wire:model="remember" type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-md md:checkbox-sm rounded-full mr-2">
                                    <p>Lembrar de mim</p>
                                </label>
                            </div>
                            <button wire:click="text.action" class="btn btn-primary" x-text="text.button"></button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
