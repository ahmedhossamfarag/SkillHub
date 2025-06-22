<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class SearchController
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category_id');

        $searchQuery = Project::search($query);

        if ($categoryId) {
            $searchQuery->where('category_id', $categoryId);
        }

        $projects = $searchQuery->get();

        $workProjects = $request->user() ? $request->user()->workprojects()->get()->pluck('id')->toArray() : [];

        return view('search.index')->with('categories', Category::all())->with('projects', $projects)->with('query', $query)->with('categoryId', $categoryId)->with('workProjects', $workProjects);
    }
}
