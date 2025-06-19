<?php

namespace App\Http\Controllers\Freelancer;

use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proposals = $request->user()->proposals()->get();

        return $proposals;
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
        $request->validate(Proposal::rules());

        $proposal = $request->user()->proposals()->create(Proposal::getFillable());

        return $proposal;
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        return $proposal;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        return $proposal;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $request->validate(Proposal::rules());

        $proposal->update($request->only(Proposal::getFillable()));

        return $proposal;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return response()->json(['message' => 'Proposal deleted successfully'], 200);
    }
}
