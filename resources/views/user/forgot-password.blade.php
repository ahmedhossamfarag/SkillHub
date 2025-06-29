@extends('layouts.auth')

@section('form')
    <div class="flex flex-col gap-3 p-4 lg:w-1/3 ">
        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-3">
            @csrf

            <label for="email">{{ __('email') }}</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="border border-gray-300 rounded-md p-2" required>

            @error('email')
                <flux:text color="red">{{ $message }}</flux:text>
            @enderror

            @if (session('status'))
                <flux:text color="green">{{ session('status') }}</flux:text>
            @endif

            <button type="submit"
                class="bg-blue-500 text-white rounded-md p-2 cursor-pointer">{{ __('reset-password') }}</button>
        </form>

        <flux:text color="blue">{{ __('dont-have-account') }} <a href="{{ route('register') }}"
                class="text-blue-500 underline">{{ __('register-button') }}</a></flux:text>
        <flux:text color="blue"><a href="{{ route('login') }}"
                class="text-blue-500 underline">{{ __('login-button') }}</a></flux:text>
    </div>
@endsection
