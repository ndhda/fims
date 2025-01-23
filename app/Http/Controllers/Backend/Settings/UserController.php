<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Super Admin creating an Admin
    public function createAdmin(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|string',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign the 'admin' role to this user
        $adminRole = Role::where('name', 'admin')->first();
        $user->roles()->attach($adminRole);

        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully!');
    }

    public function createStudent(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'name' => 'required|string',
        ]);

        // Create student user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign the 'student' role to this user
        $studentRole = Role::where('name', 'student')->first();
        $user->roles()->attach($studentRole);

        return redirect()->route('admin.dashboard')->with('success', 'Student created successfully!');
    }

}
