@extends('dashboard.freelancer', ['current' => 'proposals'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('proposals') }}</h1>
    <flux:separator />
    <div class="space-y-10 p-10">
        @foreach ($proposals as $proposal)
            <div class="bg-[#1d1d20] space-y-2 rounded-md p-3 relative">
                <a href="{{ route('projects.show', $proposal->project->id) }}">
                    <flux:heading size="xl">{{ $proposal->project->title }}</flux:heading>
                </a>
                <flux:text>{{ $proposal->project->description }}</flux:text>
                <flux:text color="cyan">{{ $proposal->project->created_at->format('d/m/Y') }}</flux:text>
                <div class="flex gap-3">
                    <flux:badge>${{ $proposal->paid_amount }}</flux:badge>
                    <flux:badge>{{ $proposal->estimated_time }}</flux:badge>
                </div>
                <flux:text class="text-right" size="lg" color='blue'>{{ $proposal->status }}</flux:text>
            </div>
        @endforeach
    </div>
@endsection
