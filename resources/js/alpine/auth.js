export default () => ({
    mode: 'register',

    pages: {
        register: {
            welcome: '> Bem-Vindo',
            title: 'Comece sua jornada',
            subtitle:
                'Sem cadastro complicado — coloque suas informações básicas e inicie sua jornada.',
            button: 'Registrar',
            action: '<button wire:click="register" class="btn btn-primary" x-text="text.button"></button>',
        },

        login: {
            welcome: '> Bem-Vindo de Volta',
            title: 'O próximo nível começa agora',
            subtitle:
                'Sua evolução não parou — ela apenas aguardava o seu próximo passo.',
            button: 'Entrar',
            action: '<button wire:click="login" class="btn btn-primary" x-text="text.button"></button>',
        },
    },

    text: {},

    init() {
        this.text = { ...this.pages.register };
    },

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    },

    async type(key, value) {
        // Apaga
        while (this.text[key].length > 0) {
            this.text[key] = this.text[key].slice(0, -1);
            await this.sleep(6);
        }

        await this.sleep(80);

        // Escreve
        for (let i = 1; i <= value.length; i++) {
            this.text[key] = value.slice(0, i);
            await this.sleep(8);
        }
    },

    async setMode(mode) {

        if (this.mode === mode) return;

        this.mode = mode;

        const page = this.pages[mode];

        await Promise.all([
            this.type('welcome', page.welcome),
            this.type('title', page.title),
            this.type('subtitle', page.subtitle),
            this.type('button', page.button),
            this.type('action', page.action),
        ]);
    },
});
