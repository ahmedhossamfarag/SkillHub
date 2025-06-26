<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController
{
    public function index(Request $request)
    {
        return view('user.settings.index')->with('user', $request->user());
    }
}
