<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\User;
use App\Models\Review;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfileController
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request, ?string $id = null)
    {
        $user = $id ? User::findOrFail($id) : $request->user();

        $profile = Profile::with('skills', 'tags')->where('user_id', $user->id)->firstOrFail();

        $reviews = $user->isClient() ?
            Review::with('freelancer')->where('client_id', $user->id)->where('review_type', 'freelancer')->get() :
            Review::with('client')->where('freelancer_id', $user->id)->where('review_type', 'client')->get();
     
        return view('profile.show')->with('profile', $profile)->with('user', $user)->with('reviews', $reviews);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        $profile = Profile::with('skills', 'tags')->where('user_id', $user->id)->firstOrFail();

        return view('profile.edit')->with('profile', $profile)->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        Gate::authorize('update', $profile);

        $request->validate(Profile::rules());

        $profile->update($request->only('description', 'location', 'experience'));

        $profile->skills()->delete();
        $profile->tags()->detach();

        $profile->skills()->createMany(array_map(fn ($skill) => ['name' => $skill], $request->input('skills', [])));
        $profile->tags()->attach($request->input('tags', []));

        return redirect()->route('profile.show');
    }
}
