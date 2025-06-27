<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Review;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FreelancerController
{
    public function index(Project $project)
    {
        $freelancers = DB::table('project_freelancers')
        ->where('project_freelancers.project_id', $project->id)
        ->join('users', 'project_freelancers.freelancer_id', '=', 'users.id')
        ->leftJoin('reviews', function ($join) use ($project) {
            $join->on('project_freelancers.freelancer_id', '=', 'reviews.freelancer_id')
            ->where('reviews.project_id', '=', $project->id)
            ->where('reviews.review_type', '=', 'client');
        })
        ->select('users.id', 'users.name', 'users.email', 'users.avatar', 'reviews.id as review_id', 'reviews.rating as review_rating', 'reviews.comment as review_comment')
        ->get();

        return view('client.projects.freelancers.index')->with('project', $project)->with('freelancers', $freelancers);
    }
}
