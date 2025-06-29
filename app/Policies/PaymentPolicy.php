<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class PaymentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user, Project $project)
    {
        return $user->id === $project->client_id;
    }

    public function create(User $user, Project $project)
    {
        return $user->id === $project->client_id;
    }

    public function update(User $user, Project $project, $freelancer)
    {
        return $user->id === $project->client_id && DB::table('project_freelancers')->where('freelancer_id', $freelancer->id)->where('project_id', $project->id)->exists();
    }
}
