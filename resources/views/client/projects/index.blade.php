@extends('dashboard.client', ['current' => 'projects'])

@section('main-content')
<h1 class="text-4xl font-sans text-center">{{ __('projects') }}</h1>
@can('create', App\Models\Project::class)
    <a href="{{ route('projects.create') }}" class="text-blue-500 underline text-xl px-2">{{ __('create-project') }}</a>
@endcan
<flux:separator />
<div class="flex gap-10 p-10 flex-wrap">
    @foreach ($projects as $project)
        <div class="bg-[#1d1d20] text-center w-[200px] h-[250px] space-y-2 rounded-md p-3">
            <a href="{{ route('projects.show', $project) }}">
                <flux:heading size="xl"  class="h-1/5 truncate">{{ $project->title }}</flux:heading>
            </a>
            <div class="h-4/5 space-y-2">
                <flux:text class="h-10/12 overflow-hidden">{{ $project->description }}</flux:text>
                @if ($project->category)
                    <a href="{{ route('categories.show', $project->category) }}">
                        <flux:badge>{{ $project->category->name }}</flux:badge>
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection