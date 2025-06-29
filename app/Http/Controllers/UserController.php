<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{

    public function create()
    {
        return view('user.register')->with('error', null);
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

                $this->sendVerificationEmail($user);

                Auth::login($user);
           });

            return redirect('/dashboard');
        }catch(\Exception $e){
            return redirect()->back()->withInput()->with('error', 'Something went wrong');
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

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
 
        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordForm( Request $request, string $token)
    {
        return view('user.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
            }
        );
    
        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    private function sendVerificationEmail(User $user)
    {
        $user->sendEmailVerificationNotification();
    }
}
