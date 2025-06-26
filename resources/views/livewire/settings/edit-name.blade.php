<form wire:submit="updateName" class="space-y-2">
    <flux:input wire:model="name" />
    <flux:error name="name" />
    <flux:button type="submit" class="w-full cursor-pointer">{{ __('save') }}</flux:button>
</form>
