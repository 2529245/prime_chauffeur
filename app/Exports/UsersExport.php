<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return User::query()
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->get([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.mobile_number',
                'roles.name as role',
                'users.status',
                'users.created_at',
                'users.updated_at',
            ])
            ->map(function ($user) {
                return [
                    $user->id,
                    $user->first_name,
                    $user->last_name,
                    $user->email,
                    $user->mobile_number,
                    $user->role ?? 'Unknown',
                    (int) $user->status === 1 ? 'Active' : 'Inactive',
                    $user->created_at,
                    $user->updated_at,
                ];
            })
            ->toArray();
    }

    public function headings(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
            'mobile_number',
            'role',
            'status',
            'created_at',
            'updated_at',
        ];
    }
}