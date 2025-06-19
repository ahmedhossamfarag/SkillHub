<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;

class DashboardController
{
    //

    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        switch ($role) {
            case UserRole::Freelancer:
                return view('dashboard.freelancer');
                break;
            case UserRole::Client:
                return view('dashboard.client');
                break;
            case UserRole::Admin:
                $categories = \App\Models\Category::take(10)->get();
                $tags = \App\Models\Tag::take(10)->get();
                return view('dashboard.admin')->with('categories', $categories)->with('tags', $tags);
                break;
        }
    }
}
