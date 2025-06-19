<?php

namespace App\Policies\Freelancer;

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
        return $user->isFreelancer();
    }

    public function update(User $user, Review $review)
    {
        return $user->id === $review->freelancer_id && $review->review_type === 'freelancer';
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->freelancer_id && $review->review_type === 'freelancer';
    }
}
