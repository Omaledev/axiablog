<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // showing the registeration form on the web
    public function showregister()
    {
        return view('auth.register');
    }

    // handling registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard')
            ->with('success', 'You have successfully logged in!');
    }

    // showing login form on the web
    public function showlogin()
    {
        return view('auth.login');
    }

    // handling login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('student.dashboard')
                ->with('success', 'You have successfully logged in!');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match']);
    }

    // handling logout
    public function logout(Request $request)
    {

        Auth::logout();
        $request->session()->invalidate();  // Clear all session data
        $request->session()->regenerateToken();  // Generate new CSRF token

        return redirect('/login')->with('success', 'Logged out successfully');
    }


    // admin login form for web
    public function showadminlogin()
    {
        return view('admin.login');
    }

    // handling admin login
    public function adminlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (!$user || !$user->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors(['email' => 'Admin access only']);
            }

            //    regenerating the session for security
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'You have successfully logged in!');
        }

        //    if the login failed
        return back()->withErrors([
            'email' => 'Invalid admin credentials',
        ]);
    }

    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Send password reset link
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Show reset password form
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with([
                'status' => 'Your password has been reset successfully!',
                'alert-type' => 'success'
            ])
            : back()->withErrors(['email' => [__($response)]]);
    }
}
