@extends('layouts.app')
@props(['query', 'categoryId', 'projects', 'categories'])

@section('content')
    <div class="m-5 space-y-2">
        <form method="GET" id="search-form">
            <div class="grid grid-cols-2 gap-2">
                <div class="relative">
                    <flux:input name="query" placeholder="{{ __('search') }}" value="{{ $query ?? '' }}" />
                    <flux:icon.magnifying-glass class="absolute top-0 right-0 size-10 text-gray-600" />
                </div>
                <div class="grid grid-cols-2 items-center gap-2">
                    <flux:select name="category_id" value="{{ $categoryId ?? '' }}">
                        <option value="">{{ __('all') }} {{ __('categories') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:button type="submit" variant="primary" class="w-full">{{ __('search') }}</flux:button>
                </div>
            </div>
        </form>

        <flux:separator />

        <div class="flex flex-col gap-2">
            @foreach ($projects as $project)
                <div class="space-y-2 p-2 border border-gray-300 bg-[#383636] rounded-2xl">
                    <a href="{{ route('projects.show', $project) }}">
                        <flux:heading size="lg">{{ $project->title }}</flux:heading>
                    </a>
                    <div class="space-y-2">
                        <flux:text>{{ $project->description }}</flux:text>
                        <flux:badge color="blue">{{ $project->created_at->format('d/m/Y') }}</flux:badge>
                        <flux:badge class="{{ $project->deadline->lt(now()) ? 'bg-red-500!' : 'bg-green-500!' }}">
                            {{ $project->deadline->format('d/m/Y') }}</flux:badge>
                        <flux:badge>${{ $project->budget }}</flux:badge>
                        @if ($project->category)
                            <a href="{{ route('categories.show', $project->category) }}">
                                <flux:badge color="cyan">{{ $project->category->name }}</flux:badge>
                            </a>
                        @endif
                    </div>
                    @auth
                        @if (Auth::user()->isFreelancer())
                            @unless (in_array($project->id, $workProjects))
                                <div class="flex justify-end">
                                    <a href="{{ route('proposals.create') . "?project_id=$project->id" }}">
                                        <flux:button variant="primary" color="blue" class="cursor-pointer">{{ __('apply') }}
                                        </flux:button>
                                    </a>
                                </div>
                            @endunless
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.getElementById("search-form").addEventListener("keydown", function(e) {
            if (e.key === "Enter" && e.target.tagName.toLowerCase() === "input") {
                e.preventDefault();
            }
        });
    </script>
@endsection
