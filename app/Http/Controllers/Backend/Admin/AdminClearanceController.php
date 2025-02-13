<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClearanceForm;
use App\Models\Year;
use App\Models\AcademicSession;
use ZipArchive;

class AdminClearanceController extends Controller
{
    /**
     * Show the clearance forms page.
     */
    public function index(Request $request)
    {
        $years = Year::all();
        $sessions = AcademicSession::all();

        // Get filter values
        $selectedYear = $request->get('year_id');
        $selectedSession = $request->get('session_id');

        // Query clearance forms with optional filtering
        $clearanceForms = ClearanceForm::with('student')
            ->when($selectedYear, function ($query) use ($selectedYear) {
                $query->whereHas('student', function ($studentQuery) use ($selectedYear) {
                    $studentQuery->where('year_id', $selectedYear);
                });
            })
            ->when($selectedSession, function ($query) use ($selectedSession) {
                $query->whereHas('student', function ($studentQuery) use ($selectedSession) {
                    $studentQuery->where('session_id', $selectedSession);
                });
            })
            ->get();

        return view('admin.clearance_form', compact('clearanceForms', 'years', 'sessions', 'selectedYear', 'selectedSession'));
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
