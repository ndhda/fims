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
      $studentId = Auth::user()->student_id; // Get the logged-in student's ID

      // Fetch student report
      $fees = Fee::with(['feeCategory', 'amountPaid'])
          ->where('student_id', $studentId)
          ->get()
          ->map(function ($fee) {
              $paidAmount = $fee->amountPaid->sum('amount_paid');
              return [
                  '#' => $fee->fee_id,
                  'date' => $fee->created_at->format('Y-m-d'),
                  'document_no' => $fee->invoice_num,
                  'category' => $fee->feeCategory->fee_category_name,
                  'amount_bnd' => $fee->total_amount,
                  'paid_bnd' => $paidAmount,
                  'balance_bnd' => $fee->total_amount - $paidAmount,
              ];
          });

          // Calculate summary totals
          $summary = [
              'total_amount' => $fees->sum('amount_bnd'),
              'total_paid' => $fees->sum('paid_bnd'),
              'total_balance' => $fees->sum('balance_bnd'),
          ];

      return view('student.reports.index', compact('fees', 'summary'));
  }

  public function generatePDF()
  {
      $studentId = Auth::user()->student_id;

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
      $pdf = PDF::loadView('student.reports.pdf', compact('student', 'transactions', 'summary'));
      return $pdf->stream('student_report.pdf');
  }

}
