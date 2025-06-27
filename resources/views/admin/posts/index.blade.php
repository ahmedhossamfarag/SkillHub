@extends('dashboard.admin', ['current' => 'posts'])

@section('main-content')
    <h1 class="text-6xl font-sans text-center">{{ __('posts') }}</h1>

    @can('create', App\Models\Post::class)
        <a href="{{ route('admin.posts.create') }}" class="text-blue-500 underline text-xl px-2">{{ __('create-post') }}</a>
    @endcan

    <flux:separator />
    <div class="flex flex-wrap gap-5 p-10">
        @foreach ($posts as $post)
            <div class="bg-[#1d1d20] w-[400px] h-fit space-y-2">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{  __('image') }}" class="mx-auto max-w-full">
                @endif
                <div>
                    {!! $post->content !!}
                </div>
                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="w-full mt-4">
                    @csrf
                    @method('DELETE')
                    @can('delete', $post)
                        <flux:button type="submit" variant="primary" color="red" class="cursor-pointer w-full">{{ __('delete') }}</flux:button>
                    @endcan
                </form>
            </div>
        @endforeach
    </div>
@endsection