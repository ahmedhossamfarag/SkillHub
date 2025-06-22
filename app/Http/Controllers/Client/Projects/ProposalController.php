<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController
{
    public function index(Project $project){
        $proposals = Proposal::with('freelancer')->where('project_id', $project->id)->get();
        return view('client.projects.proposals.index')->with('project', $project)->with('proposals', $proposals);
    }

    public function accept(Project $project, Proposal $proposal){
        $proposal->update(['status' => 'accepted']);

        $project->freelancers()->syncWithoutDetaching($proposal->freelancer_id);

        return redirect(route('client.projects.proposals.index', $project));
    }

    public function reject(Project $project, Proposal $proposal){
        $proposal->update(['status' => 'rejected']);

        return redirect(route('client.projects.proposals.index', $project));
    }
}
