@extends('layouts.app')

@section('title', 'Edit Role')
@section('header', 'Edit Role')

@section('content')

<div class="roles-container">

    {{-- Page header --}}

    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title">
                <i class="fas fa-user-shield"></i>
                Edit Role
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


    {{-- Role form card --}}

    <div class="row justify-content-center">

        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">


                    {{-- Protect Super Admin role --}}

                    @if ($role->name === 'Super Admin')

                        <div class="alert alert-info">

                            <i class="fas fa-info-circle"></i>

                            The Super Admin role has full access to the
                            application and cannot be modified from this page.

                        </div>

                        <div class="form-actions">

                            <div class="d-flex justify-content-end">

                                <a
                                    href="{{ route('roles.index') }}"
                                    class="btn btn-secondary"
                                >
                                    <i class="fas fa-arrow-left"></i>
                                    Back to Roles
                                </a>

                            </div>

                        </div>

                    @else


                        {{-- Role form --}}

                        <form
                            method="POST"
                            action="{{ route('roles.update', ['role' => $role->id]) }}"
                        >

                            @csrf
                            @method('PUT')


                            {{-- Role name --}}

                            <div class="row">

                                <div class="col-md-12">

                                    <div
                                        class="form-group"
                                        style="margin-bottom:20px;"
                                    >

                                        <label for="name">
                                            Role Name *
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="name"
                                            name="name"
                                            value="{{ old('name', $role->name) }}"
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


                            {{-- Assigned permissions --}}

                            @php

                                $assignedPermissionIds = old(
                                    'permissions',
                                    $role->permissions
                                        ->pluck('id')
                                        ->toArray()
                                );

                            @endphp


                            <div class="row">

                                <div class="col-md-12">

                                    <div
                                        class="form-group"
                                        style="margin-bottom:20px;"
                                    >

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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-tachometer-alt"></i>

                                                    Dashboard

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllDashboard"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllDashboard"
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
                                                        stripos($permission->name, 'dashboard') !== false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-dashboard"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-calendar-check"></i>

                                                    Booking

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllBooking"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllBooking"
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
                                                        stripos($permission->name, 'driver') === false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-booking"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-id-card"></i>

                                                    Driver

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllDriver"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllDriver"
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
                                                        stripos($permission->name, 'driver') !== false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-driver"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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
                                            data-module="asset"
                                        >

                                            <div class="module-heading">

                                                <div class="module-heading-left">

                                                    <i class="fas fa-boxes"></i>

                                                    Asset Assignment

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllAsset"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllAsset"
                                                        data-module="asset"
                                                    >

                                                    <span>
                                                        Select All
                                                    </span>

                                                </label>

                                            </div>


                                            {{-- POS machine permissions --}}

                                            <div class="sub-module">

                                                <div class="sub-module-heading">

                                                    <i class="fas fa-credit-card"></i>

                                                    POS Machine

                                                </div>


                                                <div class="permissions-grid">

                                                    @foreach ($permissions as $permission)

                                                        @if (
                                                            stripos($permission->name, 'pos') !== false ||
                                                            (
                                                                stripos($permission->name, 'machine') !== false &&
                                                                stripos($permission->name, 'sim') === false
                                                            )
                                                        )

                                                            <div class="permission-item">

                                                                <div class="form-check">

                                                                    <input
                                                                        class="form-check-input permission-input module-asset"
                                                                        type="checkbox"
                                                                        name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                            <div class="sub-module">

                                                <div class="sub-module-heading">

                                                    <i class="fas fa-sim-card"></i>

                                                    SIM Card

                                                </div>


                                                <div class="permissions-grid">

                                                    @foreach ($permissions as $permission)

                                                        @if (
                                                            stripos($permission->name, 'sim') !== false
                                                        )

                                                            <div class="permission-item">

                                                                <div class="form-check">

                                                                    <input
                                                                        class="form-check-input permission-input module-asset"
                                                                        type="checkbox"
                                                                        name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                            <div class="sub-module">

                                                <div class="sub-module-heading">

                                                    <i class="fas fa-mobile-alt"></i>

                                                    Mobile Phone

                                                </div>


                                                <div class="permissions-grid">

                                                    @foreach ($permissions as $permission)

                                                        @if (
                                                            stripos($permission->name, 'mobile') !== false ||
                                                            stripos($permission->name, 'phone') !== false
                                                        )

                                                            <div class="permission-item">

                                                                <div class="form-check">

                                                                    <input
                                                                        class="form-check-input permission-input module-asset"
                                                                        type="checkbox"
                                                                        name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                            <div class="sub-module">

                                                <div class="sub-module-heading">

                                                    <i class="fas fa-hand-holding"></i>

                                                    Asset Assign

                                                </div>


                                                <div class="permissions-grid">

                                                    @foreach ($permissions as $permission)

                                                        @if (
                                                            (
                                                                stripos($permission->name, 'asset') !== false &&
                                                                stripos($permission->name, 'assign') !== false
                                                            ) ||
                                                            stripos($permission->name, 'asset_assign') !== false ||
                                                            stripos($permission->name, 'asset assignment') !== false
                                                        )

                                                            <div class="permission-item">

                                                                <div class="form-check">

                                                                    <input
                                                                        class="form-check-input permission-input module-asset"
                                                                        type="checkbox"
                                                                        name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                            <div class="sub-module">

                                                <div class="sub-module-heading">

                                                    <i class="fas fa-undo"></i>

                                                    Asset Return

                                                </div>


                                                <div class="permissions-grid">

                                                    @foreach ($permissions as $permission)

                                                        @if (
                                                            (
                                                                stripos($permission->name, 'asset') !== false &&
                                                                stripos($permission->name, 'return') !== false
                                                            ) ||
                                                            stripos($permission->name, 'asset_return') !== false ||
                                                            stripos($permission->name, 'asset return') !== false
                                                        )

                                                            <div class="permission-item">

                                                                <div class="form-check">

                                                                    <input
                                                                        class="form-check-input permission-input module-asset"
                                                                        type="checkbox"
                                                                        name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-car"></i>

                                                    Vehicle

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllVehicle"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllVehicle"
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
                                                        stripos($permission->name, 'vehicle') !== false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-vehicle"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-users"></i>

                                                    Staff

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllStaff"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllStaff"
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
                                                        stripos($permission->name, 'staff') !== false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-staff"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-user"></i>

                                                    Users

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllUsers"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllUsers"
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
                                                        stripos($permission->name, 'role') === false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-users"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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

                                                <div class="module-heading-left">

                                                    <i class="fas fa-user-shield"></i>

                                                    Roles

                                                </div>

                                                <label
                                                    class="module-select-all"
                                                    for="selectAllRoles"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        class="module-select-checkbox"
                                                        id="selectAllRoles"
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
                                                        stripos($permission->name, 'role') !== false
                                                    )

                                                        <div class="permission-item">

                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input permission-input module-roles"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, $assignedPermissionIds) ? 'checked' : '' }}
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


                                        {{-- PERMISSION ERRORS Permissions module itself is NOT displayed. --}}

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
                                        style="min-width:160px;"
                                    >
                                        <i class="fas fa-save"></i>
                                        Update Role
                                    </button>

                                </div>

                            </div>


                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


{{-- SELECT ALL JAVASCRIPT --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* Select all permissions */

    const mainSelectAll =
        document.getElementById('checkAllPermissions');

    const allPermissions =
        document.querySelectorAll('.permission-input');


    /* MODULE SELECT ALL CHECKBOXES */

    const moduleSelectAlls =
        document.querySelectorAll('.module-select-checkbox');


    /* UPDATE MODULE SELECT ALL */

    function updateModuleSelectAll(moduleName) {

        const modulePermissions =
            document.querySelectorAll(
                '.module-' + moduleName
            );

        const moduleSelect =
            document.querySelector(
                '.module-select-checkbox[data-module="' +
                moduleName +
                '"]'
            );


        if (!moduleSelect) {
            return;
        }


        const total =
            modulePermissions.length;

        const checked =
            document.querySelectorAll(
                '.module-' +
                moduleName +
                ':checked'
            ).length;


        if (total === 0) {

            moduleSelect.checked = false;
            moduleSelect.indeterminate = false;

        } else if (checked === 0) {

            moduleSelect.checked = false;
            moduleSelect.indeterminate = false;

        } else if (checked === total) {

            moduleSelect.checked = true;
            moduleSelect.indeterminate = false;

        } else {

            moduleSelect.checked = false;
            moduleSelect.indeterminate = true;

        }

    }


    /* UPDATE ALL MODULE CHECKBOXES */

    function updateAllModuleSelects() {

        moduleSelectAlls.forEach(function (checkbox) {

            const moduleName =
                checkbox.getAttribute('data-module');

            updateModuleSelectAll(moduleName);

        });

    }


    /* UPDATE MAIN SELECT ALL */

    function updateMainSelectAll() {

        if (!mainSelectAll) {
            return;
        }


        const total =
            allPermissions.length;

        const checked =
            document.querySelectorAll(
                '.permission-input:checked'
            ).length;


        if (checked === 0) {

            mainSelectAll.checked = false;
            mainSelectAll.indeterminate = false;

        } else if (checked === total) {

            mainSelectAll.checked = true;
            mainSelectAll.indeterminate = false;

        } else {

            mainSelectAll.checked = false;
            mainSelectAll.indeterminate = true;

        }

    }


    /* MAIN SELECT ALL CHANGE */

    if (mainSelectAll) {

        mainSelectAll.addEventListener(
            'change',
            function () {

                allPermissions.forEach(
                    function (permission) {

                        permission.checked =
                            mainSelectAll.checked;

                    }
                );


                moduleSelectAlls.forEach(
                    function (moduleCheckbox) {

                        moduleCheckbox.checked =
                            mainSelectAll.checked;

                        moduleCheckbox.indeterminate =
                            false;

                    }
                );

            }
        );

    }


    /* MODULE SELECT ALL CHANGE */

    moduleSelectAlls.forEach(
        function (moduleCheckbox) {

            moduleCheckbox.addEventListener(
                'change',
                function () {

                    const moduleName =
                        moduleCheckbox.getAttribute(
                            'data-module'
                        );


                    const modulePermissions =
                        document.querySelectorAll(
                            '.module-' + moduleName
                        );


                    modulePermissions.forEach(
                        function (permission) {

                            permission.checked =
                                moduleCheckbox.checked;

                        }
                    );


                    moduleCheckbox.indeterminate =
                        false;


                    updateMainSelectAll();

                }
            );

        }
    );


    /* INDIVIDUAL PERMISSION CHANGE */

    allPermissions.forEach(
        function (permission) {

            permission.addEventListener(
                'change',
                function () {

                    updateAllModuleSelects();

                    updateMainSelectAll();

                }
            );

        }
    );


    /* INITIAL STATE */

    updateAllModuleSelects();

    updateMainSelectAll();

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


/* Select all permissions */

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


/* MODULE HEADING */

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

.module-heading-left {
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
    gap: 8px;
    margin: 0 !important;
    padding: 6px 10px;
    background: rgba(78,205,196,0.08);
    border: 1px solid rgba(78,205,196,0.18);
    border-radius: 8px;
    color: #4ecdc4 !important;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.module-select-all:hover {
    background: rgba(78,205,196,0.15);
    border-color: rgba(78,205,196,0.35);
}

.module-select-all input {
    width: 16px;
    height: 16px;
    margin: 0;
    cursor: pointer;
    accent-color: #4ecdc4;
}


/* SUB MODULE */

.sub-module {
    margin-top: 15px;
}

.sub-module-heading {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #a0aec0;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}

.sub-module-heading i {
    width: 18px;
    text-align: center;
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


/* ALERT */

.roles-container .alert {
    border-radius: 12px;
    padding: 15px 18px;
    margin-bottom: 25px;
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

    .module-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .module-select-all {
        align-self: flex-end;
    }

    .permissions-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .roles-container .card-body {
        padding: 20px;
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

}

</style>

@endsection