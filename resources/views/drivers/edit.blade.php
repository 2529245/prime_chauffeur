@extends('layouts.app')

@section('title', 'Edit Driver')
@section('header', 'Edit Driver')

@section('content')

<div class="drivers-container">

 
{{-- Page header --}}
<div class="page-header">

    <div class="d-flex justify-content-between align-items-center">

        <h1 class="page-title">
            <i class="fas fa-id-card"></i>
            Edit Driver: {{ $driver->name }}
        </h1>

        <div class="header-actions">

            <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i>
                All Drivers
            </a>

            <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info ml-2">
                <i class="fas fa-eye"></i>
                View Details
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

                <form action="{{ route('drivers.update', $driver->id) }}" method="POST">

                    @csrf
                    @method('PUT')


                    {{-- Driver basic details --}}
                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">

                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="name">
                                    Driver Name *
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $driver->name) }}"
                                    required
                                >

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        <div class="col-md-6" style="padding-left:10px;">

                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="contact_no">
                                    Contact Number *
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('contact_no') is-invalid @enderror"
                                    id="contact_no"
                                    name="contact_no"
                                    value="{{ old('contact_no', $driver->contact_no) }}"
                                    required
                                >

                                @error('contact_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Contact and status --}}
                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">

                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="emergency_contact">
                                    Emergency Contact
                                </label>

                                <input
                                    type="text"
                                    class="form-control @error('emergency_contact') is-invalid @enderror"
                                    id="emergency_contact"
                                    name="emergency_contact"
                                    value="{{ old('emergency_contact', $driver->emergency_contact) }}"
                                >

                                @error('emergency_contact')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        <div class="col-md-6" style="padding-left:10px;">

                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="status">
                                    Status *
                                </label>

                                <select
                                    class="form-control @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required
                                >

                                    <option value="">
                                        Select Status
                                    </option>

                                    <option
                                        value="active"
                                        {{ old('status', $driver->status) == 'active' ? 'selected' : '' }}
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ old('status', $driver->status) == 'inactive' ? 'selected' : '' }}
                                    >
                                        Inactive
                                    </option>

                                    <option
                                        value="on_leave"
                                        {{ old('status', $driver->status) == 'on_leave' ? 'selected' : '' }}
                                    >
                                        On Leave
                                    </option>

                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Assign vehicles --}}
                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="vehicles">
                                    Assign Vehicles
                                </label>

                                <select
                                    multiple
                                    class="form-control @error('vehicles') is-invalid @enderror"
                                    id="vehicles"
                                    name="vehicles[]"
                                >

                                    @foreach($vehicles as $vehicle)

                                        <option
                                            value="{{ $vehicle->id }}"
                                            {{ in_array(
                                                $vehicle->id,
                                                old(
                                                    'vehicles',
                                                    $driver->vehicles->pluck('id')->toArray()
                                                )
                                            ) ? 'selected' : '' }}
                                        >
                                            {{ $vehicle->vehicle_name }}
                                            ({{ $vehicle->vehicle_plate_no }})
                                        </option>

                                    @endforeach

                                </select>

                                @error('vehicles')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Choose primary vehicle --}}
                    <div class="row">

                        <div class="col-md-6" style="padding-right:10px;">

                            <div class="form-group" style="margin-bottom:20px;">

                                <label for="primary_vehicle">
                                    Primary Vehicle
                                </label>

                                <select
                                    class="form-control @error('primary_vehicle') is-invalid @enderror"
                                    id="primary_vehicle"
                                    name="primary_vehicle"
                                >

                                    <option value="">
                                        Select Primary Vehicle
                                    </option>

                                    @foreach($vehicles as $vehicle)

                                        <option
                                            value="{{ $vehicle->id }}"
                                            {{ old(
                                                'primary_vehicle',
                                                optional($driver->primaryVehicle)->id
                                            ) == $vehicle->id ? 'selected' : '' }}
                                        >
                                            {{ $vehicle->vehicle_name }}
                                            ({{ $vehicle->vehicle_plate_no }})
                                        </option>

                                    @endforeach

                                </select>

                                @error('primary_vehicle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Form actions --}}
                    <div class="form-actions" style="margin-top:30px;">

                        <div class="d-flex justify-content-end align-items-center">

                            <a
                                href="{{ route('drivers.index') }}"
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
                                Update Driver
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
 

</div>

@endsection
