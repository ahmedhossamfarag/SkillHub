@extends('layouts.app')

@section('content')
    <div class="relative">
        @can('update', $profile)
            <a href="{{ route('profile.edit') }}" class="absolute top-10 right-10">
                <flux:button icon="pencil" class="rounded-full! size-12! cursor-pointer" />
            </a>
        @endcan

        <h1 class="text-6xl font-sans text-center">{{ __('profile') }}</h1>

        <div class="m-10 space-y-3">
            <flux:heading size="xl">{{ __('name') }}</flux:heading>
            <flux:text color="blue">{{ $user->name }}</flux:text>

            <flux:separator />

            <flux:heading size="xl">{{ __('email') }}</flux:heading>
            <flux:text color="blue">{{ __('email') }}: {{ $user->email }}</flux:text>

            <flux:separator />

            <flux:heading size="xl">{{ __('description') }}</flux:heading>
            <flux:text color="blue">{{ $profile->description }}</flux:text>

            <flux:separator />

            <flux:heading size="xl">{{ __('location') }}</flux:heading>
            <flux:text color="blue">{{ $profile->location }}</flux:text>

            <flux:separator />

            <flux:heading size="xl">{{ __('experience') }}</flux:heading>
            <flux:text color="blue">{{ $profile->experience }}</flux:text>

            <flux:separator />

            <flux:heading size="xl">{{ __('skills') }}</flux:heading>

            <div class="flex gap-3">
                @foreach ($profile->skills as $skill)
                    <flux:badge>{{ $skill->name }}</flux:badge>
                @endforeach
            </div>

            <flux:separator />

            <flux:heading size="xl">{{ __('tags') }}</flux:heading>

            <div class="flex gap-3">
                @foreach ($profile->tags as $tag)
                    <flux:badge>{{ $tag->name }}</flux:badge>
                @endforeach
            </div>

            <flux:separator />

            <flux:heading size="xl">{{ __('reviews') }}</flux:heading>

            @foreach ($reviews as $review)
                <div class="p-3 rounded-md bg-[#1d1d20] space-y-2">
                    <div class="flex gap-3 items-center">
                        <flux:icon.user-circle />
                        <flux:heading>{{ $user->isClient() ? $review->freelancer->name : $review->client->name }}
                        </flux:heading>
                    </div>
                    <div class="flex gap-1">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <flux:icon.star variant="solid" class="text-yellow-400" />
                        @endfor
                    </div>
                    <flux:text>{{ $review->comment }}</flux:text>
                </div>
            @endforeach

        </div>
    </div>
@endsection
