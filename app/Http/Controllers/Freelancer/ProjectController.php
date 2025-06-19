<?php

namespace App\Http\Controllers\Freelancer;

use Illuminate\Http\Request;

class ProjectController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = $request->user()->workprojects()->with('reviews')->get();

        return $projects;
    }
}
