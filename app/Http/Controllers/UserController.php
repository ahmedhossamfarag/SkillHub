<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'password_confirmation' => ['required', 'same:password'],
            'role' => ['required', 'in:client,freelancer'],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $avatar = null;

        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->storePublicly('avatars', 'public');
        }

        try{
           DB::transaction(function () use ($request, $avatar) {
                $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRole::from($request->role),
                'avatar' => $avatar
                ]);
            
                $user->profile()->create([
                    'description' => '',
                    'location' => '',
                    'experience' => '',
                ]);

                Auth::login($user);
           });

            return redirect('/dashboard');
        }catch(\Exception $e){
            return view('user.register')->with('error', 'Something went wrong');
        }
    }

    public function login()
    {
        return view('user.login')->with('error', null);
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($request->only('email', 'password'))) {
            return redirect('/dashboard');
        } else {
            return view('user.login', ['error' => 'Invalid credentials']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }
}
