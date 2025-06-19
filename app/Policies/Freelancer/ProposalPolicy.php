<?php

namespace App\Policies\Freelancer;

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
        return $user->id === $proposal->freelancer_id;
    }

    public function delete(User $user, Proposal $proposal)
    {
        return $user->id === $proposal->freelancer_id;
    }
}
