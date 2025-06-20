@extends('dashboard.admin', ['current' => 'tags'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('tag') }} {{ __('show') }}</h1>

    <div class="my-3 mx-10">
        <div class="mb-30">
            <flux:heading size="lg">{{  __('name') }}</flux:heading>
            <flux:text class="px-20">{{ $tag->name }}</flux:text>

            <flux:heading size="lg">{{  __('description') }}</flux:heading>
            <flux:text class="px-20">{{ $tag->description }}</flux:text>
        </div>
        <div class="flex gap-10">
            <a href="{{ route('tags.edit', $tag) }}" class="text-blue-500 underline text-xl">{{ __('edit') }}</a>
            <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 underline text-xl cursor-pointer">{{ __('delete') }}</button>
            </form>
        </div>
    </div>
@endsection