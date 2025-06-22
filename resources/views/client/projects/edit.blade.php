@extends('dashboard.client', ['current' => 'projects'])

@section('main-content')
    <form action="{{ $project->id ? route('projects.update', $project) : route('projects.store') }}" method="POST"
        enctype="multipart/form-data" class="p-10">
        @csrf
        @if ($project->id)
            @method('PUT')
        @endif
        <div class="flex flex-col gap-4">
            <flux:input name="title" type="text" label="{{ __('title') }}"
                value="{{ $project->id ? $project->title : old('title') }}" />
            <flux:textarea name="description" type="text" label="{{ __('description') }}">
                {{ $project->id ? $project->description : old('description') }}</flux:textarea>
            <flux:input name="budget" type="number" min="0" label="{{ __('budget') }}"
                value="{{ $project->id ? $project->budget : old('budget') }}" />
            <flux:input name="deadline" type="date" label="{{ __('deadline') }}"
                value="{{ $project->id ? optional($project->deadline)->format('Y-m-d'): old('deadline') }}" />
            <flux:select name="category_id" label="{{ __('category') }}"
                value="{{ $project->id ? $project->category_id : old('category_id') }}">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </flux:select>
            <flux:button type="submit" variant="primary" class="w-full">{{ __('save') }}</flux:button>
        </div>
    </form>
@endsection
