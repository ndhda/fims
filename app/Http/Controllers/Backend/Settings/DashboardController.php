<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Fee;
use App\Models\FeeStatus;
use App\Models\ClearanceForm;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superAdminDashboard()
    {
        // Logic for the Super Admin dashboard
        return view('super-admin.dashboard');
    }

  public function adminDashboard()
    {
        $hostelStudents = Student::where('hostel', 'yes')->count();
        $scholarshipStudents = Student::where('scholarship', 'yes')->count();
        $internationalStudents = Student::where('international', 'yes')->count();
        $pendingPaymentsCount = Fee::whereHas('feeStatus', function ($query) {
          $query->where('fee_status_name', 'Pending');
        })->count();

        // Get detailed list of pending payment requests
        $pendingPayments = Fee::whereHas('feeStatus', function ($query) {
          $query->where('fee_status_name', 'Pending');
        })->with(['student', 'feeCategory', 'feeStatus'])->get();


        $unsettledPayments = Fee::where('amount_balance', '>', 0)->count();

        $pendingClearance = ClearanceForm::count();

        return view('admin.dashboard', compact('hostelStudents', 'scholarshipStudents', 'internationalStudents', 'pendingPaymentsCount', 'pendingPayments', 'unsettledPayments', 'pendingClearance'));
    }

    public function studentDashboard()
    {
      $studentId = Auth::user()->student_id; // Get logged-in student's ID

      // Count of Fully Paid Fees
      $fullyPaid = Fee::where('student_id', $studentId)
                      ->whereHas('feeStatus', function ($query) {
                          $query->where('fee_status_name', 'Paid');
                      })->count();

      // Total Outstanding Balance
      $outstandingBalance = Fee::where('student_id', $studentId)->sum('amount_balance');

      // Get Outstanding Payments (Partially Paid or Unpaid)
      $outstandingPayments = Fee::where('student_id', $studentId)
      ->whereIn('fee_status_id', function ($query) {
          $query->select('fee_status_id')
                ->from('fee_status')
                ->whereIn('fee_status_name', ['Partially Paid', 'Unpaid']);
      })
      ->with(['feeStatus', 'feeCategory'])  // Eager load fee status and category
      ->get();

      return view('student.dashboard', compact('fullyPaid', 'outstandingBalance', 'outstandingPayments'));
    }
}
