@extends('layouts.app')
@props(['current' => null])

@section('content')
   <div class="flex max-md:flex-col items-start grow">
        <div class="w-full md:w-[220px] pb-4">
            <flux:navlist>
                <flux:navlist.item :href="route('dashboard')" :current="!$current">{{ __('dashboard') }}</flux:navlist.item>
                <flux:navlist.item :href="route('projects.index')" :current="$current == 'projects'">{{ __('projects') }}</flux:navlist.item>
            </flux:navlist>
        </div>
        <flux:separator vertical  class="max-md:hidden" />
        <flux:separator class="hidden max-md:block" />
        <div class="flex-1 max-md:pt-6 self-stretch">
            @yield('main-content')
        </div>
    </div>
@endsection