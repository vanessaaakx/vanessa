<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // protected function sendFailedLoginResponse(Request $request)
    // {
    //     throw ValidationException::withMessages([
    //         $this->username() => [trans('auth.failed')],
    //     ])->redirectTo('/login')->withErrors(['email' => 'Your email is not verified.']);
    // }
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirect authenticated users to the dashboard
        }
        return view('auth.login');
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || $user->email_verified_at == null){
            return redirect('/')->with('error', 'Sorry your accont is not yet verified or does not exist');
        }

        $login = auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(!$login){
            return back()->with('error', 'Invalid credentials');
        }

        return view('dashboard');
    }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required']
    //     ]);
    //     +6


    //     if(auth()->attempt($credentials)) {

    //         // if(!auth()->user()->email_verified_at) {
    //         //     auth()->logout();
    //         //     return redirect('/')->with('error', 'Your email is not verified.');
    //         // } else {

    //             $request->session()->regenerate();

    //             return redirect()->intended('dashboard');
    //         // }
    //     } 
        

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.'
    //     ])->onlyInput('email');
    // }

    public function registerForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirect authenticated users to the dashboard
        }
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed']
        ]);

        $fields['remember_token'] = Str::random(24);

        $user = User::create($fields);

        Mail::send('auth.verification-mail', ['user' => $user], function($mail) use ($user) {
            $mail->to($user->email);
            $mail->subject('Account Verification');

        });
        return redirect('/')->with('message', 'Your account has been created. Please check your email for verification.');
    }

    public function verification(User $user, $token)
    {
        if($user->remember_token !== $token) {
            return redirect('/')->with('error', 'Invalid token.');
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect('/')->with('message', 'Your account has been verified.');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out.');
    }
}