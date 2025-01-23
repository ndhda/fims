<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeRule;
use App\Models\FeeCategory;
use App\Models\Programme;
use App\Models\Semester;
use Illuminate\Http\Request;

class FeeRulesController extends Controller
{
  public function index($feeCategoryId)
  {
      $category = FeeCategory::findOrFail($feeCategoryId);
      $rules = FeeRule::where('fee_category_id', $feeCategoryId)->get();
      $programmes = Programme::all();
      $semesters = Semester::all();

      return view('admin.fee_rules.index', compact('category', 'rules', 'programmes', 'semesters'));
  }

  public function store(Request $request, $feeCategoryId)
  {
    try{
      $validated = $request->validate([
          'programme_id' => 'nullable|integer|exists:programmes,id',
          'semester_id' => 'nullable|integer|exists:semesters,semester_id',
          'hostel' => 'nullable|in:yes,no',
          'international' => 'nullable|in:yes,no',
          'scholarship' => 'nullable|in:yes,no',
          'amount' => 'required|numeric|min:0',
      ]);

      FeeRule::create([
          'fee_category_id' => $feeCategoryId,
          'programme_id' => $validated['programme_id'] ?? null,
          'semester_id' => $validated['semester_id'] ?? null,
          'hostel' => $validated['hostel'] ?? null,
          'international' => $validated['international'] ?? null,
          'scholarship' => $validated['scholarship'] ?? null,
          'amount' => $validated['amount'],
      ]);
    } catch (\Exception $e) {
      dd($e);
        return back()->with('error', $e->getMessage());
    }

      return redirect()->route('fee-rules.index', $feeCategoryId)->with('success', 'Fee rule added successfully.');
  }

  public function update(Request $request, $ruleId)
  {
      $rule = FeeRule::findOrFail($ruleId);

      try{
      $validated = $request->validate([
          'programme_id' => 'nullable|integer|exists:programmes,id',
          'semester_id' => 'nullable|integer|exists:semesters,semester_id',
          'hostel' => 'nullable|in:yes,no',
          'international' => 'nullable|in:yes,no',
          'scholarship' => 'nullable|in:yes,no',
          'amount' => 'required|numeric|min:0',
      ]);

      $rule->update([
          'programme_id' => $validated['programme_id'] ?? null,
          'semester_id' => $validated['semester_id'] ?? null,
          'hostel' => $validated['hostel'] ?? null,
          'international' => $validated['international'] ?? null,
          'scholarship' => $validated['scholarship'] ?? null,
          'amount' => $validated['amount'],
      ]);
    } catch (\Exception $e) {
      dd($e);
        return back()->with('error', $e->getMessage());
    }

      return back()->with('success', 'Fee rule updated successfully.');
  }

  public function destroy($ruleId)
  {
      $rule = FeeRule::findOrFail($ruleId);
      $rule->delete();

      return back()->with('success', 'Fee rule deleted successfully.');
  }
}
