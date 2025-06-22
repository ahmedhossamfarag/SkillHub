@extends('client.projects.layout', ['current' => 'proposals'])

@section('main-content')
    <div class="space-y-4 p-10">
        @foreach ($proposals as $proposal)
            <div class="bg-[#1d1d20] space-y-2 rounded-lg p-3">
                <div class="flex h-full gap-3 items-center">
                    <flux:icon.user-plus class="size-20" />
                    <div class="space-y-2 grow">
                        <a href="{{ route('profile.show', $proposal->freelancer) }}">
                            <flux:heading>{{ $proposal->freelancer->name }}</flux:heading>
                        </a>
                        <flux:text>{{ $proposal->freelancer->email }}</flux:text>
                        <div class="flex gap-3">
                            <flux:badge>${{ $proposal->paid_amount }}</flux:badge>
                            <flux:badge>{{ $proposal->estimated_time }}</flux:badge>
                        </div>
                        <div class="flex gap-2 flex-row-reverse w-full">
                            @can('update', $proposal)
                                @if ($proposal->status == 'pending')
                                    <form
                                        action="{{ route('client.projects.proposals.reject', [$proposal->project, $proposal]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <flux:button type="submit" variant="primary" color="red">{{ __('reject') }}
                                        </flux:button>
                                    </form>

                                    <form
                                        action="{{ route('client.projects.proposals.accept', [$proposal->project, $proposal]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        <flux:button type="submit" variant="primary" color="green">{{ __('accept') }}
                                        </flux:button>
                                    </form>
                                @else
                                    <flux:text>{{ $proposal->status }}</flux:text>
                                @endif
                            @else
                                <flux:text>{{ $proposal->status }}</flux:text>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
