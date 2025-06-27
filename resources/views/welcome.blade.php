@extends('layouts.app')

@section('content')
    <flux:heading size="xl" class="text-center">Hello & Welcome</flux:heading>

    <div class="p-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 justify-items-center">
            @for ($i = 0; $i < $posts->count(); $i++)
                <div class="bg-[#1d1d20] max-w-[500px] h-fit space-y-2 @if ($i % 2 == 1) lg:translate-y-20 @endif">
                    <div>
                        {!! $posts[$i]->content !!}
                    </div>
                    @if ($posts[$i]->image)
                        <img src="{{ asset('storage/' . $posts[$i]->image) }}" alt="{{ __('image') }}"
                            class="mx-auto max-w-full">
                    @endif
                </div>
            @endfor
        </div>
    </div>
@endsection
