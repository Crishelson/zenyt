<div
    x-data="{ mobile: window.innerWidth < 768, register: true }"
    x-init="window.addEventListener('resize', () => { mobile = window.innerWidth < 768 })"
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
            <div x-data="auth()" class="flex flex-col gap-2 w-full max-w-md">
                <div class="flex justify-center">
                    <div class="relative flex w-full max-w-sm p-1 rounded-xl bg-[#07192f]/90 border border-blue-700/30">
                        <div
                            class="absolute top-1 bottom-1 rounded-lg bg-blue-600 transition-all duration-300"
                            :class="mode === 'login' ? 'translate-x-full' : 'translate-x-0'">
                        </div>
                        <button
                            type="button"
                            @click="setMode('register'); $wire.$set('mode', 'register', false)"
                            class="relative z-10 flex-1 py-2 font-semibold transition-colors duration-300"
                            :class="mode === 'register' ? 'text-white bg-blue-600 rounded-lg' : 'text-gray-400'">
                            Cadastro
                        </button>
                        <button
                            type="button"
                            @click="setMode('login'); $wire.$set('mode', 'login', false)"
                            class="relative z-10 flex-1 py-2 font-semibold transition-colors duration-300"
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
                    <form
                        x-ref="authForm"
                        method="post"
                        action="{{ route('login-page') }}"
                        @submit.prevent="if ($refs.authForm.reportValidity()) { $wire.submit() }"
                        class="flex form-control max-w-md w-full flex-col gap-4"
                    >
                        @csrf
                        <div x-show="mode === 'register'" class="flex flex-col gap-2">
                            <div class="flex flex-col gap-2">
                                <label for="username" class="label-text text-sm tracking-widest">Como podemos te chamar</label>
                                <input id="username" wire:model="register.username" type="text" name="username" placeholder="Nome de Usuário" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" :disabled="mode !== 'register'" required autocomplete="name">
                                @error('register.username')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="register-email" class="label-text text-sm tracking-widest">Email</label>
                                <input id="register-email" wire:model="register.email" type="email" name="email" placeholder="Email" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" :disabled="mode !== 'register'" required autocomplete="email">
                                @error('register.email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="register-password" class="label-text text-sm tracking-widest">Senha</label>
                                <input id="register-password" wire:model="register.password" type="password" name="password" placeholder="Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" :disabled="mode !== 'register'" required autocomplete="new-password">
                                @error('register.password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="password-confirmation" class="label-text text-sm tracking-widest">Confirmar Senha</label>
                                <input id="password-confirmation" wire:model="register.password_confirmation" type="password" name="password_confirmation" placeholder="Confirmar Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" :disabled="mode !== 'register'" required autocomplete="new-password">
                                @error('register.password_confirmation')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="label-text text-sm flex flex-row pt-2">
                                <input wire:model="register.terms" type="checkbox" name="terms" class="checkbox checkbox-primary checkbox-md md:checkbox-sm rounded-full mr-2" :disabled="mode !== 'register'" required>
                                <p>Concordo com os <a href="#" class="link text-blue-600">termos de uso</a> e <a href="#" class="link text-blue-600">política de privacidade</a></p>
                            </label>
                            @error('register.terms')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div x-show="mode === 'login'" class="flex flex-col gap-2">
                            <div class="flex flex-col gap-2">
                                <label for="login-email" class="label-text text-sm tracking-widest">Email</label>
                                <input id="login-email" wire:model="login.email" type="email" name="email" placeholder="Email" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" :disabled="mode !== 'login'" required autocomplete="email">
                                @error('login.email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="login-password" class="label-text text-sm tracking-widest">Senha</label>
                                <input id="login-password" wire:model="login.password" type="password" name="password" placeholder="Senha" class="py-2 pl-4 border-b-1 border-blue-600/80 w-full focus:outline-none" :disabled="mode !== 'login'" required autocomplete="current-password">
                                @error('login.password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <label class="label-text text-sm flex flex-row pt-2">
                                <input wire:model="login.remember" type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-md md:checkbox-sm rounded-full mr-2" :disabled="mode !== 'login'">
                                <p>Lembrar de mim</p>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary" x-text="text.button"></button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
