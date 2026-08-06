import Alpine from 'alpinejs';
import auth from './alpine/auth';
import { createIcons } from 'lucide';

document.addEventListener('livewire:navigated', () => {
    createIcons();
});

document.addEventListener('DOMContentLoaded', () => {
    createIcons();
});

window.Alpine = Alpine;

Alpine.data('auth', auth);

Alpine.start();
