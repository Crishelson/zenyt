<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class RegisterForm extends Form
{
    #[Validate('required|string|min:3|max:30|unique:users,name')]
    public string $username = '';

    #[Validate('required|string|email|max:255|unique:users,email')]
    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    #[Validate('accepted')]
    public bool $terms = false;

    public function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }
}
