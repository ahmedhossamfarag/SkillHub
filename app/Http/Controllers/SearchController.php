<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class SearchController
{
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'min_budget' => 'nullable|integer|min:0',
            'max_budget' => 'nullable|integer|min:0',
            'deadline_before' => 'nullable|date',
            'deadline_after' => 'nullable|date',
            'created_before' => 'nullable|date',
            'created_after' => 'nullable|date',
        ]);

        $query = $request->input('query');
        $categoryId = $request->input('category_id');
        $minBudget = $request->input('min_budget');
        $maxBudget = $request->input('max_budget');
        $deadlineBefore = $request->input('deadline_before');
        $deadlineAfter = $request->input('deadline_after');
        $createdBefore = $request->input('created_before');
        $createdAfter = $request->input('created_after');

        $searchQuery = Project::search($query);

        if ($categoryId) {
            $searchQuery->where('category_id', $categoryId);
        }

        $projects = $searchQuery->get();

        if ($minBudget){
            $projects = $projects->where('budget', '>=', $minBudget);
        }

        if ($maxBudget){
            $projects = $projects->where('budget', '<=', $maxBudget);
        }

        if ($deadlineBefore){
            $projects = $projects->where('deadline', '<=', $deadlineBefore);
        }

        if ($deadlineAfter){
            $projects = $projects->where('deadline', '>=', $deadlineAfter);
        }

        if ($createdBefore){
            $projects = $projects->where('created_at', '<=', $createdBefore);
        }

        if ($createdAfter){
            $projects = $projects->where('created_at', '>=', $createdAfter);
        }

        $workProjects = $request->user() ? $request->user()->workprojects()->get()->pluck('id')->toArray() : [];

        $categories = Category::all();

        return view('search.index', compact('projects', 'workProjects', 'categories', 'query', 'categoryId', 'minBudget', 'maxBudget', 'deadlineBefore', 'deadlineAfter', 'createdBefore', 'createdAfter'));
    }
}
