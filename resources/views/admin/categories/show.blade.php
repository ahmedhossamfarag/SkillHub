@extends('dashboard.admin', ['current' => 'categories'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('category') }} {{ __('show') }}</h1>

    <div class="my-3 mx-10">
        <div class="mb-30">
            <flux:heading size="lg">{{  __('name') }}</flux:heading>
            <flux:text class="px-20">{{ $category->name }}</flux:text>

            <flux:heading size="lg">{{  __('description') }}</flux:heading>
            <flux:text class="px-20">{{ $category->description }}</flux:text>
        </div>
        <div class="flex gap-10">
            <a href="{{ route('categories.edit', $category) }}" class="text-blue-500 underline text-xl">{{ __('edit') }}</a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 underline text-xl cursor-pointer">{{ __('delete') }}</button>
            </form>
        </div>
    </div>
@endsection