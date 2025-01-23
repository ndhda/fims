<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeeCategory;

class FeeCategoryController extends Controller
{
  public function index()
  {
      $categories = FeeCategory::all();
      return view('admin.fee_categories.index', compact('categories'));
  }

  public function store(Request $request)
  {
      $validated = $request->validate([
          'fee_category_name' => 'required|string|max:255|unique:fee_category,fee_category_name',
          'fee_category_code' => 'required|string|max:255|unique:fee_category,fee_category_code',
      ]);

      FeeCategory::create($validated);
      return redirect()->route('fee-categories.index')->with('success', 'Fee category added successfully.');
  }

  public function update(Request $request, $id)
  {
      $category = FeeCategory::findOrFail($id);

      $validated = $request->validate([
          'fee_category_name' => 'required|string|max:255|unique:fee_category,fee_category_name,' . $id . ',fee_category_id',
          'fee_category_code' => 'required|string|max:255|unique:fee_category,fee_category_code,' . $id . ',fee_category_id',
      ]);

      $category->update($validated);
      return redirect()->route('fee-categories.index')->with('success', 'Fee category updated successfully.');
  }

  public function destroy($id)
  {
      $category = FeeCategory::findOrFail($id);
      $category->delete();

      return redirect()->route('fee-categories.index')->with('success', 'Fee category deleted successfully.');
  }
}
