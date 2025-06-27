<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Project;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UploadController
{
    public function index(Project $project)
    {
        Gate::authorize('viewAny', [Upload::class, $project]);
        return view('client.projects.uploads.index')->with('uploads', $project->uploads)->with('project', $project);
    }

    public function create(Project $project)
    {
        Gate::authorize('create', [Upload::class, $project]);
        return view('freelancer.projects.uploads.create')->with('project', $project);
    }

    public function store(Request $request, Project $project)
    {
        Gate::authorize('create', [Upload::class, $project]);

        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'string|max:255',
            'file' => 'required|file',
        ]);

        $request->merge([
            'user_id' => $request->user()->id
        ]);

        if ($request->hasFile('file')) {
            $request->merge([
                'path' => $request->file('file')->store('uploads')
            ]);
        }

        $project->uploads()->create($request->only(['name', 'description', 'path', 'user_id']));
        return redirect()->route('client.projects.uploads.index', $project);
    }

    public function show(Project $project, Upload $upload)
    {
        Gate::authorize('viewAny', [Upload::class, $project]);
        return Storage::download($upload->path);
    }

    public function destroy(Project $project, Upload $upload)
    {
        Gate::authorize('delete', $upload);
        Storage::delete($upload->path);
        $upload->delete();
        return redirect()->route('client.projects.uploads.index', $project);
    }
}
