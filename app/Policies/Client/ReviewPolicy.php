<?php

namespace App\Policies\Client;

use App\Models\User;
use App\Models\Review;

class ReviewPolicy
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

    public function update(User $user, Review $review)
    {
        return $user->id === $review->client_id && $review->review_type === 'client';
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->client_id && $review->review_type === 'client';
    }
}
