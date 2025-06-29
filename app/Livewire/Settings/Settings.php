<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\On;
use Livewire\Component;

class Settings extends Component
{
    public $editName = false;
    public $editAvatar = false;
    public $resetPassword = false;

    protected $listner = [
        'toggleEditName',
        'toggleEditAvatar',
        'toggleResetPassword'
    ];

    // #[On('name-updated')]
    public function toggleEditName(){
        $this->editName = !$this->editName;
    }

    public function toggleEditAvatar(){
        $this->editAvatar = !$this->editAvatar;
    }

    public function toggleResetPassword(){
        $this->resetPassword = !$this->resetPassword;
    }

    public function render()
    {
        return view('livewire.settings.settings')->with('user', auth()->user())->with('email_verification_success', session()->get('email_verification_success'));
    }
}
