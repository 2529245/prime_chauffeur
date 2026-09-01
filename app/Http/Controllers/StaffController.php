<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:staff-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:staff-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:staff-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:staff-delete', ['only' => ['destroy']]);
        $this->middleware('permission:staff-document-create', ['only' => ['storeDocument']]);
        $this->middleware('permission:staff-document-view', ['only' => ['viewDocument']]);
        $this->middleware('permission:staff-document-download', ['only' => ['downloadDocument']]);
        $this->middleware('permission:staff-document-delete', ['only' => ['destroyDocument']]);
    }

    // Show all records
    public function index()
    {
        $staff = Staff::with(['documents', 'creator', 'updater'])
            ->orderBy('name')
            ->get();

        return view('staff.index', compact('staff'));
    }

    // Show create form
    public function create()
    {
        return view('staff.create');
    }

    // Save new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'contact_info' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        $validated['created_by'] = auth()->id();

        Staff::create($validated);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    // Show record details
    public function show(Staff $staff)
    {
        $staff->load(['documents', 'creator', 'updater']);

        return view('staff.show', compact('staff'));
    }

    // Show edit form
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    // Update existing record
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'contact_info' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        $validated['updated_by'] = auth()->id();

        $staff->update($validated);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    // Delete selected record
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()
            ->route('staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    // Upload staff document
    public function storeDocument(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:emirates_id,visa,passport,employee_contract,driving_license,other',
            'document_path' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            'expiry_date' => 'required|date',
        ]);

        if ($request->hasFile('document_path')) {
            $file = $request->file('document_path');
            $validated['document_path'] = $file->store('staff-documents');
            $validated['original_filename'] = $file->getClientOriginalName();
        }

        $validated['staff_id'] = $staff->id;
        $validated['created_by'] = auth()->id();

        StaffDocument::create($validated);

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('success', 'Staff document uploaded successfully.');
    }

    // View staff document
    public function viewDocument(Staff $staff, StaffDocument $document)
    {
        if ($document->staff_id !== $staff->id) {
            abort(404);
        }

        if (!Storage::exists($document->document_path)) {
            return back()->with('error', 'File not found.');
        }

        $filePath = Storage::path($document->document_path);
        $mimeType = Storage::mimeType($document->document_path);

        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'])) {
            return response()->file($filePath);
        }

        return Storage::download($document->document_path);
    }

    // Download staff document
    public function downloadDocument(Staff $staff, StaffDocument $document)
    {
        if ($document->staff_id !== $staff->id) {
            abort(404);
        }

        if (!Storage::exists($document->document_path)) {
            return back()->with('error', 'File not found.');
        }

        $originalName = $document->original_filename
            ?? str_replace('_', ' ', $document->document_type) . '.' . pathinfo($document->document_path, PATHINFO_EXTENSION);

        return Storage::download($document->document_path, $originalName);
    }

    // Delete staff document
    public function destroyDocument(Staff $staff, StaffDocument $document)
    {
        if ($document->staff_id !== $staff->id) {
            abort(404);
        }

        if (Storage::exists($document->document_path)) {
            Storage::delete($document->document_path);
        }

        $document->delete();

        return redirect()
            ->route('staff.show', $staff->id)
            ->with('success', 'Staff document deleted successfully.');
    }
}