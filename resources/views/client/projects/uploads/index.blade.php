@extends('client.projects.layout', ['current' => 'uploads'])

@section('main-content')
    <h1 class="text-4xl font-sans text-center">Uploads</h1>
    @can('create', [App\Models\Upload::class, $project])
        <a href="{{ route('client.projects.uploads.create', $project) }}" class="text-blue-500 underline text-xl px-2">Create
            Upload</a>
    @endcan
    <flux:separator />
    <div class="space-y-10 p-10">
        @foreach ($uploads as $upload)
            <div class="bg-[#1d1d20] space-y-2 rounded-md p-3">
                <flux:heading size="xl">{{ $upload->name }}</flux:heading>
                <flux:text>{{ $upload->description }}</flux:text>
                <div class="flex gap-10 justify-end">
                    @can('viewAny', [App\Models\Upload::class, $project])
                        <a href="{{ route('client.projects.uploads.show', [$project, $upload]) }}">
                            <flux:button variant="primary" color="blue" class="cursor-pointer">View</flux:button>
                        </a>
                    @endcan
                    @can('delete', $upload)
                        <form action="{{ route('client.projects.uploads.destroy', [$project, $upload]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="primary" color="red" class="cursor-pointer">Delete</flux:button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
@endsection
