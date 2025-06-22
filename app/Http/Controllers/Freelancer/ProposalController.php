<?php

namespace App\Http\Controllers\Freelancer;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProposalController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proposals = Proposal::with('project')->where('freelancer_id', $request->user()->id)->get();

        return view('freelancer.proposals.index')->with('proposals', $proposals);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('freelancer.proposals.create')->with('project', Project::findOrFail($request->project_id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Proposal::class);

        $request->merge(['status' => 'pending', 'project_id' => $request->project_id]);

        $request->validate(Proposal::rules());

        $exist = Proposal::where('freelancer_id', $request->user()->id)->where('project_id', $request->project_id)->exists();

        if ($exist) {
            return redirect(route('proposals.index'));
        } else {
            $exist = DB::table('project_freelancers')->where('freelancer_id', $request->user()->id)->where('project_id', $request->project_id)->exists();

            if ($exist) {
                return redirect(route('freelancer.projects.index'));
            }
        }

        $proposal = new Proposal();

        $proposal->fill($request->only($this->getFillable()));

        $proposal->project()->associate($request->project_id);

        $request->user()->proposals()->save($proposal);

        return redirect(route('proposals.index'));
    }

    private function getFillable()
    {
        return [
            'paid_amount',
            'estimated_time',
            'status'
        ];
    }
}
