<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="min-h-screen flex flex-col">
        <nav class="">
            <div class="flex flex-row justify-between">
                <a class="font-bold text-4xl" href="{{ url('/') }}">
                    {{ config('app.name', 'SkillHub') }}
                </a>
                @unless (Route::is('login') || Route::is('register'))
                    <div>
                        <ul class="flex flex-row gap-3">
                            @guest
                                @if (Route::has('login'))
                                    <li>
                                        <a href="{{ route('login') }}">{{ __('login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li>
                                        <a href="{{ route('register') }}">{{ __('register') }}</a>
                                    </li>
                                @endif
                            @else
                                @if (Route::has('logout'))
                                    <li>
                                        <a href="{{ route('logout') }}">{{ __('logout') }}</a>
                                    </li>
                                @endif
                            @endguest
                        </ul>
                    </div>
                @endunless    
            </div>
        </nav>
       

        <main class="py-4 grow flex flex-col">
            @yield('content')
        </main>
    </div>
</body>
</html>

