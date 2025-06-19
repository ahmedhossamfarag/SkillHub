<?php

namespace App\Http\Controllers\Client;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = $request->user()->reviews()->get();

        return $reviews;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['review_type' => 'client']);

        $request->validate(Review::rules($request->user()->id, $request->freelancer_id, $request->project_id));

        $review = $request->user()->reviews()->create($request->only(Review::getFillable()));

        $review->project()->associate($request->project_id);
        $review->freelancer()->associate($request->freelancer_id);
        $review->save();

        return $review;
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return $review;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return $review;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate(Review::rules($request->user()->id, $request->freelancer_id, $request->project_id, $review->id));

        $review->update($request->only(Review::getFillable()));

        return $review;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully'], 200);
    }
}
