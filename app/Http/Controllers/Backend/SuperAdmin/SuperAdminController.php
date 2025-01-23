<?php

namespace App\Http\Controllers\Backend\SuperAdmin;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class SuperAdminController extends Controller
{
    // Show Super Admin dashboard
    public function dashboard()
    {
        return view('super-admin.dashboard'); // Create a view for Super Admin Dashboard
    }

    // Show all admins
    public function viewAdmins()
    {
        $admins = Staff::whereHas('user.roles', function ($query) {
            $query->where('role_name', 'admin');
        })->with('user')->get();

        return view('super_admin.admins.index', compact('admins'));
    }

    // Show form to create a new admin
    public function createAdminForm()
    {
        return view('super_admin.admins.create');
    }

    // Create a new admin
    public function createAdmin(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|unique:staff',
            'staff_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make('defaultpassword'),
        ]);

        $user->assignRole('admin');

        Staff::create([
            'user_id' => $user->id,
            'staff_id' => $request->staff_id,
            'staff_name' => $request->staff_name,
            'position' => $request->position,
        ]);

        return redirect()->route('super_admin.view_admins')->with('success', 'Admin created successfully!');
    }

    // Show form to edit an admin
    public function editAdmin($id)
    {
        $admin = Staff::with('user')->findOrFail($id);
        return view('super_admin.admins.edit', compact('admin'));
    }

    // Update admin details
    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'staff_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        $staff = Staff::findOrFail($id);
        $staff->update($request->only('staff_name', 'position'));

        return redirect()->route('super_admin.view_admins')->with('success', 'Admin updated successfully!');
    }

    // Delete an admin
    public function deleteAdmin($adminId)
    {
        $admin = User::findOrFail($adminId);
        $admin->delete();

        return redirect()->route('super_admin.view_admins')->with('success', 'Admin deleted successfully!');
    }
}
