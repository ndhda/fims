<?php

namespace App\Http\Controllers\Backend\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\Fee;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\PDF;

class StudentReportController extends Controller
{
    public function index()
    {
        return view('student.reports.index');
    }

    public function generateStudentReport(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
        ]);

        $student = Student::findOrFail($validated['student_id']);

        // Fetch fee payments for the student
        $fees = Fee::where('student_id', $student->student_id)->get();

        // Calculate total paid, pending balance, and overdue fees
        $totalPaid = $fees->where('fee_status_id', 3)->sum('total_amount'); // Paid status
        $pendingBalance = $fees->where('fee_status_id', 2)->sum('amount_balance'); // Pending status
        $overdueFees = $fees->where('due_date', '<', now())->where('fee_status_id', 1)->sum('amount_balance'); // Unpaid status and overdue

        return view('student.fees.report', compact('fees', 'totalPaid', 'pendingBalance', 'overdueFees'));
    }

}
