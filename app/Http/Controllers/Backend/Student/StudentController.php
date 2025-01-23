<?php

namespace App\Http\Controllers\Backend\Student;

use App\Models\Student;
use App\Models\Fee;
use App\Models\Refund;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    // Show Student dashboard
    public function dashboard()
    {
        return view('student.dashboard'); // Create a view for Student Dashboard
    }

    // // View Student fee details
    // public function viewFees()
    // {
    //     $student = auth()->user()->student; // Fetch logged-in student's data
    //     $fee = Fee::where('fee_id', $student->fee_id)->first();

    //     return view('student.view_fees', compact('fee'));
    // }

    // // Apply for refund
    // public function applyRefund(Request $request)
    // {
    //     $request->validate([
    //         'refund_type' => 'required|string',
    //         'total_refund' => 'required|numeric',
    //         'message' => 'required|string',
    //     ]);

    //     Refund::create([
    //       'student_id' => auth()->user()->student->id,
    //       'refund_type' => $request->refund_type,
    //       'total_refund' => $request->total_refund,
    //       'message' => $request->message,
    //       'status' => 'pending',
    //     ]);

    //     return redirect()->route('student.dashboard')->with('success', 'Refund application submitted successfully!');
    // }

    // // Upload clearance form
    // public function uploadClearanceForm(Request $request)
    // {
    //     $request->validate([
    //         'clearance_form' => 'required|file|mimes:pdf|max:10240',
    //     ]);

    //     $file = $request->file('clearance_form');
    //     $path = $file->storeAs('clearance_forms', auth()->user()->student_id . '.pdf');

    //     // Update student record with clearance form path
    //     $student = auth()->user()->student;
    //     $student->clearance_form_doc = $path;
    //     $student->save();

    //     return redirect()->route('student.dashboard')->with('success', 'Clearance form uploaded successfully!');
    // }
}
