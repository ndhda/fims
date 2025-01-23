<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    // Login Form
    public function signInForm()
    {
        return view('auth.login');
    }

    // Login Check
    public function signInCheck(Request $request)
    {
        // Validate username and password
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find user by username or email
        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        // Check if user exists
        if ($user && Hash::check($request->password, $user->password)) {
            // Check if role is Super Admin
            if ($user->role && $user->role->role_name === 'Super Admin') {
                // Store user in session and redirect to Super Admin dashboard
                Auth::login($user);
                return redirect()->route('super-admin.dashboard');
            } else {
                return back()->withErrors(['error' => 'Invalid role or access not allowed.']);
            }
        }

        return back()->withErrors(['error' => 'Username or Password is incorrect.']);
    }

    // Logout
    public function signOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
