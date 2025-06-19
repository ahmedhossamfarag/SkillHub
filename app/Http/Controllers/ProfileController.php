<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController
{
    
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $profile = $request->user()->profile()->get();

        return $profile;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $profile = $request->user()->profile()->get();

        return $profile;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(Profile::rules());

        $request->user()->profile()->update($request->only('description', 'location', 'experience'));
    }
}
