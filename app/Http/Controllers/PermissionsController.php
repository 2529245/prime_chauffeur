<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:permission-list', ['only' => ['index']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['show', 'edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    // Show all records
    public function index()
    {
        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->paginate(20);

        return view('permissions.index', compact('permissions'));
    }

    // Show create form
    public function create()
    {
        return view('permissions.add');
    }

    // Save new record
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|in:web',
        ]);

        DB::beginTransaction();

        try {
            Permission::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            DB::commit();

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    // Show record details
    public function show($id)
    {
        return redirect()->route('permissions.edit', $id);
    }

    // Show edit form
    public function edit($id)
    {
        $permission = Permission::where('id', $id)
            ->where('guard_name', 'web')
            ->firstOrFail();

        return view('permissions.edit', compact('permission'));
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $permission = Permission::where('id', $id)
            ->where('guard_name', 'web')
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'guard_name' => 'required|in:web',
        ]);

        DB::beginTransaction();

        try {
            $permission->update([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            DB::commit();

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    // Delete selected record
    public function destroy($id)
    {
        $permission = Permission::where('id', $id)
            ->where('guard_name', 'web')
            ->firstOrFail();

        DB::beginTransaction();

        try {
            $permission->roles()->detach();
            $permission->users()->detach();

            $permission->delete();

            DB::commit();

            app(\Spatie\Permission\PermissionRegistrar::class)
                ->forgetCachedPermissions();

            return redirect()
                ->route('permissions.index')
                ->with('success', 'Permission deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->route('permissions.index')
                ->with('error', $th->getMessage());
        }
    }
}