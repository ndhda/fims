<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Fee;
use App\Models\FeeRule;
use App\Models\FeeStatus;
use App\Models\Student;
use App\Models\BulkFeeOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessBulkFees;
use App\Models\AcademicSession;
use App\Models\FeeCategory;
use App\Models\Year;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Programme;
use App\Models\Semester;

class BulkFeeController extends Controller
{
    // Bulk create fees
    public function showBulkCreateForm()
    {
        $years = Year::all();
        $sessions = AcademicSession::all();

        // Fetch rules with relationships and format options
        $rules = FeeRule::with(['feeCategory', 'programme', 'semester'])->get()->map(function ($rule) {
            $rule->formatted_name = "{$rule->feeCategory->fee_category_code}/RC{$rule->rule_id} {$rule->feeCategory->fee_category_name} - {$rule->amount}";
            return $rule;
        });

        return view('admin.fees.bulk-create', compact('years', 'sessions', 'rules'));
    }

    public function bulkCreate(Request $request)
    {
        $validated = $request->validate([
            'year_id' => 'required|exists:year,year_id',
            'session_id' => 'required|exists:academic_session,session_id',
            'rule_id' => 'required|exists:fee_rules,rule_id',
        ]);

        $rule = FeeRule::findOrFail($validated['rule_id']);

        // Retrieve students matching the fee rule
        $students = Student::query()
            ->whereHas('programme', function ($query) use ($rule) {
                if ($rule->programme_id) {
                    $query->where('programme_id', $rule->programme_id);
                }
            })
            ->whereHas('semester', function ($query) use ($rule) {
                if ($rule->semester_id) {
                    $query->where('semester_id', $rule->semester_id);
                }
            })
            ->when($rule->hostel, fn($query) => $query->where('hostel', $rule->hostel))
            ->when($rule->international, fn($query) => $query->where('international', $rule->international))
            ->when($rule->scholarship, fn($query) => $query->where('scholarship', $rule->scholarship))
            ->get();

            $rules = FeeRule::with(['feeCategory', 'programme', 'semester'])->get()->map(function ($rule) {
              $rule->formatted_name = "{$rule->feeCategory->fee_category_code}/RC{$rule->rule_id} {$rule->feeCategory->fee_category_name} - {$rule->amount}";
              return $rule;
          });

          return view('admin.fees.bulk-create', [
              'students' => $students,
              'rule' => $rule,
              'years' => Year::all(),
              'sessions' => AcademicSession::all(),
              'rules' => $rules,
              'selectedYear' => $validated['year_id'],
              'selectedSession' => $validated['session_id'],
              'selectedRule' => $validated['rule_id'],
              'validatedYearId' => $request->year_id,
              'validatedSessionId' => $request->session_id,
              ]);
    }

    public function createBulkFeeRecords(Request $request)
    {
      try{
        $validated = $request->validate([
          'year_id' => 'required|exists:year,year_id',
          'session_id' => 'required|exists:academic_session,session_id',
          'students' => 'required|array',
          'students.*' => 'exists:students,student_id',
          'description' => 'required|string',
          'due_date' => 'required|date|after_or_equal:today',
          'rule_id' => 'required|integer|exists:fee_rules,rule_id',
        ]);

        $rule = FeeRule::findOrFail($validated['rule_id']);
        $students = Student::whereIn('student_id', $validated['students'])->get();

        foreach ($students as $student) {
          Fee::create([
              'invoice_num' => uniqid('INV-'), // Generate a unique invoice number
              'fee_category_id' => $rule->fee_category_id,
              'student_id' => $student->student_id,
              'description' => $validated['description'],
              'total_amount' => $rule->amount,
              'due_date' => $validated['due_date'],
              'amount_balance' => $rule->amount,
              'fee_status_id' => 1, // 'Unpaid'
              'issued_date' => now(),
              'year_id' => $validated['year_id'], // Ensure year_id is passed and validated
              'session_id' => $validated['session_id'], // Ensure session_id is passed and validated
          ]);
      }
     } catch (\Exception $e) {
      dd($e);
      }

        return redirect()->route('admin.fees.index')->with('success', 'Bulk fee records created successfully.');
    }

}
