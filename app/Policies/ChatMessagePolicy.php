<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChatMessagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, $project)
    {
        return $project->client_id === $user->id || DB::table('project_freelancers')->where('freelancer_id', $user->id)->where('project_id', $project->id)->exists();
    }

    public function viewAny(User $user, $project)
    {
        return $project->client_id === $user->id || DB::table('project_freelancers')->where('freelancer_id', $user->id)->where('project_id', $project->id)->exists();
    }
}
