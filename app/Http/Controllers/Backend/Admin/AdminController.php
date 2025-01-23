<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // Show Admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard'); // Create a view for Admin Dashboard
    }

    // Show the list of all students
    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    // Show the form to create a new student
    public function create()
    {
        return view('admin.students.create');
    }

    // Store a new student
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:students',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'semester' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'programme_category' => 'required|string|max:255',
            'programme_level' => 'required|string|max:255',
            'programme_name' => 'required|string|max:255',
        ]);

        $students = Student::create($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
    }

    // Show the form to edit a student
    public function edit($id)
    {
        $students = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    // Update the student details
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'programme_category' => 'required|string|max:255',
            'programme_level' => 'required|string|max:255',
            'programme_name' => 'required|string|max:255',
        ]);

        $students = Student::findOrFail($id);
        $students->update($request->all());

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    // Delete a student
    public function destroy($id)
    {
        $students = Student::findOrFail($id);
        $students->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }


    // public function viewStudentFees($studentId)
    // {
    //     $student = Student::findOrFail($studentId);
    //     $fee = Fee::where('fee_id', $student->fee_id)->first();

    //     return view('admin.view_student_fees', compact('student', 'fee'));
    // }

    // public function managePayments($studentId)
    // {
    //     $student = Student::findOrFail($studentId);
    //     $payments = $student->payments; // Assuming payments relationship is set up in Student model

    //     return view('admin.manage_payments', compact('student', 'payments'));
    // }


}
