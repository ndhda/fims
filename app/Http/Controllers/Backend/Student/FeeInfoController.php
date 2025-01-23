<?php

namespace App\Http\Controllers\Backend\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeeInfoController extends Controller
{
    /**
     * Show the fee information form.
     */
    public function index()
    {
        return view('student.fees.info');
    }
   /**
     * Show the payment instructions based on the selected payment method.
     */
    public function showPaymentInstructions(Request $request)
    {
        // Store the selected payment method in session
        $paymentMethod = $request->input('payment_method');
        session(['payment_method' => $paymentMethod]);

        // Return the view
        return view('student.fees.info');
    }
}
