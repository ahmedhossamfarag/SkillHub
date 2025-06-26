<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rules;


class ResetPassword extends Component
{

    public $current_password;
    public $password;
    public $password_confirmation;

    public function rules(){
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function updatePassword(){
        $this->validate();

        auth()->user()->update(['password' => Hash::make($this->password)]);

        return redirect()->route('logout');
    }

    public function render()
    {
        return view('livewire.settings.reset-password');
    }
}
