<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function create()
    {
        return view('user.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function login()
    {
        return view('user.login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($request->only('email', 'password'))) {
            return redirect('/');
        } else {
            return view('user.login').with('error', 'Invalid credentials');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
