@extends('dashboard.freelancer', ['current' => 'proposals'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('create') }} {{ __('proposal') }}</h1>
    <flux:separator />
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
    </div>
    <div class="my-3 mx-10 space-y-5 bg-[#1d1d20] p-3 rounded-2xl">
        <form action="{{ route('proposals.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}" />
            <flux:input type="number" min="0" name="paid_amount" label="{{ __('paid_amount') }}" placeholder="{{ __('paid_amount') }}" required />
            <flux:input type="text" name="estimated_time" label="{{ __('estimated_time') }}" placeholder="{{ __('estimated_time') }}" required />
            <flux:button type="submit" variant="primary" color="blue" class="w-full">{{ __('submit') }}</flux:button>
        </form>
    </div>
@endsection