@extends('layouts.app')

@section('title', 'Create New Role')
@section('header', 'Create New Role')

@section('content')

<div class="roles-container">

    {{-- Page header --}}
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title">
                <i class="fas fa-user-shield"></i>
                Create New Role
            </h1>

            <div class="header-actions">

                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i>
                    All Roles
                </a>

            </div>

        </div>

    </div>


    {{-- Show alert messages --}}
    @include('common.alert')


    {{-- Role form --}}
    <div class="row justify-content-center">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <form action="{{ route('roles.store') }}" method="POST">

                        @csrf


                        {{-- Role name --}}

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group" style="margin-bottom:20px;">

                                    <label for="name">
                                        Role Name *
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Enter role name"
                                        required
                                    >

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- Hidden guard name --}}
                        <input
                            type="hidden"
                            name="guard_name"
                            value="web"
                        >


                        {{-- Assign permissions --}}

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group" style="margin-bottom:20px;">

                                    <label>
                                        Assign Permissions
                                    </label>


                                    {{-- Select all permissions --}}
                                    <div
                                        class="select-all-box"
                                        style="margin-bottom:20px;"
                                    >

                                        <label
                                            for="checkAllPermissions"
                                            class="select-all-label"
                                        >

                                            <input
                                                type="checkbox"
                                                id="checkAllPermissions"
                                            >

                                            <strong>
                                                Select All Permissions
                                            </strong>

                                        </label>

                                    </div>


                                    {{-- Dashboard permissions --}}

                                    <div
                                        class="permission-module"
                                        data-module="dashboard"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-tachometer-alt"></i>
                                                Dashboard
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="dashboard"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'dashboard') !== false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-dashboard"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- Booking permissions --}}

                                    <div
                                        class="permission-module"
                                        data-module="booking"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-calendar-check"></i>
                                                Booking
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="booking"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'booking') !== false &&
                                                    stripos($permission->name, 'driver') === false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-booking"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- Driver permissions --}}

                                    <div
                                        class="permission-module"
                                        data-module="driver"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-id-card"></i>
                                                Driver
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="driver"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'driver') !== false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-driver"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- Asset permissions --}}

                                    <div
                                        class="permission-module"
                                        data-module="asset-assignment"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-boxes"></i>
                                                Asset Assignment
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="asset-assignment"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>


                                        {{-- POS machine permissions --}}
                                        <div
                                            class="sub-module"
                                            data-module="pos-machine"
                                        >

                                            <div class="sub-module-header">

                                                <div class="sub-module-heading">
                                                    <i class="fas fa-credit-card"></i>
                                                    POS Machine
                                                </div>

                                                <label class="sub-module-select-all">

                                                    <input
                                                        type="checkbox"
                                                        class="sub-module-check-all"
                                                        data-module="pos-machine"
                                                    >

                                                    <span>
                                                        Select All
                                                    </span>

                                                </label>

                                            </div>

                                            <div class="permissions-grid">

                                                @foreach ($permissions as $permission)

                                                    @if (
                                                        (
                                                            stripos($permission->name, 'pos') !== false ||
                                                            (
                                                                stripos($permission->name, 'machine') !== false &&
                                                                stripos($permission->name, 'sim') === false
                                                            )
                                                        ) &&
                                                        !in_array(strtolower($permission->name), [
                                                            'permission-create',
                                                            'permission-delete',
                                                            'permission-edit',
                                                            'permission-list'
                                                        ])
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input sub-module-pos-machine asset-assignment-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                                >

                                                                <label
                                                                    class="form-check-label"
                                                                    for="permission_{{ $permission->id }}"
                                                                >
                                                                    {{ $permission->name }}
                                                                </label>

                                                            </div>

                                                        </div>

                                                    @endif

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- SIM card permissions --}}
                                        <div
                                            class="sub-module"
                                            data-module="sim-card"
                                        >

                                            <div class="sub-module-header">

                                                <div class="sub-module-heading">
                                                    <i class="fas fa-sim-card"></i>
                                                    SIM Card
                                                </div>

                                                <label class="sub-module-select-all">

                                                    <input
                                                        type="checkbox"
                                                        class="sub-module-check-all"
                                                        data-module="sim-card"
                                                    >

                                                    <span>
                                                        Select All
                                                    </span>

                                                </label>

                                            </div>

                                            <div class="permissions-grid">

                                                @foreach ($permissions as $permission)

                                                    @if (
                                                        stripos($permission->name, 'sim') !== false &&
                                                        !in_array(strtolower($permission->name), [
                                                            'permission-create',
                                                            'permission-delete',
                                                            'permission-edit',
                                                            'permission-list'
                                                        ])
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input sub-module-sim-card asset-assignment-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                                >

                                                                <label
                                                                    class="form-check-label"
                                                                    for="permission_{{ $permission->id }}"
                                                                >
                                                                    {{ $permission->name }}
                                                                </label>

                                                            </div>

                                                        </div>

                                                    @endif

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- Mobile phone permissions --}}
                                        <div
                                            class="sub-module"
                                            data-module="mobile-phone"
                                        >

                                            <div class="sub-module-header">

                                                <div class="sub-module-heading">
                                                    <i class="fas fa-mobile-alt"></i>
                                                    Mobile Phone
                                                </div>

                                                <label class="sub-module-select-all">

                                                    <input
                                                        type="checkbox"
                                                        class="sub-module-check-all"
                                                        data-module="mobile-phone"
                                                    >

                                                    <span>
                                                        Select All
                                                    </span>

                                                </label>

                                            </div>

                                            <div class="permissions-grid">

                                                @foreach ($permissions as $permission)

                                                    @if (
                                                        (
                                                            stripos($permission->name, 'mobile') !== false ||
                                                            stripos($permission->name, 'phone') !== false
                                                        ) &&
                                                        !in_array(strtolower($permission->name), [
                                                            'permission-create',
                                                            'permission-delete',
                                                            'permission-edit',
                                                            'permission-list'
                                                        ])
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input sub-module-mobile-phone asset-assignment-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                                >

                                                                <label
                                                                    class="form-check-label"
                                                                    for="permission_{{ $permission->id }}"
                                                                >
                                                                    {{ $permission->name }}
                                                                </label>

                                                            </div>

                                                        </div>

                                                    @endif

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- Asset assign permissions --}}
                                        <div
                                            class="sub-module"
                                            data-module="asset-assign"
                                        >

                                            <div class="sub-module-header">

                                                <div class="sub-module-heading">
                                                    <i class="fas fa-hand-holding"></i>
                                                    Asset Assign
                                                </div>

                                                <label class="sub-module-select-all">

                                                    <input
                                                        type="checkbox"
                                                        class="sub-module-check-all"
                                                        data-module="asset-assign"
                                                    >

                                                    <span>
                                                        Select All
                                                    </span>

                                                </label>

                                            </div>

                                            <div class="permissions-grid">

                                                @foreach ($permissions as $permission)

                                                    @if (
                                                        (
                                                            (
                                                                stripos($permission->name, 'asset') !== false &&
                                                                stripos($permission->name, 'assign') !== false
                                                            ) ||
                                                            stripos($permission->name, 'asset_assign') !== false ||
                                                            stripos($permission->name, 'asset assignment') !== false
                                                        ) &&
                                                        !in_array(strtolower($permission->name), [
                                                            'permission-create',
                                                            'permission-delete',
                                                            'permission-edit',
                                                            'permission-list'
                                                        ])
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input sub-module-asset-assign asset-assignment-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                                >

                                                                <label
                                                                    class="form-check-label"
                                                                    for="permission_{{ $permission->id }}"
                                                                >
                                                                    {{ $permission->name }}
                                                                </label>

                                                            </div>

                                                        </div>

                                                    @endif

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- Asset return permissions --}}
                                        <div
                                            class="sub-module"
                                            data-module="asset-return"
                                        >

                                            <div class="sub-module-header">

                                                <div class="sub-module-heading">
                                                    <i class="fas fa-undo"></i>
                                                    Asset Return
                                                </div>

                                                <label class="sub-module-select-all">

                                                    <input
                                                        type="checkbox"
                                                        class="sub-module-check-all"
                                                        data-module="asset-return"
                                                    >

                                                    <span>
                                                        Select All
                                                    </span>

                                                </label>

                                            </div>

                                            <div class="permissions-grid">

                                                @foreach ($permissions as $permission)

                                                    @if (
                                                        (
                                                            (
                                                                stripos($permission->name, 'asset') !== false &&
                                                                stripos($permission->name, 'return') !== false
                                                            ) ||
                                                            stripos($permission->name, 'asset_return') !== false ||
                                                            stripos($permission->name, 'asset return') !== false
                                                        ) &&
                                                        !in_array(strtolower($permission->name), [
                                                            'permission-create',
                                                            'permission-delete',
                                                            'permission-edit',
                                                            'permission-list'
                                                        ])
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input sub-module-asset-return asset-assignment-input"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                                >

                                                                <label
                                                                    class="form-check-label"
                                                                    for="permission_{{ $permission->id }}"
                                                                >
                                                                    {{ $permission->name }}
                                                                </label>

                                                            </div>

                                                        </div>

                                                    @endif

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>


                                    {{-- Vehicle permissions --}}

                                    <div
                                        class="permission-module"
                                        data-module="vehicle"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-car"></i>
                                                Vehicle
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="vehicle"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'vehicle') !== false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-vehicle"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- Staff permissions --}}

                                    <div
                                        class="permission-module"
                                        data-module="staff"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-users"></i>
                                                Staff
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="staff"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'staff') !== false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-staff"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- USERS --}}

                                    <div
                                        class="permission-module"
                                        data-module="users"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-user"></i>
                                                Users
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="users"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'user') !== false &&
                                                    stripos($permission->name, 'role') === false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-users"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- ROLES --}}

                                    <div
                                        class="permission-module"
                                        data-module="roles"
                                    >

                                        <div class="module-heading">

                                            <div class="module-title">
                                                <i class="fas fa-user-shield"></i>
                                                Roles
                                            </div>

                                            <label class="module-select-all">

                                                <input
                                                    type="checkbox"
                                                    class="module-check-all"
                                                    data-module="roles"
                                                >

                                                <span>
                                                    Select All
                                                </span>

                                            </label>

                                        </div>

                                        <div class="permissions-grid">

                                            @foreach ($permissions as $permission)

                                                @if (
                                                    stripos($permission->name, 'role') !== false &&
                                                    !in_array(strtolower($permission->name), [
                                                        'permission-create',
                                                        'permission-delete',
                                                        'permission-edit',
                                                        'permission-list'
                                                    ])
                                                )

                                                    <div class="permission-item">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input permission-input module-roles"
                                                                type="checkbox"
                                                                name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                                            >

                                                            <label
                                                                class="form-check-label"
                                                                for="permission_{{ $permission->id }}"
                                                            >
                                                                {{ $permission->name }}
                                                            </label>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- Permission Errors --}}
                                    @error('permissions')

                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                    @error('permissions.*')

                                        <div class="text-danger mt-2">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- Role actions --}}

                        <div
                            class="form-actions"
                            style="margin-top:30px;"
                        >

                            <div
                                class="d-flex justify-content-end align-items-center"
                            >

                                <a
                                    href="{{ route('roles.index') }}"
                                    class="btn btn-secondary"
                                    style="margin-right:15px; text-align:center; min-width:120px;"
                                >
                                    Cancel
                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    style="min-width:120px;"
                                >
                                    <i class="fas fa-save"></i>
                                    Create Role
                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- SELECT ALL JAVASCRIPT --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const globalSelectAll =
        document.getElementById('checkAllPermissions');


    /* Helper: Update Checkbox State */

    function updateCheckboxState(selectAll, permissions) {

        if (!selectAll) {
            return;
        }

        const total = permissions.length;

        const checked =
            Array.from(permissions).filter(function (permission) {
                return permission.checked;
            }).length;


        if (total === 0) {

            selectAll.checked = false;
            selectAll.indeterminate = false;

            return;
        }


        if (checked === 0) {

            selectAll.checked = false;
            selectAll.indeterminate = false;

        } else if (checked === total) {

            selectAll.checked = true;
            selectAll.indeterminate = false;

        } else {

            selectAll.checked = false;
            selectAll.indeterminate = true;

        }

    }


    /* Select all permissions */

    if (globalSelectAll) {

        globalSelectAll.addEventListener('change', function () {

            const permissions =
                document.querySelectorAll('.permission-input');

            permissions.forEach(function (permission) {

                permission.checked =
                    globalSelectAll.checked;

            });


            /* Update all module checkboxes */

            document
                .querySelectorAll('.module-check-all')
                .forEach(function (checkbox) {

                    checkbox.checked =
                        globalSelectAll.checked;

                    checkbox.indeterminate = false;

                });


            /* Update all sub module checkboxes */

            document
                .querySelectorAll('.sub-module-check-all')
                .forEach(function (checkbox) {

                    checkbox.checked =
                        globalSelectAll.checked;

                    checkbox.indeterminate = false;

                });

        });

    }


    /* Module Select All */

    document
        .querySelectorAll('.module-check-all')
        .forEach(function (moduleCheckbox) {

            moduleCheckbox.addEventListener('change', function () {

                const moduleName =
                    moduleCheckbox.dataset.module;

                const module =
                    document.querySelector(
                        '.permission-module[data-module="' +
                        moduleName +
                        '"]'
                    );


                if (!module) {
                    return;
                }


                const permissions =
                    module.querySelectorAll(
                        '.permission-input'
                    );


                permissions.forEach(function (permission) {

                    permission.checked =
                        moduleCheckbox.checked;

                });


                module
                    .querySelectorAll('.sub-module-check-all')
                    .forEach(function (subCheckbox) {

                        subCheckbox.checked =
                            moduleCheckbox.checked;

                        subCheckbox.indeterminate = false;

                    });


                updateGlobalSelectAll();

            });

        });


    /* Sub Module Select All */

    document
        .querySelectorAll('.sub-module-check-all')
        .forEach(function (subModuleCheckbox) {

            subModuleCheckbox.addEventListener(
                'change',
                function () {

                    const moduleName =
                        subModuleCheckbox.dataset.module;

                    const subModule =
                        document.querySelector(
                            '.sub-module[data-module="' +
                            moduleName +
                            '"]'
                        );


                    if (!subModule) {
                        return;
                    }


                    const permissions =
                        subModule.querySelectorAll(
                            '.permission-input'
                        );


                    permissions.forEach(function (permission) {

                        permission.checked =
                            subModuleCheckbox.checked;

                    });


                    updateSubModuleCheckbox(
                        subModule,
                        subModuleCheckbox
                    );


                    updateAssetAssignmentCheckbox();

                    updateGlobalSelectAll();

                }
            );

        });


    /* Individual Permission Changes */

    document
        .querySelectorAll('.permission-input')
        .forEach(function (permission) {

            permission.addEventListener(
                'change',
                function () {

                    updateAllModuleStates();

                }
            );

        });


    /* Update Sub Module Checkbox */

    function updateSubModuleCheckbox(
        subModule,
        checkbox
    ) {

        if (!subModule || !checkbox) {
            return;
        }


        const permissions =
            subModule.querySelectorAll(
                '.permission-input'
            );


        updateCheckboxState(
            checkbox,
            permissions
        );

    }


    /* Update Asset Assignment Main Checkbox */

    function updateAssetAssignmentCheckbox() {

        const assetModule =
            document.querySelector(
                '.permission-module[data-module="asset-assignment"]'
            );


        if (!assetModule) {
            return;
        }


        const checkbox =
            assetModule.querySelector(
                '.module-check-all'
            );


        const permissions =
            assetModule.querySelectorAll(
                '.permission-input'
            );


        updateCheckboxState(
            checkbox,
            permissions
        );

    }


    /* Update Normal Module Checkbox */

    function updateModuleCheckbox(module) {

        const moduleCheckbox =
            module.querySelector(
                '.module-check-all'
            );


        if (!moduleCheckbox) {
            return;
        }


        const permissions =
            module.querySelectorAll(
                '.permission-input'
            );


        updateCheckboxState(
            moduleCheckbox,
            permissions
        );

    }


    /* Update All Module States */

    function updateAllModuleStates() {

        /* Normal modules */

        document
            .querySelectorAll(
                '.permission-module:not([data-module="asset-assignment"])'
            )
            .forEach(function (module) {

                updateModuleCheckbox(module);

            });


        /* Asset Assignment sub modules */

        const assetModule =
            document.querySelector(
                '.permission-module[data-module="asset-assignment"]'
            );


        if (assetModule) {

            assetModule
                .querySelectorAll('.sub-module')
                .forEach(function (subModule) {

                    const checkbox =
                        subModule.querySelector(
                            '.sub-module-check-all'
                        );


                    updateSubModuleCheckbox(
                        subModule,
                        checkbox
                    );

                });


            updateAssetAssignmentCheckbox();

        }


        /* Global checkbox */

        updateGlobalSelectAll();

    }


    /* Update Global Select All */

    function updateGlobalSelectAll() {

        if (!globalSelectAll) {
            return;
        }


        const permissions =
            document.querySelectorAll(
                '.permission-input'
            );


        updateCheckboxState(
            globalSelectAll,
            permissions
        );

    }


    /* Initial State */

    updateAllModuleStates();

});

</script>


<style>

/* Page header */

.page-header {
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(26, 42, 58, 0.85);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.05);
}

.page-header .d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    color: #4ecdc4;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}


/* CARD */

.roles-container .card {
    background: rgba(26, 42, 58, 0.85);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.05);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    color: #e8e8e8;
}

.roles-container .card-body {
    padding: 30px;
}


/* Role form */

.roles-container label {
    color: #e8e8e8;
    font-weight: 500;
    margin-bottom: 8px;
}

.roles-container .form-control {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    color: #e8e8e8;
    padding: 12px 15px;
    min-height: 46px;
}

.roles-container .form-control:focus {
    background: rgba(255,255,255,0.12);
    border-color: #4ecdc4;
    box-shadow: 0 0 0 0.2rem rgba(78,205,196,0.15);
    color: #fff;
}

.roles-container .form-control::placeholder {
    color: #a0aec0;
}


/* SELECT ALL */

.select-all-box {
    background: rgba(78,205,196,0.08);
    border: 1px solid rgba(78,205,196,0.2);
    border-radius: 10px;
    padding: 12px 15px;
}

.select-all-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    margin: 0 !important;
    color: #4ecdc4 !important;
}

.select-all-label input {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #4ecdc4;
}


/* MODULE */

.permission-module {
    margin-bottom: 25px;
    padding: 18px;
    background: rgba(255,255,255,0.025);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 12px;
}

.module-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    color: #4ecdc4;
    font-size: 17px;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.module-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.module-heading i {
    width: 20px;
    text-align: center;
}


/* MODULE SELECT ALL */

.module-select-all {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    margin: 0 !important;
    color: #4ecdc4 !important;
    font-size: 13px;
    font-weight: 500;
}

.module-select-all input {
    width: 17px;
    height: 17px;
    cursor: pointer;
    accent-color: #4ecdc4;
    margin: 0;
}

.module-select-all span {
    white-space: nowrap;
}


/* SUB MODULE */

.sub-module {
    margin-top: 15px;
}

.sub-module-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
}

.sub-module-heading {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #a0aec0;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 0;
}

.sub-module-heading i {
    width: 18px;
    text-align: center;
}


/* SUB MODULE SELECT ALL */

.sub-module-select-all {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    margin: 0 !important;
    color: #a0aec0 !important;
    font-size: 12px;
    font-weight: 500;
}

.sub-module-select-all input {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #4ecdc4;
    margin: 0;
}

.sub-module-select-all span {
    white-space: nowrap;
}


/* PERMISSIONS GRID */

.permissions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.permission-item {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 10px;
    padding: 12px;
    transition: all 0.3s ease;
}

.permission-item:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(78,205,196,0.3);
}

.permission-item .form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.permission-item .form-check-input {
    position: static;
    margin: 0;
    width: 17px;
    height: 17px;
    cursor: pointer;
    accent-color: #4ecdc4;
    flex-shrink: 0;
}

.permission-item .form-check-label {
    margin: 0;
    cursor: pointer;
    font-size: 14px;
}


/* BUTTONS */

.roles-container .btn {
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

.roles-container .btn:hover {
    transform: translateY(-2px);
}

.roles-container .btn-primary {
    background: linear-gradient(
        135deg,
        #4ecdc4 0%,
        #2bb5ad 100%
    );
    color: #fff;
    border: 1px solid rgba(78,205,196,0.3);
    box-shadow: 0 4px 15px rgba(78,205,196,0.25);
}

.roles-container .btn-primary:hover {
    background: linear-gradient(
        135deg,
        #2bb5ad 0%,
        #4ecdc4 100%
    );
    box-shadow: 0 6px 20px rgba(78,205,196,0.35);
}

.roles-container .btn-secondary {
    background: rgba(255,255,255,0.08);
    color: #e8e8e8;
    border: 1px solid rgba(255,255,255,0.1);
}

.roles-container .btn-secondary:hover {
    background: rgba(255,255,255,0.15);
    color: #fff;
}


/* Responsive page styles */

@media (max-width: 768px) {

    .page-header .d-flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .header-actions {
        width: 100%;
    }

    .header-actions .btn {
        width: 100%;
    }

    .permissions-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .roles-container .card-body {
        padding: 20px;
    }

    .module-heading {
        align-items: flex-start;
    }

}

@media (max-width: 576px) {

    .page-title {
        font-size: 20px;
    }

    .permissions-grid {
        grid-template-columns: 1fr;
    }

    .roles-container .btn {
        padding: 10px 20px;
        font-size: 14px;
    }

    .module-heading {
        flex-direction: column;
        align-items: flex-start;
    }

    .sub-module-header {
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>

@endsection