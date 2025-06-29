@extends('layouts.auth')

@section('form')
    <div class="flex flex-col gap-3 p-4 lg:w-1/3">
        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-3">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">{{ __('email') }}</label>
            <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}"
                class="border border-gray-300 rounded-md p-2" required>

            <label for="password">{{ __('password') }}</label>
            <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2" required>

            <label for="password_confirmation">{{ __('confirm-password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="border border-gray-300 rounded-md p-2" required>

            @error('email')
                <flux:text color="red">{{ $message }}</flux:text>
            @enderror

            <button type="submit"
                class="bg-blue-500 text-white rounded-md p-2 cursor-pointer">{{ __('reset-password') }}</button>

        </form>

        <flux:text color="blue"><a href="{{ route('login') }}"
                class="text-blue-500 underline">{{ __('login-button') }}</a></flux:text>
    </div>
@endsection
