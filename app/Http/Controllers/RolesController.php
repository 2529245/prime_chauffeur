<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['show', 'edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    // Show all records
    public function index()
    {
        $roles = Role::where('guard_name', 'web')->paginate(10);

        return view('roles.index', compact('roles'));
    }

    // Show create form
    public function create()
    {
        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('roles.add', compact('permissions'));
    }

    // Save new record
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|in:web',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            $permissions = Permission::whereIn(
                'id',
                $request->input('permissions', [])
            )->where('guard_name', 'web')->get();

            $role->syncPermissions($permissions);

            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role created successfully.');
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
        return redirect()->route('roles.edit', $id);
    }

    // Show edit form
    public function edit($id)
    {
        $role = Role::where('id', $id)
            ->where('guard_name', 'web')
            ->with('permissions')
            ->firstOrFail();

        $permissions = Permission::where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('roles.edit', compact('role', 'permissions'));
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $role = Role::where('id', $id)
            ->where('guard_name', 'web')
            ->firstOrFail();

        if ($role->name === 'Super Admin') {
            return redirect()
                ->route('roles.index')
                ->with('error', 'The Super Admin role cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'guard_name' => 'required|in:web',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();

        try {
            $role->update([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            $permissions = Permission::whereIn(
                'id',
                $request->input('permissions', [])
            )->where('guard_name', 'web')->get();

            $role->syncPermissions($permissions);

            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role and permissions updated successfully.');
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
        $role = Role::where('id', $id)
            ->where('guard_name', 'web')
            ->firstOrFail();

        if ($role->name === 'Super Admin') {
            return redirect()
                ->route('roles.index')
                ->with('error', 'The Super Admin role cannot be deleted.');
        }

        DB::beginTransaction();

        try {
            $role->syncPermissions([]);
            $role->delete();

            DB::commit();

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->route('roles.index')
                ->with('error', $th->getMessage());
        }
    }
}