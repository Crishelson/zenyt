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
    <main class="flex flex-row h-screen p-4">
        <div class="flex flex-col flex-1 hidden md:flex justify-center gap-4 pl-12 pr-8">
            <h3 class="text-xl tracking-widest">ZENYT</h3>
            <div class="flex flex-col gap-2 max-w-3xl">
                <h1 class="text-7xl">Alcance o seu ápice</h1>
                <h2 class="text-xl">Todo dia estudado é mais um passo em direção à melhor versão de si mesmo. Sem distrações, sem ruído — só evolução.</h2>
            </div>
            <div class="flex flex-row tracking-widest gap-4 justify-start">
                <p>FOCO</p>
                <p>HÁBITO</p>
                <p>SUPERAÇÃO</p>
            </div>
        </div>
        <div class="flex flex-col flex-1 justify-center items-center gap-4">
            <div class="flex flex-col gap-2 max-w-sm">
                <h3 class="text-sm tracking-widest">> Bem-Vindo</h3>
                <h1 class="text-4xl font-bold">Continue sua jornada</h1>
                <h2 class="text-sm">Sem cadastro complicado — coloque suas informações básicas e comece.</h2>
            </div>
            <form action="#" method="POST" class="flex form-control flex-col gap-4">
                @csrf
                <div class="flex flex-col gap-2">
                    <label for="username" class="label-text text-sm tracking-widest">Como podemos te chamar</label>
                    <input type="text" name="username" placeholder="Nome de Usuário" class="input input-bordered w-full" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="email" class="label-text text-sm tracking-widest">Email</label>
                    <input type="email" name="email" placeholder="Email" class="input input-bordered w-full" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password" class="label-text text-sm tracking-widest">Senha</label>
                    <input type="password" name="password" placeholder="Senha" class="input input-bordered w-full" required>
                </div>
                <label class="label-text text-sm">
                    <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-md md:checkbox-sm rounded-full mr-2" required>Concordo com os termos de uso e política de privacidade
                </label>
                <button type="submit" class="btn btn-primary">Entrar</button>
            </form>
        </div>
    </main>
    @livewireScripts()
</body>
</html>
