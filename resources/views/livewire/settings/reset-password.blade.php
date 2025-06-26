<form wire:submit="updatePassword" class="space-y-2">
    <flux:input type="password" wire:model="current_password" placeholder="{{ __('current-password') }}"/>
    <flux:error name="current_password" />
    <flux:input type="password" wire:model="password" placeholder="{{ __('new-password') }}" />
    <flux:error name="password" />
    <flux:input type="password" wire:model="password_confirmation" placeholder="{{ __('confirm-new-password') }}" />
    <flux:error name="password_confirmation" />
    <flux:button type="submit" class="w-full cursor-pointer">{{ __('save') }}</flux:button>
</form>
