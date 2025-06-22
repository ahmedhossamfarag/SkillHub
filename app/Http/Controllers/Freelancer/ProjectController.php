<?php

namespace App\Http\Controllers\Freelancer;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = DB::table('project_freelancers')
        ->where('project_freelancers.freelancer_id', $request->user()->id)
        ->join('projects', 'project_freelancers.project_id', '=', 'projects.id')
        ->join('categories', 'projects.category_id', '=', 'categories.id')
        ->leftJoin('reviews', function ($join) use ($request) {
            $join->on('projects.id', '=', 'reviews.project_id')
            ->where('reviews.freelancer_id', '=', $request->user()->id)
            ->where('reviews.review_type', '=', 'freelancer');
        })
        ->select('projects.*', 'categories.name as category_name', 'reviews.id as review_id', 'reviews.rating as review_rating', 'reviews.comment as review_comment')
        ->get();

        return view('freelancer.projects.index')->with('projects', $projects);
    }

    public function show(Project $project)
    {
        return view('freelancer.projects.show')->with('project', $project);
    }
}
