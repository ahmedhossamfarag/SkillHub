@extends('dashboard.admin', ['current' => 'categories'])

@section('main-content')
    <h1 class="text-6xl font-sans text-center">{{ __('categories') }}</h1>

    @can('create', App\Models\Category::class)
        <a href="{{ route('categories.create') }}" class="text-blue-500 underline text-xl px-2">{{ __('create-category') }}</a>
    @endcan

    <flux:separator />
    <div class="flex flex-wrap gap-2 justify-center mt-10">
        @foreach ($categories as $category)
            <a href="{{ route('categories.show', $category) }}">
                <flux:badge>{{ $category->name }}</flux:badge>
            </a>
        @endforeach        
    </div>
@endsection
