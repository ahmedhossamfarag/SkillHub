<?php

namespace App\Policies;

use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
     public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, $post)
    {
        return $user->isAdmin();
    }
}
