@extends('layouts.app')
@props(['current' => null, 'project' => null])

@section('content')
   <div class="flex max-md:flex-col items-start grow">
        <div class="w-full md:w-[220px] pb-4">
            <flux:navlist>
                <flux:navlist.item :href="route('projects.show', $project)" :current="!$current">{{ __('details') }}</flux:navlist.item>
                <flux:navlist.item :href="route('client.projects.proposals.index', $project)" :current="$current == 'proposals'">{{ __('proposals') }}</flux:navlist.item>
                <flux:navlist.item :href="route('client.projects.freelancers.index', $project)" :current="$current == 'freelancers'">{{ __('freelancers') }}</flux:navlist.item>
                <flux:navlist.item :href="route('client.projects.uploads.index', $project)" :current="$current == 'uploads'">{{ __('uploads') }}</flux:navlist.item>
                <flux:navlist.item :href="route('client.projects.messages.index', $project)" :current="$current == 'comments'">{{ __('chat') }}</flux:navlist.item>
                @can('viewAny', [App\Models\Payment::class, $project])
                    <flux:navlist.item :href="route('client.projects.payments.index', $project)" :current="$current == 'payments'">{{ __('payments') }}</flux:navlist.item>
                @endcan
            </flux:navlist>
        </div>
        <flux:separator vertical  class="max-md:hidden" />
        <flux:separator class="hidden max-md:block" />
        <div class="flex-1 max-md:pt-6 self-stretch">
            @yield('main-content')
        </div>
    </div>
@endsection