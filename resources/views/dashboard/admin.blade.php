@extends('layouts.app')
@props(['current' => null])

@section('content')
   <div class="flex max-md:flex-col items-start grow">
        <div class="w-full md:w-[220px] pb-4">
            <flux:navlist>
                @if (auth()->user()->isAdmin())
                    <flux:navlist.item :href="route('dashboard')" :current="!$current">{{ __('dashboard') }}</flux:navlist.item>
                @endif
                <flux:navlist.item :href="route('categories.index')" :current="$current == 'categories'">{{ __('categories')}}</flux:navlist.item>
                <flux:navlist.item :href="route('tags.index')" :current="$current == 'tags'">{{ __('tags')}}</flux:navlist.item>
                @if (auth()->user()->isAdmin())
                    <flux:navlist.item :href="route('admin.posts.index')" :current="$current == 'posts'">{{ __('posts') }}</flux:navlist.item>
                @endif
            </flux:navlist>
        </div>
        <flux:separator vertical  class="max-md:hidden" />
        <flux:separator class="hidden max-md:block" />
        <div class="flex-1 max-md:pt-6 self-stretch">
            @yield('main-content')
        </div>
    </div>
@endsection