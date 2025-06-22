<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
</head>

<body>
    <div id="app" class="min-h-screen bg-white dark:bg-zinc-800 flex flex-col">
        <flux:header class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
            <flux:navbar class="-mb-px">
                <flux:navbar.item icon="home" :href="route('home')" :current="Route::is('home')">
                    {{ __('home') }}</flux:navbar.item>
                <flux:navbar.item icon="magnifying-glass" :href="route('explore')" :current="Route::is('explore')">{{ __('explore') }}</flux:navbar.item>
            </flux:navbar>
            <flux:spacer />

            @unless (Route::is('login') || Route::is('register'))
                @guest
                    <flux:navbar>
                        <flux:navbar.item icon="arrow-right-start-on-rectangle" :href="route('login')">{{ __('login') }}
                        </flux:navbar.item>
                        <flux:navbar.item icon="arrow-right-start-on-rectangle" :href="route('register')">{{ __('register') }}
                        </flux:navbar.item>
                    </flux:navbar>
                @else
                    <flux:dropdown position="top" align="start">
                        <flux:button icon="user" class="rounded-full!" />
                        <flux:menu>
                            <a href="{{ route('dashboard') }}">
                                <flux:menu.item icon="arrow-right-start-on-rectangle">{{ __('dashboard') }}</flux:menu.item>
                            </a>
                            <a href="{{ route('profile.show') }}">
                                <flux:menu.item icon="arrow-right-start-on-rectangle">{{ __('profile') }}</flux:menu.item>
                            </a>
                            <flux:menu.separator />
                            <a href="{{ route('logout') }}">
                                <flux:menu.item icon="arrow-right-start-on-rectangle">{{ __('logout') }}</flux:menu.item>
                            </a>
                        </flux:menu>
                    </flux:dropdown>
                @endguest
            @endunless
        </flux:header>

        @yield('content')
    </div>
    @livewireScriptConfig
    @fluxScripts
</body>

</html>
