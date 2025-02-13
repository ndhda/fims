<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Fee;
use App\Models\Student;
use App\Models\FeeCategory;
use App\Models\Year;
use App\Models\AcademicSession;
use App\Models\Semester;
use App\Models\Programme;
use App\Models\FeeStatus;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FeeReportExport;  // You may need to create an export class
use Barryvdh\DomPDF\Facade\PDF;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class AdminReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');

    }

    public function studentReport(Request $request)
    {
        // Fetch the programmes for the filter dropdown
        $programmes = Programme::all();

        // Fetch students with the applied filters
        $students = Student::with(['programme', 'faculty', 'fundingSource'])
            ->when($request->filled('programme_id'), function ($query) use ($request) {
                return $query->where('programme_id', $request->programme_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('full_name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

        return view('admin.reports.student', compact('students', 'programmes'));
    }

    public function downloadStudentReport(Request $request)
    {
        // Fetch the student data for the report (similar query as in the studentReport method)
        $students = Student::with(['programme', 'faculty'])
            ->when($request->input('programme'), function ($query) use ($request) {
                return $query->where('programme_id', $request->input('programme'));
            })
            ->when($request->input('status'), function ($query) use ($request) {
                return $query->where('status', $request->input('status'));
            })
            ->get();

        // Create a zip archive
        $zip = new ZipArchive();
        $fileName = "student_report_" . time() . ".zip";
        $zip->open(public_path($fileName), ZipArchive::CREATE);

        foreach ($students as $student) {
            // Write each student's report as a file within the ZIP
            $content = "Full Name: {$student->full_name}\n";
            $content .= "Matric Number: {$student->matric_num}\n";
            $content .= "Programme: {$student->programme->programme_name}\n";
            $content .= "Faculty: {$student->faculty->faculty_name}\n\n";

            $zip->addFromString("{$student->matric_num}_report.txt", $content);
        }

        $zip->close();

        // Return the generated zip file for download
        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }

    public function viewReport($studentId)
    {
        // Fetch student information
        $student = Student::with([
            'faculty',
            'programme',
            'programme.eduMode',
            'semester',
            'fundingSource'
        ])->findOrFail($studentId);

        // Fetch fees and transactions
        $transactions = Fee::with(['feeCategory', 'amountPaid'])
            ->where('student_id', $studentId)
            ->get()
            ->map(function ($fee) {
                $paidAmount = $fee->amountPaid->sum('amount_paid');
                return [
                    'date' => $fee->created_at->format('Y-m-d'),
                    'document' => $fee->invoice_num,
                    'description' => $fee->feeCategory->fee_category_name,
                    'charges' => $fee->total_amount,
                    'payments' => $paidAmount,
                    'balance' => $fee->total_amount - $paidAmount,
                ];
            });

        // Calculate summary
        $summary = [
            'charges' => $transactions->sum('charges'),
            'payments' => $transactions->sum('payments'),
            'balance' => $transactions->sum('balance'),
        ];

        // Generate PDF
        $pdf = PDF::loadView('admin.reports.view-student', compact('student', 'transactions', 'summary'));
        return $pdf->stream('student_report.pdf');
    }

}
