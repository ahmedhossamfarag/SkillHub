@extends('dashboard.admin', ['current' => 'categories'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">{{ __('category') }} {{ __('edit') }}</h1>
    <div class="my-3 mx-10">
        <form action="{{ $category->id ? route('categories.update', $category) : route('categories.store') }}" method="POST" class="space-y-4">
            @csrf

            @if ($category->id)
                @method('PUT')
            @endif

            <flux:field>
                <flux:label>{{ __('name') }}</flux:label>
                <flux:input name="name" value="{{ $category->id ? $category->name : old('name') }}" placeholder="{{ __('name') }}" required />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('description') }}</flux:label>
                <flux:textarea name="description" placeholder="{{ __('description') }}" required >{{ $category->id ? $category->description : old('description') }}</flux:textarea>
                <flux:error name="description" />
            </flux:field>

            <flux:button type="submit" variant="primary" class="w-full">{{ __('save') }}</flux:button>

        </form>
    </div>
@endsection
