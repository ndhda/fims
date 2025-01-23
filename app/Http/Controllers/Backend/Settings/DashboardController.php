<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function superAdminDashboard()
    {
        // Logic for the Super Admin dashboard
        return view('super-admin.dashboard');
    }

    public function adminDashboard()
    {
        // Logic for the Admin dashboard
        return view('admin.dashboard');
    }

    public function studentDashboard()
    {
        // Logic for the Student dashboard
        return view('student.dashboard');
    }
}
