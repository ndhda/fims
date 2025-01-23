<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Fee;
use App\Models\AmountPaid;
use App\Models\Year;
use App\Models\FeeCategory;
use App\Models\AcademicSession;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated student's ID
        $studentId = Auth::user()->student_id;

        // Get the selected year (or default to the current year)
        $selectedYear = $request->input('year', date('Y'));

        // Fetch all payments made by the student for the selected year (both sessions)
        $payments = AmountPaid::with(['fee', 'fee.year', 'fee.feeCategory'])
            ->whereHas('fee', function ($query) use ($studentId, $selectedYear) {
                $query->where('student_id', $studentId)
                      ->whereHas('year', function ($yearQuery) use ($selectedYear) {
                          $yearQuery->where('year_name', $selectedYear); // Match selected year
                      });
            })
            ->orderBy('date_paid', 'desc')
            ->get();

        // Fetch all available years for the dropdown (grouped by year_name)
        $years = Year::select('year_name')
                    ->distinct()
                    ->orderBy('year_name', 'desc')
                    ->get();

        return view('student.receipts.index', compact('payments', 'years', 'selectedYear'));
    }

    // Generate a specific receipt
    public function generateReceipt($paymentId)
    {
        if (Auth::user()->role_id == 2) {
          $payment = AmountPaid::with(['fee.feeCategory', 'fee.student', 'fee.year', 'fee.academicSession'])
                ->where('amount_paid_id', $paymentId)
                ->firstOrFail();

            $viewPath = 'admin.receipts.receipt';
        } else {
            $studentId = Auth::user()->student_id;

            $payment = AmountPaid::with(['fee.feeCategory', 'fee.student', 'fee.year', 'fee.academicSession'])
                ->where('amount_paid_id', $paymentId)
                ->whereHas('fee', function ($query) use ($studentId) {
                    $query->where('student_id', $studentId);
                })
                ->firstOrFail();

            $viewPath = 'student.receipts.receipt';
        }

        // Prepare the file name with sanitized values
        $year = $payment->fee->year->year ?? date('Y');
        $academicSession = $payment->fee->academicSession->session_name ?? 'unknown_session';
        $academicSession = str_replace(['/', '\\'], '_', $academicSession);
        $fileName = "UNISSAReceipt_{$year}_{$academicSession}.pdf";

        $pdf = PDF::loadView($viewPath, compact('payment'));
        return $pdf->stream($fileName);
    }

    // Admin view for student receipts
    // For Admin - Display Receipts for All Students Based on Year and Fee Category
    public function adminIndex(Request $request)
    {
        // Get the selected year and fee category (defaults to current year and all categories)
        $selectedYear = $request->input('year', date('Y'));
        $selectedCategory = $request->input('fee_category', null); // Null will show all categories

        // Fetch all payments made by students for the selected year and fee category
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

        // Fetch all available years for the dropdown (grouped by year_name)
        $years = Year::select('year_name')
            ->distinct()
            ->orderBy('year_name', 'desc')
            ->get();

        // Fetch all available fee categories for the dropdown
        $feeCategories = FeeCategory::orderBy('fee_category_name')->get();

        return view('admin.receipts.index', compact('payments', 'years', 'selectedYear', 'feeCategories', 'selectedCategory'));
    }

    public function storePayment(Request $request)
    {
        $validatedData = $request->validate([
            'amount_paid' => 'required|numeric',
            'fee_id' => 'required|exists:fee,fee_id',
            'date_paid' => 'required|date',
            'payment_method' => 'required|string',
            'reference_num' => 'nullable|string',
            'payment_proof' => 'nullable|file',
        ]);

        // Fetch the fee record with year and academic session relationships
        $fee = Fee::with(['year', 'academicSession'])->findOrFail($validatedData['fee_id']);

        // Extract year and academic session from related tables
        $year = $fee->year->year ?? date('Y');
        $academicSession = $fee->academicSession->session_name ?? 'unknown_session';

        // Sanitize the academic session to avoid invalid characters
        $academicSession = str_replace(['/', '\\'], '_', $academicSession);

        // Generate a unique receipt number
        $uniqueNumber = str_pad(AmountPaid::max('amount_paid_id') + 1, 6, '0', STR_PAD_LEFT);
        $receiptNumber = "CUST.IN/{$year}/{$uniqueNumber}";

        // Save the payment
        $amountPaid = new AmountPaid();
        $amountPaid->fill($validatedData);
        $amountPaid->receipt_num = $receiptNumber; // Save the receipt number in the database
        $amountPaid->save();

        return redirect()->route('fees.index')->with('success', 'Payment successfully recorded with Receipt No: ' . $receiptNumber);
    }

}
