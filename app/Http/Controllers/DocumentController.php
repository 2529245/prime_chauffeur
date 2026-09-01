<?php

namespace App\Http\Controllers;

use App\Models\DriverDocument;
use App\Models\StaffDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

// Set controller permissions
public function __construct()
{
    $this->middleware('auth');
    $this->middleware('permission:driver-document-list', ['only' => ['driverIndex', 'driverShow']]);
    $this->middleware('permission:driver-document-create', ['only' => ['driverCreate', 'driverStore']]);
    $this->middleware('permission:driver-document-edit', ['only' => ['driverEdit', 'driverUpdate']]);
    $this->middleware('permission:driver-document-delete', ['only' => ['driverDestroy']]);
    $this->middleware('permission:driver-document-view', ['only' => ['driverView']]);
    $this->middleware('permission:driver-document-download', ['only' => ['driverDownload']]);
    $this->middleware('permission:staff-document-list', ['only' => ['staffIndex', 'staffShow']]);
    $this->middleware('permission:staff-document-create', ['only' => ['staffCreate', 'staffStore']]);
    $this->middleware('permission:staff-document-edit', ['only' => ['staffEdit', 'staffUpdate']]);
    $this->middleware('permission:staff-document-delete', ['only' => ['staffDestroy']]);
    $this->middleware('permission:staff-document-view', ['only' => ['staffView']]);
    $this->middleware('permission:staff-document-download', ['only' => ['staffDownload']]);
}

    // Show driver documents
    public function driverIndex()
    {
        $documents = DriverDocument::with(['driver', 'creator'])->orderBy('document_type')->get();
        $drivers = \App\Models\Driver::where('status', 'active')->get();

        return view('documents.driver.index', compact('documents', 'drivers'));
    }

    // Show driver document form
    public function driverCreate()
    {
        $drivers = \App\Models\Driver::where('status', 'active')->get();

        return view('documents.driver.create', compact('drivers'));
    }

    // Save driver document
    public function driverStore(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'document_type' => 'required|in:contract,emirates_id,driving_license,passport,rta_card,visa,home_country_id',
            'document_path' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'expiry_date' => 'required|date',
        ]);

        if ($request->hasFile('document_path')) {
            $validated['document_path'] = $request->file('document_path')->store('driver-documents');
        }

        DriverDocument::create($validated);

        return redirect()->route('documents.driver.index')
            ->with('success', 'Driver document uploaded successfully.');
    }

    // Show driver document
    public function driverShow(DriverDocument $document)
    {
        $document->load('driver');

        return view('documents.driver.show', compact('document'));
    }

    // Edit driver document
    public function driverEdit(DriverDocument $document)
    {
        $drivers = \App\Models\Driver::where('status', 'active')->get();
        $document->load('driver');

        return view('documents.driver.edit', compact('document', 'drivers'));
    }

    // Update driver document
    public function driverUpdate(Request $request, DriverDocument $document)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'document_type' => 'required|in:contract,emirates_id,driving_license,passport,rta_card,visa,home_country_id',
            'expiry_date' => 'required|date',
        ]);

        if ($request->hasFile('document_path')) {
            $request->validate([
                'document_path' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            ]);

            if (Storage::exists($document->document_path)) {
                Storage::delete($document->document_path);
            }

            $validated['document_path'] = $request->file('document_path')->store('driver-documents');
        }

        $document->update($validated);

        return redirect()->route('documents.driver.index')
            ->with('success', 'Driver document updated successfully.');
    }

    // View driver document
    public function driverView(DriverDocument $document)
    {
        if (!Storage::exists($document->document_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = Storage::path($document->document_path);
        $mimeType = Storage::mimeType($document->document_path);

        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'])) {
            return response()->file($filePath);
        }

        return Storage::download($document->document_path);
    }

    // Download driver document
    public function driverDownload(DriverDocument $document)
    {
        if (!Storage::exists($document->document_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($document->document_path);
    }

    // Delete driver document
    public function driverDestroy(DriverDocument $document)
    {
        if (Storage::exists($document->document_path)) {
            Storage::delete($document->document_path);
        }

        $document->delete();

        return redirect()->route('documents.driver.index')
            ->with('success', 'Driver document deleted successfully.');
    }

    // Show staff documents
    public function staffIndex()
    {
        $documents = StaffDocument::with(['staff', 'creator'])->orderBy('document_type')->get();
        $staff = \App\Models\Staff::where('status', 'active')->get();

        return view('documents.staff.index', compact('documents', 'staff'));
    }

    // Show staff document form
    public function staffCreate()
    {
        $staff = \App\Models\Staff::where('status', 'active')->get();

        return view('documents.staff.create', compact('staff'));
    }

    // Save staff document
    public function staffStore(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'document_type' => 'required|in:emirates_id,visa,passport,employee_contract',
            'document_path' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'expiry_date' => 'required|date',
        ]);

        if ($request->hasFile('document_path')) {
            $validated['document_path'] = $request->file('document_path')->store('staff-documents');
        }

        StaffDocument::create($validated);

        return redirect()->route('documents.staff.index')
            ->with('success', 'Staff document uploaded successfully.');
    }

    // Show staff document
    public function staffShow(StaffDocument $document)
    {
        $document->load('staff');

        return view('documents.staff.show', compact('document'));
    }

    // Edit staff document
    public function staffEdit(StaffDocument $document)
    {
        $staff = \App\Models\Staff::where('status', 'active')->get();
        $document->load('staff');

        return view('documents.staff.edit', compact('document', 'staff'));
    }

    // Update staff document
    public function staffUpdate(Request $request, StaffDocument $document)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'document_type' => 'required|in:emirates_id,visa,passport,employee_contract',
            'expiry_date' => 'required|date',
        ]);

        if ($request->hasFile('document_path')) {
            $request->validate([
                'document_path' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            ]);

            if (Storage::exists($document->document_path)) {
                Storage::delete($document->document_path);
            }

            $validated['document_path'] = $request->file('document_path')->store('staff-documents');
        }

        $document->update($validated);

        return redirect()->route('documents.staff.index')
            ->with('success', 'Staff document updated successfully.');
    }

    // View staff document
    public function staffView(StaffDocument $document)
    {
        if (!Storage::exists($document->document_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = Storage::path($document->document_path);
        $mimeType = Storage::mimeType($document->document_path);

        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'])) {
            return response()->file($filePath);
        }

        return Storage::download($document->document_path);
    }

    // Download staff document
    public function staffDownload(StaffDocument $document)
    {
        if (!Storage::exists($document->document_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::download($document->document_path);
    }

    // Delete staff document
    public function staffDestroy(StaffDocument $document)
    {
        if (Storage::exists($document->document_path)) {
            Storage::delete($document->document_path);
        }

        $document->delete();

        return redirect()->route('documents.staff.index')
            ->with('success', 'Staff document deleted successfully.');
    }
}