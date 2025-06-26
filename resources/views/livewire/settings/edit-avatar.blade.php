<form wire:submit="updateAvatar" class="space-y-2">
    <flux:input type="file" wire:model="avatar" />
    <flux:error name="avatar" />
    <flux:button type="submit" class="w-full cursor-pointer">{{ __('save') }}</flux:button>
</form>
