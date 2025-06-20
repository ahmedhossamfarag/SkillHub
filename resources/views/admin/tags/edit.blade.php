@extends('dashboard.admin', ['current' => 'tags'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('tag') }} {{ __('edit') }}</h1>
    <div class="my-3 mx-10">
        <form action="{{ $tag->id ? route('tags.update', $tag) : route('tags.store') }}" method="POST" class="space-y-4">
            @csrf

            @if ($tag->id)
                @method('PUT')
            @endif

            <flux:field>
                <flux:label>{{ __('name') }}</flux:label>
                <flux:input name="name" value="{{ $tag->id ? $tag->name : old('name') }}" placeholder="{{ __('name') }}" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('description') }}</flux:label>
                <flux:textarea name="description" placeholder="{{ __('description') }}" required >{{ $tag->id ? $tag->description : old('description') }}</flux:textarea>
                <flux:error name="description" />
            </flux:field>

            <flux:button type="submit" variant="primary" class="w-full">{{ __('save') }}</flux:button>

        </form>
    </div>
@endsection
