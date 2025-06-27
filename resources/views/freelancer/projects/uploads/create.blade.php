@extends('client.projects.layout', ['current' => 'uploads'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">Create Upload</h1>
    <flux:separator></flux:separator>
    <div class="p-10">
        <form action="{{ route('client.projects.uploads.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <flux:input name="name" type="text" label="{{ __('name') }}" placeholder="{{ __('name') }}" value="{{ old('name') }}" required></flux:input>
            <flux:textarea name="description" type="text" label="{{ __('description') }}" placeholder="{{ __('description') }}">{{ old('description') }}</flux:textarea>
            <flux:input name="file" type="file" label="{{ __('file') }}" placeholder="{{ __('file') }}" required></flux:input>
            <flux:button type="submit" variant="primary" class="w-full cursor-pointer">{{ __('save') }}</flux:button>
        </form>
    </div>
@endsection
