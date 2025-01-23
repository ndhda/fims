<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClearanceForm;
use ZipArchive;

class AdminClearanceController extends Controller
{
    /**
     * Show the clearance forms page.
     */
    public function index()
    {
        $clearanceForms = ClearanceForm::with('student')->get();
        return view('admin.clearance_form', compact('clearanceForms'));
    }

    /**
     * Handle bulk downloading of clearance forms.
     */
    public function bulkDownload(Request $request)
{
    if (!class_exists('ZipArchive')) {
        return redirect()->back()->with('error', 'ZipArchive is not available. Please enable the PHP Zip extension.');
    }

    $request->validate([
        'clearance_form_ids' => 'required|array',
        'clearance_form_ids.*' => 'exists:clearance_form,clearance_form_id',
    ]);

    $zip = new ZipArchive;
    $zipFileName = 'clearance_forms_' . now()->timestamp . '.zip';
    $zipPath = storage_path('app/public/' . $zipFileName);

    if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
        $clearanceForms = ClearanceForm::whereIn('clearance_form_id', $request->clearance_form_ids)->get();
        foreach ($clearanceForms as $form) {
            $filePath = public_path($form->clearance_form_doc);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, basename($filePath));
            }
        }
        $zip->close();
    } else {
        return redirect()->back()->with('error', 'Unable to create ZIP file.');
    }

    return response()->download($zipPath)->deleteFileAfterSend(true);
}

    /**
     * View a specific clearance form in the browser.
     */
    public function view($id)
    {
        $clearanceForm = ClearanceForm::findOrFail($id);
        $filePath = public_path($clearanceForm->clearance_form_doc);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }
}
