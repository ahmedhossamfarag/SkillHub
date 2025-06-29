<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentController
{
    public function index(Project $project)
    {
        Gate::authorize('viewAny', [Payment::class, $project]);
        $payments = Payment::with('freelancer')->where('project_id', $project->id)->get();
        return view('client.projects.payments.index')->with('project', $project)->with('payments', $payments);
    }

    public function create(Project $project)
    {
        Gate::authorize('create', [Payment::class, $project, null]);
        $freelancers = $project->freelancers()->where('stripe_account_id', '!=', null)->get();
        return view('client.projects.payments.create')->with('project', $project)->with('freelancers', $freelancers);
    }
}
