@extends('layouts.app')

@section('content')
    <h1 class="block text-center text-2xl font-sans italic">{{ __('admin').' '.__('dashboard') }}</h1>
    <div class="flex flex-col justify-items-stretch gap-3 p-1">
        <div class="flex flex-col justify-items-stretch gap-2">
            <a href="{{ route('categories.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('categories') }}</a>
            <div class="flex flex-row gap-1 justify-center items-start flex-wrap min-h-52">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->id) }}" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="flex flex-col justify-items-stretch gap-2">
            <a href="{{ route('tags.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('tags') }}</a>
            <div class="flex flex-row gap-1 justify-center items-start flex-wrap min-h-52">
                @foreach($tags as $tag)
                    <a href="{{ route('tags.show', $tag->id) }}" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection