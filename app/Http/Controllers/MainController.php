<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController
{
    public function index()
    {
        return view('welcome')->with('posts', \App\Models\Post::orderBy('created_at', 'desc')->get());
    }
}
