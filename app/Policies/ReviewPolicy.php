<?php

namespace App\Policies;

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
        return $user->isClient() || $user->isFreelancer();
    }

    public function delete(User $user, Review $review)
    {
        return ($user->id === $review->client_id && $review->review_type === 'client') || ($user->id === $review->freelancer_id && $review->review_type === 'freelancer');
    }
}
