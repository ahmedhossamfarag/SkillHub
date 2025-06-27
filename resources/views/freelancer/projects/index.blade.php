@extends('dashboard.freelancer', ['current' => 'projects'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('projects') }}</h1>
    <flux:separator />
    <div class="space-y-10 p-10">
        @foreach ($projects as $project)
            <div class="bg-[#1d1d20] space-y-2 rounded-md p-3 relative">
                <a href="{{ route('projects.show', $project->id) }}">
                    <flux:heading size="xl">{{ $project->title }}</flux:heading>
                </a>
                <flux:text>{{ $project->description }}</flux:text>
                @if ($project->category_name)
                    <div class="absolute right-3 top-3">
                        <flux:badge>{{ $project->category_name }}</flux:badge>
                    </div>
                @endif

                <div x-data="{ open: false }">
                    <div class="flex flex-row-reverse">
                        <flux:button size="xs" icon="chevron-down" x-on:click="open = ! open" />
                    </div>
                    <div x-show="open">
                        @if ($project->review_id)
                            <div class="flex flex-col gap-3">
                                <x-rating :rating="$project->review_rating" :editable="false" />
                                <flux:text class="px-20">{{ $project->review_comment }}</flux:text>
                                <form action="{{ route('freelancer.projects.reviews.destroy', [$project->review_id]) }}"
                                    method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" size="xs" variant="primary" color="red"
                                        class="w-full">
                                        {{ __('delete') }} {{ __('review') }}
                                    </flux:button>
                                </form>
                            </div>
                        @else
                            <form class="flex flex-col gap-3" action="{{ route('freelancer.projects.reviews.store') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $project->id }}" />
                                <input type="hidden" name="client_id" value="{{ $project->client_id }}" />
                                <x-rating :rating="0" :editable="true" />
                                <flux:textarea name="comment" placeholder="{{ __('comment') }}" />
                                @if ($errors->any())
                                    <div class="text-red-500 text-xs">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <flux:button type="submit" variant="primary" color="green" size="xs">
                                    {{ __('rate') }}
                                </flux:button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
