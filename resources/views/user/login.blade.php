@extends('layouts.auth')

@section('form')
    <div class="flex flex-col gap-3 p-4 lg:w-1/3 ">
        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-3">
            @csrf

            <label for="email">{{ __('email') }}</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="border border-gray-300 rounded-md p-2" required>

            <label for="password">{{ __('password') }}</label>
            <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2" required>
            <div>
                @if($error)
                    <flux:text color="red">{{ $error }}</flux:text>
                @endif
            </div>
            <button type="submit" class="bg-blue-500 text-white rounded-md p-2 cursor-pointer">{{ __('login-button') }}</button>
        </form>

        <flux:text color="blue">{{ __('dont-have-account') }} <a href="{{ route('register') }}"
                class="text-blue-500 underline">{{ __('register-button') }}</a></flux:text>
    </div>
@endsection
