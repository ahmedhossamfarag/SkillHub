<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Livewire\Attributes\Validate;

class EditName extends Component
{
    #[Validate('required|string|max:255|min:3')]
    public $name = '';

    public function updateName()
    {
        $this->validate();

        auth()->user()->update(['name' => $this->name]);

        $this->dispatch('name-updated');
    }

    public function render()
    {
        return view('livewire.settings.edit-name');
    }
}
