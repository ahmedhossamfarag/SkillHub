<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Proposal;

class ProposalPolicy
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
        return $user->isFreelancer();
    }

    public function update(User $user, Proposal $proposal)
    {
        return $user->isClient() && $user->id === $proposal->project->client_id;
    }
}
