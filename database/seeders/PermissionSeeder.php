<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define system permissions
        $permissions = [
            'dashboard-view',

            'booking-list',
            'booking-create',
            'booking-edit',
            'booking-delete',
            'booking-status-update',
            'booking-today',
            'booking-tomorrow',
            'booking-pdf-download',
            'booking-pdf-view',
            'booking-export',

            'vehicle-list',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-export',

            'driver-list',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-export',

            'driver-document-list',
            'driver-document-create',
            'driver-document-edit',
            'driver-document-delete',
            'driver-document-view',
            'driver-document-download',

            'staff-list',
            'staff-create',
            'staff-edit',
            'staff-delete',

            'staff-document-create',
            'staff-document-edit',
            'staff-document-delete',
            'staff-document-view',
            'staff-document-download',
            'staff-document-list',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-export',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',

            'pos-machine-list',
            'pos-machine-create',
            'pos-machine-edit',
            'pos-machine-delete',

            'mobile-phone-list',
            'mobile-phone-create',
            'mobile-phone-edit',
            'mobile-phone-delete',

            'sim-card-list',
            'sim-card-create',
            'sim-card-edit',
            'sim-card-delete',

            'asset-assign',
            'asset-return',
        ];

        // Create missing permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Get all permission IDs
        $permissionIds = Permission::pluck('id')->toArray();

        // Give admin all permissions
        $role = Role::find(1);

        if ($role) {
            $role->syncPermissions($permissionIds);

            // Assign admin role to user
            $user = User::where('role_id', 1)->first();

            if ($user) {
                $user->assignRole($role);
            }
        }
    }
}