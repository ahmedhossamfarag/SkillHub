@extends('dashboard.admin', ['current' => 'tags'])

@section('main-content')
    <h1 class="text-6xl font-sans text-center">{{ __('tags') }}</h1>

    @can('create', App\Models\Tag::class)
        <a href="{{ route('tags.create') }}" class="text-blue-500 underline text-xl px-2">{{ __('create-tag') }}</a>
    @endcan

    <flux:separator />
    <div class="flex flex-wrap gap-2 justify-center mt-10">
        @foreach ($tags as $tag)
            <a href="{{ route('tags.show', $tag) }}">
                <flux:badge>{{ $tag->name }}</flux:badge>
            </a>
        @endforeach        
    </div>
@endsection
