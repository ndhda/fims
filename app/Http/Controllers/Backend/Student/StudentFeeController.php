<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Str;
use App\Models\Fee;
use App\Models\FeeStatus;
use App\Models\AmountPaid;
use App\Models\Year;

class StudentFeeController extends Controller
{
    /**
     * Show the list of fees for the authenticated student.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve the student ID of the logged-in user
        $studentId = Auth::user()->student_id;

        // Get all fees for the student
        $fees = Fee::where('student_id', $studentId)
            ->with(['feeStatus'])
            ->get();

        // Calculate total fees and outstanding balance
        $totalFees = $fees->sum('total_amount');
        $outstandingAmount = $fees->sum('amount_balance');

        return view('student.fees.index', compact('fees', 'totalFees', 'outstandingAmount'));
    }

    /**
     * Show the form to upload proof of payment for a fee.
     *
     * @param  int  $feeId
     * @return \Illuminate\View\View
     */
    public function uploadPaymentProof($feeId)
    {
        // Retrieve the fee details by fee_id
        $fee = Fee::findOrFail($feeId);

        return view('student.fees.upload', compact('fee'));
    }

    /**
     * Handle the payment proof upload for a fee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $feeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePaymentProof(Request $request, $feeId)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:1',
            'date_paid' => 'required|date',
            'reference_num' => 'required|string|max:255',
            'payment_method' => 'required|in:Online Payment (BIBD),Counter',
            'payment_proof' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $fee = Fee::findOrFail($feeId);

        // Check if the payment exceeds the balance
        if ($request->input('amount_paid') > $fee->amount_balance) {
            return redirect()->back()->with('error', 'Payment exceeds the outstanding balance.');
        }

        $amountPaid = new AmountPaid();
        $amountPaid->fee_id = $feeId;
        $amountPaid->amount_paid = $request->input('amount_paid');
        $amountPaid->date_paid = $request->input('date_paid');
        $amountPaid->reference_num = $request->input('reference_num');
        $amountPaid->payment_method = $request->input('payment_method');

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = rand(111, 999) . time() . '.' . $file->extension();
            $file->move(public_path('uploads/payment_proofs'), $fileName);
            $amountPaid->payment_proof = 'uploads/payment_proofs/' . $fileName;
        }

        $amountPaid->save();

        // Update fee balance
        $fee->amount_balance -= $request->input('amount_paid');
        $fee->save();

        // Update status to 'Pending'
        $pendingStatus = FeeStatus::where('fee_status_name', 'Pending')->first();
        $fee->fee_status_id = $pendingStatus->fee_status_id;
        $fee->save();

        return redirect()->route('fees.index')->with('success', 'Payment proof uploaded successfully. Awaiting admin confirmation.');
    }

    // Student view for receipts
    public function studentReceipts(Request $request)
    {
        $studentId = Auth::user()->student_id;
        $selectedYear = $request->input('year', date('Y'));

        $payments = AmountPaid::with(['fee', 'fee.year', 'fee.feeCategory'])
            ->whereHas('fee', function ($query) use ($studentId, $selectedYear) {
                $query->where('student_id', $studentId)
                      ->whereHas('year', function ($yearQuery) use ($selectedYear) {
                          $yearQuery->where('year_name', $selectedYear);
                      });
            })
            ->orderBy('date_paid', 'desc')
            ->get();

        $years = Year::select('year_name')->distinct()->orderBy('year_name', 'desc')->get();

        return view('student.receipts.index', compact('payments', 'years', 'selectedYear'));
    }

    // Student generate receipt
    public function studentGenerateReceipt($paymentId)
    {
        $studentId = Auth::user()->student_id;

        $payment = AmountPaid::with(['fee.feeCategory', 'fee.student', 'fee.year', 'fee.academicSession'])
            ->where('amount_paid_id', $paymentId)
            ->whereHas('fee', function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            })
            ->firstOrFail();

        $viewPath = 'student.receipts.receipt';

        $year = $payment->fee->year->year ?? date('Y');
        $academicSession = $payment->fee->academicSession->session_name ?? 'unknown_session';
        $academicSession = str_replace(['/', '\\'], '_', $academicSession);
        $fileName = "UNISSAReceipt_{$year}_{$academicSession}_{$payment->receipt_num}.pdf";

        $pdf = PDF::loadView($viewPath, compact('payment'));
        return $pdf->stream($fileName);
    }

}
