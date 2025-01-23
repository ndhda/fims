<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use App\Models\FeeCategory;
use App\Models\Year;
use App\Models\Semester;
use App\Models\Programme;
use App\Models\FeeStatus;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FeeReportExport;  // You may need to create an export class
use PDF;  // F

class AdminReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
        // // Provide necessary data for filters (semesters, years, categories, etc.)
        // $semesters = Semester::all();
        // $years = Year::all();
        // $feeCategories = FeeCategory::all();
        // $programmes = Programme::all();
        // $students = Student::all();

        // return view('admin.reports.index', compact('semesters', 'years', 'feeCategories', 'programmes', 'students'));
    }
    // public function generateAdminReport(Request $request)
    // {
    //     $validated = $request->validate([
    //         'semester_id' => 'nullable|exists:semesters,id',
    //         'year_id' => 'nullable|exists:year,year_id',
    //         'fee_category_id' => 'nullable|exists:fee_category,fee_category_id',
    //         'programme_id' => 'nullable|exists:programmes,id',
    //         'student_id' => 'nullable|exists:students,student_id',
    //         'fee_status_id' => 'nullable|in:Paid,Pending,Unpaid',
    //     ]);

    //     $query = Fee::query();

    //     if ($request->semester_id) {
    //         $query->where('semester_id', $request->semester_id);
    //     }

    //     if ($request->year_id) {
    //         $query->where('year_id', $request->year_id);
    //     }

    //     if ($request->fee_category_id) {
    //         $query->where('fee_category_id', $request->fee_category_id);
    //     }

    //     if ($request->programme_id) {
    //         $query->whereHas('student.programme', function ($q) use ($request) {
    //             $q->where('programme_id', $request->programme_id);
    //         });
    //     }

    //     if ($request->student_id) {
    //         $query->where('student_id', $request->student_id);
    //     }

    //     if ($request->fee_status_id) {
    //         $query->where('fee_status_id', FeeStatus::where('status', $request->fee_status_id)->first()->id);
    //     }

    //     $fees = $query->get();

    //     // Generate PDF or Excel
    //     if ($request->export == 'pdf') {
    //         // Generate PDF report logic
    //     } elseif ($request->export == 'excel') {
    //         // Generate Excel report logic
    //     }

    //     return view('admin.fees.report', compact('fees'));
    // }

}
