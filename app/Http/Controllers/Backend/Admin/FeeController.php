<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Str;
use App\Models\Fee;
use App\Models\FeeCategory;
use App\Models\FeeStatus;
use App\Models\Year;
use App\Models\AmountPaid;
use App\Models\Student;
use App\Models\AcademicSession;
use App\Models\Programme;
use App\Models\Semester;
use App\Models\FeeRule;

class FeeController extends Controller
{
  public function index(Request $request)
  {
      $user = Auth::user();
      if (!$user || $user->role_id !== 2) { // Assuming role_id=2 is admin
          return redirect()->route('login');
      }

      // Retrieve filter parameters
      $selectedFeeCategory = $request->input('fee_category', null);
      $selectedYear = $request->input('year', null);
      $selectedSession = $request->input('academic_session', null);
      $selectedStatus = $request->input('status', null);

      // Retrieve fees with filtering
      $fees = Fee::with(['student', 'year', 'feeCategory', 'feeStatus', 'academicSession'])
          ->when($selectedFeeCategory, function ($query) use ($selectedFeeCategory) {
              $query->whereHas('feeCategory', function ($feeCategoryQuery) use ($selectedFeeCategory) {
                  $feeCategoryQuery->where('fee_category_name', $selectedFeeCategory);
              });
          })
          ->when($selectedYear, function ($query) use ($selectedYear) {
              $query->whereHas('year', function ($yearQuery) use ($selectedYear) {
                  $yearQuery->where('year_name', $selectedYear);
              });
          })
          ->when($selectedSession, function ($query) use ($selectedSession) {
            $query->whereHas('academicSession', function ($sessionQuery) use ($selectedSession) {
                $sessionQuery->where('session_name', $selectedSession);
            });
          })
          ->when($selectedStatus, function ($query) use ($selectedStatus) {
              $query->whereHas('feeStatus', function ($statusQuery) use ($selectedStatus) {
                  $statusQuery->where('fee_status_name', $selectedStatus);
              });
          })
          ->orderBy('created_at', 'desc')
          ->paginate(10); // Adjust as needed

      // Fetch filter options
      $feeCategories = FeeCategory::pluck('fee_category_name');
      $years = Year::pluck('year_name');
      $sessions = AcademicSession::pluck('session_name');
      $statuses = FeeStatus::pluck('fee_status_name');

      // Additional calculations for widgets
    $totalFees = $fees->count(); // Total number of fees
    $paidFees = Fee::whereHas('feeStatus', function($query) {
        $query->where('fee_status_name', 'Paid');
    })->count(); // Count of Paid Fees
    $totalCollected = AmountPaid::whereIn('fee_id', $fees->pluck('fee_id'))->sum('amount_paid');
    $outstandingAmount = Fee::sum('amount_balance');

    return view('admin.fees.index', compact(
        'fees',
        'feeCategories',
        'years',
        'sessions',
        'statuses',
        'selectedFeeCategory',
        'selectedYear',
        'selectedSession',
        'selectedStatus',
        'totalFees',
        'paidFees',
        'totalCollected',
        'outstandingAmount'
    ));

      return view('admin.fees.index', compact('fees', 'feeCategories', 'years', 'sessions', 'statuses', 'selectedFeeCategory', 'selectedYear', 'selectedStatus'));
  }

    /**
     * Show the form to create a new fee.
     */
    public function create(Request $request)
    {
        // Fetch all students and related data for the dropdown
        $students = Student::with('faculty', 'semester', 'programme')->get();
        $feeCategories = FeeCategory::all();
        $years = Year::all();
        $sessions = AcademicSession::all();

        // Fetch the ID for the 'Pending' fee status
        $unpaidFeeStatus = FeeStatus::where('fee_status_name', 'Unpaid')->first();
        $unpaidFeeStatusId = $unpaidFeeStatus ? $unpaidFeeStatus->fee_status_id : null;

        // Initialize variables for the selected student's details
        $selectedStudent = null;
        if ($request->has('student_id')) {
            $selectedStudent = Student::with('faculty', 'semester', 'programme')
                ->find($request->input('student_id'));
        }

        return view('admin.fees.add', compact('students', 'feeCategories', 'unpaidFeeStatusId', 'selectedStudent', 'years', 'sessions'));
    }


    // Store new fee in the database
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'fee_category_id' => 'required|exists:fee_category,fee_category_id',
            'description' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after_or_equal:today',
            'year_id' => 'required|exists:year,year_id', // Validate year_id
            'session_id' => 'required|exists:academic_session,session_id' // Validate session_id
        ]);

        Fee::create([
            'student_id' => $request->student_id,
            'fee_category_id' => $request->fee_category_id,
            'description' => $request->description,
            'total_amount' => $request->total_amount,
            'amount_balance' => $request->total_amount, // Set amount_balance equal to total_amount
            'due_date' => $request->due_date,
            'fee_status_id' => FeeStatus::where('fee_status_name', 'Unpaid')->first()->fee_status_id,
            'invoice_num' => uniqid('INV-'),
            'year_id' => $request->year_id, // Save year_id
            'session_id' => $request->session_id, // Save session_id
        ]);

        return redirect()->route('admin.fees.index')->with('success', 'Fee record created successfully.');
    }

    // Show form to edit fee
    public function edit(Fee $fee)
    {
        $students = Student::all();
        $feeCategories = FeeCategory::all();
        $feeStatuses = FeeStatus::all();
        $years = Year::all();
        $sessions = AcademicSession::all();

        // Fetch the IDs for 'Partially Paid' and 'Paid' fee statuses
        $partiallyPaidStatus = FeeStatus::where('fee_status_name', 'Partially Paid')->first();
        $paidStatus = FeeStatus::where('fee_status_name', 'Paid')->first();
        $partiallyPaidStatusId = $partiallyPaidStatus ? $partiallyPaidStatus->fee_status_id : null;
        $paidStatusId = $paidStatus ? $paidStatus->fee_status_id : null;

        return view('admin.fees.edit', compact('fee', 'students', 'feeCategories', 'feeStatuses', 'years', 'partiallyPaidStatusId', 'paidStatusId', 'sessions'));
    }

    // Update fee record in the database
    public function update(Request $request, Fee $fee)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'fee_category_id' => 'required|exists:fee_category,fee_category_id',
            'description' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after_or_equal:today',
            'fee_status_id' => 'required|exists:fee_status,fee_status_id',
            'amount_paid' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($fee) {
                    if ($value > $fee->amount_balance) {
                        $fail('The payment amount exceeds the outstanding balance.');
                    }
                },
            ],
            'year_id' => 'required|exists:year,year_id',
            'session_id' => 'required|exists:academic_session,session_id',
        ]);

        $updatedData = $request->except(['amount_paid']);
        $partiallyPaidStatusId = FeeStatus::where('fee_status_name', 'Partially Paid')->first()->fee_status_id;
        $paidStatusId = FeeStatus::where('fee_status_name', 'Paid')->first()->fee_status_id;

        // If the date_issued is not provided in the form, set it to the current date
        // if (!$request->has('date_issued')) {
        //   $updatedData['date_issued'] = now(); // Set to current date
        // }

        if ($request->has('amount_paid') && $request->amount_paid > 0) {
            $updatedData['amount_balance'] = $fee->amount_balance - $request->amount_paid;

            AmountPaid::create([
                'fee_id' => $fee->fee_id,
                'amount_paid' => $request->amount_paid,
                'date_paid' => now(),
                'payment_method' => 'Counter',
            ]);

            $totalPaid = AmountPaid::where('fee_id', $fee->fee_id)->sum('amount_paid');
            $updatedData['amount_paid'] = $totalPaid;

            if ($totalPaid >= $fee->total_amount) {
                $updatedData['fee_status_id'] = $paidStatusId;
                $updatedData['amount_balance'] = 0;
            } else {
                $updatedData['fee_status_id'] = $partiallyPaidStatusId;
            }
        }

        $fee->update($updatedData);

        return redirect()->route('admin.fees.index')->with('success', 'Fee record updated successfully.');
    }

    // Delete a fee record
    public function destroy(Fee $fee)
    {
        $fee->delete();

        return redirect()->route('admin.fees.index')->with('success', 'Fee record deleted successfully.');
    }

    // Show the form to confirm payment
    public function confirmPayment($feeId)
    {
        $fee = Fee::findOrFail($feeId);

        // Fetch the latest payment if available
        $latestPayment = $fee->amountPaid()->latest('amount_paid_id')->first();

        // Check if there's any outstanding balance
        if ($fee->amount_balance <= 0) {
          $status = FeeStatus::where('fee_status_name', 'Paid')->first()->fee_status_id;
        } else {
            $status = FeeStatus::where('fee_status_name', 'Partially Paid')->first()->fee_status_id;
        }

        $fee->update(['fee_status_id' => $status]);

        return redirect()->route('admin.fees.index')->with('success', 'Payment status updated successfully.');
    }

    // Admin view for student receipts
    public function adminReceipts(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));
        $selectedCategory = $request->input('fee_category', null);

        $payments = AmountPaid::with(['fee', 'fee.year', 'fee.feeCategory'])
            ->whereHas('fee', function ($query) use ($selectedYear, $selectedCategory) {
                $query->whereHas('year', function ($yearQuery) use ($selectedYear) {
                    $yearQuery->where('year_name', $selectedYear);
                });
                if ($selectedCategory) {
                    $query->where('fee_category_id', $selectedCategory);
                }
            })
            ->orderBy('date_paid', 'desc')
            ->paginate(10);

        $years = Year::select('year_name')->distinct()->orderBy('year_name', 'desc')->get();
        $feeCategories = FeeCategory::orderBy('fee_category_name')->get();

        return view('admin.receipts.index', compact('payments', 'years', 'selectedYear', 'feeCategories', 'selectedCategory'));
    }

    // Admin generate receipt
    public function adminGenerateReceipt($paymentId)
    {
        $payment = AmountPaid::with(['fee.feeCategory', 'fee.student', 'fee.year', 'fee.academicSession'])
            ->where('amount_paid_id', $paymentId)
            ->firstOrFail();

        $viewPath = 'admin.receipts.receipt';

        $year = $payment->fee->year->year ?? date('Y');
        $academicSession = $payment->fee->academicSession->session_name ?? 'unknown_session';
        $academicSession = str_replace(['/', '\\'], '_', $academicSession);
        $fileName = "UNISSAReceipt_{$year}_{$academicSession}_{$payment->receipt_num}.pdf";

        $pdf = PDF::loadView($viewPath, compact('payment'));
        return $pdf->stream($fileName);
    }

}
