<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zenyt</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()

</head>
<body>
    <div
        x-data="{ mobile: window.innerWidth < 768 }"
        x-init=" window.addEventListener('resize', () => {mobile = window.innerWidth < 768})"
        class="relative min-h-screen w-full overflow-hidden"
    >
        <img
            :src="mobile ? '{{ asset('MobileBg.png') }}' : '{{ asset('DesktopBg.png') }}'"
            class="absolute inset-0 w-full h-full object-cover"
        >
        <div class="absolute inset-0 z-10 bg-black/35"></div>
        <main class="flex relative z-10 flex-row h-screen p-4 gap-4 text-gray-300">
            <div class="flex flex-col flex-1 hidden md:flex justify-center gap-4 pl-22 pr-8">
                <h3 class="text-xl tracking-widest pb-16">ZENYT</h3>
                <div class="flex flex-col gap-2 max-w-3xl">
                    <h1 class="text-8xl pt-4">Alcance o seu <span class="text-blue-600">ápice</span></h1>
                    <h2 class="text-xl pt-8">Todo dia estudado é mais um passo em direção à melhor versão de si mesmo. Sem distrações, sem ruído — só evolução.</h2>
                </div>
                <div class="flex flex-row tracking-widest gap-24 justify-start pt-18">
                    <p>FOCO</p>
                    <p>HÁBITO</p>
                    <p>SUPERAÇÃO</p>
                </div>
            </div>
            <div class="flex flex-col flex-1 justify-center items-center gap-4 md:pr-22">
                <div class="flex flex-col gap-2 max-w-md">
                    <h3 class="text-sm tracking-widest text-blue-600">> Bem-Vindo</h3>
                    <h1 class="text-4xl font-bold">Continue sua jornada</h1>
                    <h2 class="text-sm">Sem cadastro complicado — coloque suas informações básicas e comece.</h2>
                </div>
                <form action="#" method="POST" class="flex form-control max-w-md w-full flex-col gap-4">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="username" class="label-text text-sm tracking-widest">Como podemos te chamar</label>
                        <input type="text" name="username" placeholder="Nome de Usuário" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="email" class="label-text text-sm tracking-widest">Email</label>
                        <input type="email" name="email" placeholder="Email" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password" class="label-text text-sm tracking-widest">Senha</label>
                        <input type="password" name="password" placeholder="Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" required>
                    </div>
                    <label class="label-text text-sm">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-md md:checkbox-sm rounded-full mr-2" required>Concordo com os termos de uso e política de privacidade
                    </label>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </main>
    </div>
    @livewireScripts()
</body>
</html>
