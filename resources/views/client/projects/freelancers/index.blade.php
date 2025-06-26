@extends('client.projects.layout', ['current' => 'freelancers'])

@section('main-content')
    <div class="space-y-4 p-10">
        @foreach ($freelancers as $freelancer)
            <div class="bg-[#1d1d20] space-y-2 rounded-lg p-3">
                <div class="flex gap-3 items-center">
                    @if($freelancer->avatar)
                        <flux:avatar circle :src="asset('storage/'.$freelancer->avatar)" class="size-20!" />
                    @else
                        <flux:icon.user-circle class="size-20" />
                    @endif
                    <div class="space-y-2 grow">
                        <a href="{{ route('profile.show', $freelancer->id) }}">
                            <flux:heading>{{ $freelancer->name }}</flux:heading>
                        </a>
                        <flux:text>{{ $freelancer->email }}</flux:text>
                    </div>
                </div>
                @if ($freelancer->review_id)
                    <div class="flex flex-col gap-3">
                        <x-rating :rating="$freelancer->review_rating" :editable="false" />
                        <flux:text class="px-20">{{ $freelancer->review_comment }}</flux:text>
                        <form action="{{ route('client.projects.reviews.destroy', [$project, $freelancer->review_id]) }}"
                            method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" size="xs" variant="primary" color="red" class="w-full">
                                {{ __('delete') }} {{ __('review') }}
                            </flux:button>
                        </form>
                    </div>
                @elseif (auth()->user()->isClient() && auth()->user()->id == $project->client_id)
                    <form class="flex flex-col gap-3" action="{{ route('client.projects.reviews.store', $project) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="freelancer_id" value="{{ $freelancer->id }}" />
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
                        <flux:button type="submit" variant="primary" color="green" size="xs">{{ __('rate') }}
                        </flux:button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
@endsection
