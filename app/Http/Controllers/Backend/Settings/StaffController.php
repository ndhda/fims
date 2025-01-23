<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
  public function index()
  {
    $staffs = Staff::with('user')->get();
    // Use the correct variable name in compact()
    return view('super-admin.staff.index', compact('staffs'));
  }

    // Display the form to create a new staff account
    public function create()
    {
        return view('super-admin.staff.create');
    }

    // Store the new staff account
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:user_management,email',
            'password' => 'required|min:8|confirmed',
            'staff_id' => 'required|unique:staffs,staff_id', // Correct table name
            'staff_name' => 'required',
            'position' => 'required',
        ]);

        // Create the user account in user_management
        $user = User::create([
            'user_id' => uniqid(), // Generate unique ID
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'loa_code' => 2, // Example: 2 = Staff level
            'role_id' => '2',
        ]);

        // Create the staff record in staffs
        Staff::create([
            'staff_id' => $request->staff_id,
            'staff_name' => $request->staff_name,
            'position' => $request->position,
            'user_id' => $user->user_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }


    // Display all staff accounts

}
