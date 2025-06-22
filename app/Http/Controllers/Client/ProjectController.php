<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use function Laravel\Prompts\select;
use function Ramsey\Uuid\v1;

class ProjectController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::with('category')
        ->where('client_id', $request->user()->id)
        ->get();

        return view('client.projects.index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.projects.edit')->with('project', new Project())->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Project::class);

        $request->validate(Project::rules($request->user()->id));

        $project = $request->user()->projects()->create($request->only($this->getFillable()));

        return redirect(route('projects.show', $project));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project = Project::with('category')->where('id', $project->id)->first();
        return view('client.projects.show')->with('project', $project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('client.projects.edit')->with('project', $project)->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);

        $request->validate(Project::rules($request->user()->id, $project->id));

        $project->update($request->only($this->getFillable()));

        return redirect(route('projects.show', $project));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        Gate::authorize('delete', $project);
        
        $project->delete();

        return redirect(route('projects.index'));
    }

    private function getFillable(){
        return [
            'title',
            'description',
            'budget',
            'deadline',
            'category_id',
        ];
    }
}
