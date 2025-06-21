<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController
{
    public function index(){}

    public function show(Request $request, Project $project, Proposal $proposal){}

    public function accept(Request $request, Project $project, Proposal $proposal){}

    public function reject(Request $request, Project $project, Proposal $proposal){}
}
