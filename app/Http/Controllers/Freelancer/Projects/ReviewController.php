<?php

namespace App\Http\Controllers\Freelancer\Projects;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController
{
    
    public function store(Request $request)
    {
        Gate::authorize('create', Review::class);

        $request->merge(['review_type' => 'freelancer', 'project_id' => $request->project_id, 'client_id' => $request->client_id]);

        $request->validate(Review::rules($request->client_id, $request->user()->id, $request->project_id));

        $review = new Review();

        $review->fill($request->only(Review::getFillableFields()));

        $review->project()->associate($request->project_id);
        $review->client()->associate($request->client_id);
        $request->user()->workreviews()->save($review);

        return redirect(route('freelancer.projects.index'));
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return redirect(route('freelancer.projects.index'));
    }
}
