<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Set controller permissions
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update', 'updateStatus']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
        $this->middleware('permission:user-export', ['only' => ['export']]);
    }

    // Show all records
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('users.index', ['users' => $users]);
    }

    // Show create form
    public function create()
    {
        $roles = Role::all();

        return view('users.add', ['roles' => $roles]);
    }

    // Save new record
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'email' => 'required|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();

        try {
            $plainPassword = Str::random(12);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'role_id' => $request->role_id,
                'status' => $request->status,
                'password' => Hash::make($plainPassword),
            ]);

            $role = Role::findOrFail($request->role_id);

            $user->assignRole($role);

            DB::commit();

            $emailContent = "Hello " . $user->first_name . " " . $user->last_name . ",\n\n";
            $emailContent .= "Your email has been registered on Prime Chauffeur CRM.\n\n";
            $emailContent .= "URL: http://localhost:8000/login\n";
            $emailContent .= "Username: " . $user->email . "\n";
            $emailContent .= "Password: {$plainPassword}\n\n";
            $emailContent .= "Note:\n";
            $emailContent .= "For password reset, there are two methods. After logging in, you'll find the option to reset your password in the top right corner of the dashboard. You can click on your name and access profile settings to initiate the reset. Alternatively, use the 'Forgot Password' link on the login page. Input your email and receive a reset link via email. Follow the link to reset your password.\n\n";
            $emailContent .= "Thank you for joining us!\n\n";
            $emailContent .= "Best regards,\n";
            $emailContent .= "Prime Chauffeur";

            Mail::raw($emailContent, function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Welcome to Prime Chauffeur CRM');
            });

            return redirect()
                ->route('users.index')
                ->with('success', 'User creation successful! Login details sent to user email.');

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    // Update record status
    public function updateStatus($user_id, $status)
    {
        $validate = Validator::make([
            'user_id' => $user_id,
            'status' => $status,
        ], [
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1',
        ]);

        if ($validate->fails()) {
            return redirect()
                ->route('users.index')
                ->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            User::whereId($user_id)->update([
                'status' => $status,
            ]);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User Status Updated Successfully!');

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    // Show edit form
    public function edit($user)
    {
        $roles = Role::all();
        $user = User::where('id', $user)->firstOrFail();

        return view('users.edit')->with([
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    // Update existing record
    public function update(Request $request, $user)
    {
        $request->validate([
            'first_name' => 'required',
            'email' => 'required|unique:users,email,' . $user . ',id',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();

        try {
            User::whereId($user)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'role_id' => $request->role_id,
                'status' => $request->status,
            ]);

            $userModel = User::findOrFail($user);
            $role = Role::findOrFail($request->role_id);

            $userModel->syncRoles([$role]);

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User Updated Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $th->getMessage());
        }
    }

    // Delete selected user
    public function delete($user)
    {
        DB::beginTransaction();

        try {
            User::whereId($user)->delete();

            DB::commit();

            return redirect()
                ->route('users.index')
                ->with('success', 'User Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    // Export records
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}