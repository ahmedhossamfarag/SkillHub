@extends('client.projects.layout')

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('project') }} {{ __('show') }}</h1>

    <div class="my-3 mx-10 space-y-5">
        <flux:heading size="lg">{{ __('title') }}</flux:heading>
        <flux:text class="px-20">{{ $project->title }}</flux:text>

        <flux:heading size="lg">{{ __('description') }}</flux:heading>
        <flux:text class="px-20">{{ $project->description }}</flux:text>

        <flux:heading size="lg">{{ __('budget') }}</flux:heading>
        <flux:text class="px-20">{{ $project->budget }}</flux:text>

        <flux:heading size="lg">{{ __('deadline') }}</flux:heading>
        <flux:text class="px-20">{{ $project->deadline }}</flux:text>

        <flux:heading size="lg">{{ __('category') }}</flux:heading>
        <flux:text class="px-20">{{ $project->category?->name }}</flux:text>


        @can('update', $project)
            <div class="flex gap-10">
                <a href="{{ route('projects.edit', $project) }}"
                    class="text-blue-500 underline text-xl">{{ __('edit') }}</a>
                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 underline text-xl cursor-pointer">{{ __('delete') }}</button>
                </form>
            </div>
        @endcan
    </div>
@endsection
