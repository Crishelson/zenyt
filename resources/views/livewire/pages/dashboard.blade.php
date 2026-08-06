<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="min-h-dvh bg-slate-950 p-6 text-white">
    <form method="POST" action="{{ route('logout') }}" class="flex justify-end">
        @csrf

        <button type="submit" class="btn btn-primary">
            Sair
        </button>
    </form>
</div>
