<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->isClient();
    }

    public function update(User $user, Project $project)
    {
        return $user->id === $project->client_id;
    }

    public function delete(User $user, Project $project)
    {
        return $user->id === $project->clien_id;
    }
}
