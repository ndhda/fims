<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Retrieve the authenticated user's details
            $user = Auth::user();

            // Fetch the user's role from the user_management table
            $role = User::where('id', $user->id)->first()->role_id;

            // Redirect based on role
            switch ($role) {
                case 1: // Assuming role_id = 1 is Super Admin
                    return redirect()->route('super_admin.dashboard');
                case 2: // Assuming role_id = 2 is Staff/Admin
                    return redirect()->route('admin.dashboard');
                case 3: // Assuming role_id = 3 is Student
                    return redirect()->route('student.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Unauthorized role.']);
            }
        }

        // Redirect back with error if authentication fails
        return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
