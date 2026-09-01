@extends('layouts.app')

@section('title', 'Create New Vehicle')
@section('header', 'Create New Vehicle')

@section('content')

<div class="vehicles-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-car"></i>
                Create New Vehicle
            </h1>

```
        <div class="header-actions">
            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> All Vehicles
            </a>
        </div>
    </div>
</div>

{{-- Show alert messages --}}
@include('common.alert')

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf

                    {{-- Vehicle details --}}
                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label for="vehicle_name">Vehicle Name *</label>

                                <input
                                    type="text"
                                    class="form-control @error('vehicle_name') is-invalid @enderror"
                                    id="vehicle_name"
                                    name="vehicle_name"
                                    value="{{ old('vehicle_name') }}"
                                    required
                                >

                                @error('vehicle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" style="padding-left:10px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label for="vehicle_plate_no">Plate Number *</label>

                                <input
                                    type="text"
                                    class="form-control @error('vehicle_plate_no') is-invalid @enderror"
                                    id="vehicle_plate_no"
                                    name="vehicle_plate_no"
                                    value="{{ old('vehicle_plate_no') }}"
                                    required
                                >

                                @error('vehicle_plate_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label for="vehicle_model">Model *</label>

                                <input
                                    type="text"
                                    class="form-control @error('vehicle_model') is-invalid @enderror"
                                    id="vehicle_model"
                                    name="vehicle_model"
                                    value="{{ old('vehicle_model') }}"
                                    required
                                >

                                @error('vehicle_model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" style="padding-left:10px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label for="vehicle_color">Color *</label>

                                <input
                                    type="text"
                                    class="form-control @error('vehicle_color') is-invalid @enderror"
                                    id="vehicle_color"
                                    name="vehicle_color"
                                    value="{{ old('vehicle_color') }}"
                                    required
                                >

                                @error('vehicle_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Mulkiya and status --}}
                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label for="mulkiya_expiry_date">
                                    Mulkiya Expiry Date
                                </label>

                                <input
                                    type="date"
                                    class="form-control @error('mulkiya_expiry_date') is-invalid @enderror"
                                    id="mulkiya_expiry_date"
                                    name="mulkiya_expiry_date"
                                    value="{{ old('mulkiya_expiry_date') }}"
                                >

                                @error('mulkiya_expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" style="padding-left:10px;">
                            <div class="form-group" style="margin-bottom:20px;">
                                <label for="status">Status *</label>

                                <select
                                    class="form-control @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required
                                >
                                    <option value="">Select Status</option>

                                    <option value="active"
                                        {{ old('status') == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="maintenance"
                                        {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                        Maintenance
                                    </option>

                                    <option value="inactive"
                                        {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    {{-- Assign vehicle drivers --}}
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="drivers">
                                    Assign Drivers
                                </label>

                                <select
                                    multiple
                                    class="form-control select2 @error('drivers') is-invalid @enderror"
                                    id="drivers"
                                    name="drivers[]"
                                >

                                    @foreach($drivers as $driver)

                                        <option
                                            value="{{ $driver->id }}"
                                            {{ in_array($driver->id, old('drivers', [])) ? 'selected' : '' }}
                                        >
                                            {{ $driver->name }} - {{ $driver->contact_no }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('drivers')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                    </div>

                    {{-- Select primary driver --}}
                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">
                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="primary_driver">
                                    Primary Driver
                                </label>

                                <select
                                    class="form-control @error('primary_driver') is-invalid @enderror"
                                    id="primary_driver"
                                    name="primary_driver"
                                >

                                    <option value="">
                                        Select Primary Driver
                                    </option>

                                    @foreach($drivers as $driver)

                                        <option
                                            value="{{ $driver->id }}"
                                            {{ old('primary_driver') == $driver->id ? 'selected' : '' }}
                                        >
                                            {{ $driver->name }} - {{ $driver->contact_no }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('primary_driver')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                    </div>

                    {{-- Vehicle form actions --}}
                    <div class="form-actions" style="margin-top:30px;">

                        <div class="d-flex justify-content-end align-items-center">

                            <a
                                href="{{ route('vehicles.index') }}"
                                class="btn btn-secondary"
                                style="margin-right:15px; min-width:120px;"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                                style="min-width:120px;"
                            >
                                <i class="fas fa-save"></i>
                                Create Vehicle
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
```

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Set minimum expiry date
    const today = new Date().toISOString().split('T')[0];

    const expiryDate = document.getElementById('mulkiya_expiry_date');

    if (expiryDate) {
        expiryDate.min = today;
    }

});
</script>

@endpush
