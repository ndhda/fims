<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Programme;
use App\Models\Semester;
use App\Models\FundingSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $faculties = Faculty::all();
        $programmes = Programme::all();
        $semesters = Semester::all();
        $funding_sources = FundingSource::all();

        return view('auth.register', compact('faculties', 'programmes', 'semesters', 'funding_sources'));
    }

    public function register(Request $request)
    {
        // Validate the registration fields
        $request->validate([
            'matric_num' => 'required|unique:students,matric_num',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user_management,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'faculty_id' => 'required|exists:faculties,faculty_id',
            'programme_id' => 'required|exists:programmes,id',
            'semester_id' => 'required|exists:semesters,semester_id',
            'hostel' => 'required|in:yes,no',
            'international' => 'required|in:yes,no',
            'scholarship' => 'required|in:yes,no',
            'funding_id' => 'required|exists:funding_sources,id',
            'contact_num' => 'required|string|max:15',
        ]);

        // Create User Account
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,  // Assuming '3' is the role ID for Student
            'loa_code' => 3,  // Set loa_code for Student Access
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Student Record
        $student = Student::create([
            'matric_num' => $request->matric_num,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'faculty_id' => $request->faculty_id,
            'programme_id' => $request->programme_id,
            'semester_id' => $request->semester_id,
            'hostel' => $request->hostel,
            'international' => $request->international,
            'scholarship' => $request->scholarship,
            'funding_id' => $request->funding_id,
            'contact_num' => $request->contact_num,
            'status' => 'active',
            'user_id' => $user->id,
        ]);

        // Associate student with user
        $user->student_id = $student->student_id;
        $user->save();

        // Auto-login after registration
        Auth::login($user);

        // Check if user is authenticated
        if (Auth::check()) {
            return redirect()->route('student.dashboard')->with('success', 'Registration successful!');
        } else {
            return redirect()->route('login')->withErrors(['email' => 'Login failed, please try again.']);
        }
    }

}
