@extends('layouts.auth')

@section('form')
    <div class="flex flex-col gap-3 p-4 lg:w-1/3">
        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-3" enctype="multipart/form-data">
            @csrf

            <label for="name">{{ __('name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="border border-gray-300 rounded-md p-2" required>

            <label for="email">{{ __('email') }}</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="border border-gray-300 rounded-md p-2" required>

            <label for="password">{{ __('password') }}</label>
            <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2" required>

            <label for="password_confirmation">{{ __('confirm-password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="border border-gray-300 rounded-md p-2" required>

            <label for="role">{{ __('role') }}</label>
            <select name="role" class="border border-gray-300 rounded-md p-2" required>
                <option value="client" class="text-black" @selected(old('role') == 'client')>{{ __('client') }}</option>
                <option value="freelancer" class="text-black" @selected(old('role') == 'freelancer' || !old('role'))>{{ __('freelancer') }}</option>
            </select>
            <label for="avatar">{{ __('avatar') }}</label>
            <input type="file" name="avatar" id="avatar" class="border border-gray-300 rounded-md p-2">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <flux:text>{{ $error }}</flux:text>
                @endforeach
            @endif
            <button type="submit" class="bg-sky-500 text-white rounded-md p-2 cursor-pointer">{{ __('register-button') }}</button>
        </form>

        <flux:text color="blue">{{ __('already-have-account') }} <a href="{{ route('login') }}"
                class="text-blue-500 underline">{{ __('login-button') }}</a></flux:text>
    </div>
@endsection
