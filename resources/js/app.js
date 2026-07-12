import Alpine from 'alpinejs';
import { createIcons } from 'lucide';

document.addEventListener('livewire:navigated', () => {
    createIcons();
});

document.addEventListener('DOMContentLoaded', () => {
    createIcons();
});

window.Alpine = Alpine;

Alpine.start();
