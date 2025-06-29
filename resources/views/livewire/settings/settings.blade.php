 <div class="space-y-5 p-10">
     <div class="relative">
         @if ($user->avatar)
             <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="w-40 h-40 rounded-full mx-auto">
         @else
             <img src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="avatar"
                 class="w-40 h-40 rounded-full mx-auto">
         @endif
         @if (!$editAvatar)
             <div class="absolute bottom-0 right-0">
                 <button wire:click="toggleEditAvatar"
                     class="text-blue-500 underline text-xl cursor-pointer">{{ __('edit') }}</button>
             </div>
         @endif
         @if ($editAvatar)
             <div class="space-y-3">
                 <livewire:settings.edit-avatar @avatar-updated="toggleEditAvatar" />
                 <flux:button wire:click="toggleEditAvatar" class="w-full cursor-pointer">{{ __('cancel') }}
                 </flux:button>
             </div>
         @endif
     </div>
     <flux:separator />
     <div class="space-y-3">
         <flux:heading size="lg">{{ __('name') }}</flux:heading>
         <div class="flex gap-3 justify-between">
             <flux:text>{{ $user->name }}</flux:text>
             @if (!$editName)
                 <button wire:click="toggleEditName"
                     class="text-blue-500 underline text-xl cursor-pointer">{{ __('edit') }}</button>
             @endif
         </div>
         @if ($editName)
             <div class="space-y-3">
                 <livewire:settings.edit-name @name-updated="toggleEditName" />
                 <flux:button wire:click="toggleEditName" class="w-full cursor-pointer">{{ __('cancel') }}
                 </flux:button>
             </div>
         @endif
     </div>
     <flux:separator />
     <div class="space-y-3">
         <flux:heading size="lg">{{ __('email') }}</flux:heading>
         <div class="flex justify-between">
             <flux:text>{{ $user->email }}</flux:text>
             @if (!$user->hasVerifiedEmail())
                 <a href="{{ route('verification.send') }}">
                     <flux:text class="text-blue-500 underline text-xl cursor-pointer">{{ __('verify') }}</flux:text>
                 </a>
             @endif
         </div>
         @isset ($email_verification_success)
             <flux:text color="green">{{ $email_verification_success }}, {{ __('wait-5-min') }}</flux:text>
         @endisset
     </div>
     <flux:separator />
     <div class="space-y-3">
         <flux:heading size="lg">{{ __('stripe-account') }}</flux:heading>
         <div class="flex justify-between">
             <flux:text>{{ $user->stripe_account_id ?? __('not-connected') }}</flux:text>
             <a href="{{ route('create-account') }}">
                 <flux:text class="text-blue-500 underline text-xl cursor-pointer">{{ $user->stripe_account_id ? __('visit') : __('connect') }}</flux:text>
             </a>
         </div>
     </div>
     <flux:separator />
     <div class="space-y-3">
         <flux:button wire:click="toggleResetPassword" variant="primary" class="cursor-pointer">
             {{ __('reset-password') }}
         </flux:button>
         @if ($resetPassword)
             <div>
                 <livewire:settings.reset-password />
             </div>
         @endif
     </div>
 </div>
