<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Review;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController
{
    public function store(Request $request, Project $project)
    {

        Gate::authorize('create', Review::class);

        $request->merge(['review_type' => 'client', 'project_id' => $project->id, 'client_id' => $request->user()->id]);

        $request->validate(Review::rules($request->user()->id, $request->freelancer_id, $project->id));

        $review = new Review();

        $review->fill($request->only(Review::getFillableFields()));

        $review->project()->associate($project->id);
        $review->freelancer()->associate($request->freelancer_id);
        
        $request->user()->reviews()->save($review);

        return redirect(route('client.projects.freelancers.index', $project));
    }

    public function destroy(Project $project, Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return redirect(route('client.projects.freelancers.index', $project));
    }
}
