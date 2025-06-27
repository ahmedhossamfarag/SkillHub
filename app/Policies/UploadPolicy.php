<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UploadPolicy
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
        return $user->id == $project->client_id || DB::table('project_freelancers')->where('freelancer_id', $user->id)->where('project_id', $project->id)->exists();
    }

    public function create(User $user, Project $project)
    {
        return $user->isFreelancer() && DB::table('project_freelancers')->where('freelancer_id', $user->id)->where('project_id', $project->id)->exists();
    }

    public function delete(User $user, $upload)
    {
        return $upload->user_id === $user->id;
    }
}
