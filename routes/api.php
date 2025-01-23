<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Student;
use App\Http\Controllers\Backend\Admin\FeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/students/{matric_num}', function ($matric_num) {
  $student = Student::with(['faculty', 'programme', 'semester'])
      ->where('matric_num', $matric_num)
      ->first();

  return $student ? $student->toArray() : null;
});

Route::get('/fee-rule-details/{ruleId}', [FeeController::class, 'getFeeRuleDetails']);
