<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostsController
{
    public function index()
    {
        Gate::authorize('viewAny', Post::class);
        return view('admin.posts.index')->with('posts', Post::orderBy('created_at', 'desc')->get());
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $request->validate([
            'content' => 'required|string|max:10000',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->storePublicly('images', 'public');
        }

        Post::create([
            'content' => $request->input('content'),
            'image' => $image,
        ]);

        return redirect()->route('admin.posts.index');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
