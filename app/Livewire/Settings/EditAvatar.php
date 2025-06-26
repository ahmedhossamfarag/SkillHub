<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class EditAvatar extends Component
{
    use WithFileUploads;

    #[Validate('required|image|mimes:jpeg,png,jpg,gif,svg|max:2048')]
    public $avatar;

    function updateAvatar() {
        $this->validate();

        $path = $this->avatar->storePublicly('avatars', 'public');
        auth()->user()->update(['avatar' => $path]);

        $this->dispatch('avatar-updated');
    }

    public function render()
    {
        return view('livewire.settings.edit-avatar');
    }
}
