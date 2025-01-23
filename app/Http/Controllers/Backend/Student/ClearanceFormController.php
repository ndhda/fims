<?php

namespace App\Http\Controllers\Backend\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\ClearanceForm;

class ClearanceFormController extends Controller
{
    /**
     * Display the clearance form upload page.
     */
    public function showForm()
    {
        return view('student.clearance_form');
    }

    /**
     * Handle the upload of the clearance form.
     */
    public function uploadForm(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'clearance_form_doc' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('clearance_form_doc')) {
          $file = $request->file('clearance_form_doc');
          $fileName = uniqid() . '_' . time() . '.' . $file->extension();
          $file->move(public_path('uploads/clearance_forms'), $fileName);
          $filePath = 'uploads/clearance_forms/' . $fileName;

        // Save the file path in the database
        ClearanceForm::create([
            'clearance_form_doc' => $filePath,
            'student_id' => Auth::user()->student_id,
        ]);

        return redirect()->route('clearance.form')->with('success', 'Clearance form uploaded successfully.');
        }

        return back()->withErrors(['clearance_form_doc' => 'Failed to upload the file.']);
    }
}
