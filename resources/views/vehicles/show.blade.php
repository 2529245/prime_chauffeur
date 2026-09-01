@extends('layouts.app')

@section('title', 'Vehicle Details')
@section('header', 'Vehicle Details')

@section('content')

<div class="vehicles-container">

    {{-- Page header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title text-white">
                <i class="fas fa-car"></i>
                Vehicle: {{ $vehicle->vehicle_name }}
            </h1>

            <div class="header-actions">

                <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Vehicles
                </a>

                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-primary ml-2">
                    <i class="fas fa-edit"></i> Edit Vehicle
                </a>

                <form action="{{ route('vehicles.exportBookings', $vehicle->id) }}"
                      method="GET"
                      class="d-inline ml-2">

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-csv"></i> Export Bookings CSV
                    </button>

                </form>

            </div>
        </div>
    </div>


    {{-- Show alert messages --}}
    @include('common.alert')


    <div class="row">

        {{-- Vehicle details section --}}
        <div class="col-lg-8">

            {{-- Vehicle details card --}}
            <div class="card mb-4">

                <div class="card-header bg-primary text-white" style="margin-bottom:10px;">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i>
                        Vehicle Information<br/>
                    </h5>
                </div>

                <div class="card-body text-white bg-dark">

                    <div class="row">

                        {{-- Basic vehicle details --}}
                        <div class="col-md-6">

                            <div class="detail-item">
                                <label>Vehicle ID:</label>
                                <span>#{{ $vehicle->id }}</span>
                            </div>

                            <div class="detail-item">
                                <label>Vehicle Name:</label>
                                <span>{{ $vehicle->vehicle_name }}</span>
                            </div>

                            <div class="detail-item">
                                <label>Plate Number:</label>
                                <span>{{ $vehicle->vehicle_plate_no }}</span>
                            </div>

                            <div class="detail-item">
                                <label>Model:</label>
                                <span>{{ $vehicle->vehicle_model }}</span>
                            </div>

                        </div>


                        {{-- More vehicle details --}}
                        <div class="col-md-6">

                            <div class="detail-item">
                                <label>Color:</label>

                                <span class="color-badge"
                                      style="background-color: {{ $vehicle->vehicle_color }}; color: #fff;">
                                    {{ $vehicle->vehicle_color }}
                                </span>
                            </div>


                            <div class="detail-item">
                                <label>Status:</label>

                                <span class="status-badge status-{{ $vehicle->status }}">
                                    {{ ucfirst($vehicle->status) }}
                                </span>
                            </div>


                            <div class="detail-item">
                                <label>Owner Type:</label>

                                <span>
                                    {{ strtoupper($vehicle->owner_type) }}
                                </span>
                            </div>


                            @if($vehicle->owner_type === 'supplier' && $vehicle->supplier)

                                <div class="detail-item">
                                    <label>Supplier:</label>

                                    <span>
                                        {{ $vehicle->supplier->supplier_name }}
                                        -
                                        {{ $vehicle->supplier->contact_number }}
                                    </span>
                                </div>

                            @endif


                            <div class="detail-item">

                                <label>Mulkiya Expiry:</label>

                                @if($vehicle->mulkiya_expiry_date)

                                    <span class="{{ $vehicle->mulkiya_expiry_date->isPast() ? 'text-danger' : '' }}">

                                        {{ $vehicle->mulkiya_expiry_date->format('M d, Y') }}

                                        @if($vehicle->mulkiya_expiry_date->isPast())

                                            <i class="fas fa-exclamation-triangle ml-1"
                                               title="Expired"></i>

                                        @endif

                                    </span>

                                @else

                                    <span class="text-muted">
                                        N/A
                                    </span>

                                @endif

                            </div>


                            <div class="detail-item">
                                <label>Created On:</label>

                                <span>
                                    {{ $vehicle->created_at->format('M d, Y h:i A') }}
                                </span>
                            </div>

                        </div>

                    </div>

                </div>
            </div>


            {{-- Assigned drivers card --}}
            <div class="card mb-4">

                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i>
                        Assigned Drivers
                    </h5>
                </div>

                <div class="card-body text-white bg-dark">

                    @if($vehicle->drivers->count() > 0)

                        <div class="row">

                            @foreach($vehicle->drivers as $driver)

                                <div class="col-md-6 mb-3">

                                    <div class="driver-card bg-dark border-light p-3 rounded">

                                        <div class="driver-info">

                                            <h6>
                                                {{ $driver->name }}
                                            </h6>

                                            <p class="mb-1">
                                                {{ $driver->contact_no }}
                                            </p>

                                            <p class="mb-0">

                                                <span class="status-badge status-{{ $driver->status }}">
                                                    {{ ucfirst($driver->status) }}
                                                </span>

                                                @if($driver->pivot->is_primary)

                                                    <span class="status-badge status-primary ml-1">
                                                        Primary
                                                    </span>

                                                @endif

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="text-center text-muted">
                            <p>No drivers assigned to this vehicle</p>
                        </div>

                    @endif

                </div>
            </div>

        </div>


        {{-- Vehicle summary section --}}
        <div class="col-lg-4">

            {{-- Booking statistics card --}}
            <div class="card mb-4">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i>
                        Booking Statistics
                    </h5>

                </div>


                <div class="card-body text-white bg-dark">

                    <div class="detail-item">
                        <label>Total Bookings:</label>

                        <span>
                            {{ $vehicle->bookings->count() }}
                        </span>
                    </div>


                    <div class="detail-item">
                        <label>Active Bookings:</label>

                        <span>
                            {{
                                $vehicle->bookings
                                    ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
                                    ->count()
                            }}
                        </span>
                    </div>


                    <div class="detail-item">
                        <label>Completed Bookings:</label>

                        <span>
                            {{
                                $vehicle->bookings
                                    ->where('status', 'completed')
                                    ->count()
                            }}
                        </span>
                    </div>


                    <div class="detail-item">
                        <label>Cancelled Bookings:</label>

                        <span>
                            {{
                                $vehicle->bookings
                                    ->where('status', 'cancelled')
                                    ->count()
                            }}
                        </span>
                    </div>


                    <div class="detail-item">
                        <label>Total Revenue:</label>

                        <span>
                            AED {{ number_format($vehicle->bookings->sum('gross_total'), 2) }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Vehicle actions card --}}
            <div class="card mb-4">

                <div class="card-header bg-info text-white">

                    <h5 class="mb-0">
                        <i class="fas fa-cog"></i>
                        Actions
                    </h5>

                </div>


                <div class="card-body text-white bg-dark">

                    <div class="d-grid gap-2">

                        {{-- Create vehicle booking --}}
                        <a href="{{ route('bookings.create', ['vehicle_id' => $vehicle->id]) }}"
                           class="btn btn-primary btn-block">

                            <i class="fas fa-plus"></i>
                            Create Booking with This Vehicle

                        </a>


                        {{-- Export vehicle bookings --}}
                        <form action="{{ route('vehicles.exportBookings', $vehicle->id) }}"
                              method="GET"
                              class="d-grid">

                            <button type="submit"
                                    class="btn btn-success btn-block">

                                <i class="fas fa-file-csv"></i>
                                Export All Bookings CSV

                            </button>

                        </form>


                        {{-- Delete vehicle --}}
                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
                              method="POST"
                              class="d-grid">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-block"
                                    onclick="return confirm('Are you sure you want to delete this vehicle?')">

                                <i class="fas fa-trash"></i>
                                Delete Vehicle

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.detail-item {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 12px;
}

.detail-item label {
    font-weight: 700;
    color: #f8f9fa;
    margin: 0;
    white-space: nowrap;
}

.detail-item span {
    text-align: left;
    color: #ffffff;
}


/* Dynamic badge styles */

.status-badge,
.color-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 12px;
    text-align: center;
    white-space: nowrap;
    min-width: 0;
}


/* Status color styles */

.status-active {
    background-color: #38c172;
    color: #fff;
}

.status-maintenance {
    background-color: #ffb142;
    color: #fff;
}

.status-inactive {
    background-color: #ff6b6b;
    color: #fff;
}

.status-pending {
    background-color: #007bff;
    color: #fff;
}

.status-confirmed {
    background-color: #48b461;
    color: #fff;
}

.status-in_progress {
    background-color: #ffc107;
    color: #212529;
}

.status-completed {
    background-color: #17a2b8;
    color: #fff;
}

.status-cancelled {
    background-color: #dc3545;
    color: #fff;
}

.status-primary {
    background-color: #3490dc;
    color: #fff;
}


.driver-card {
    border-radius: 12px;
    border: 1px solid #dee2e6;
    padding: 15px;
    background: #343a40;
}


.btn-block {
    margin-bottom: 10px;
}


.table-dark {
    background: rgba(255,255,255,0.05);
}

.table-dark th {
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.table-dark td {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}


/* Success button styles */

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: #fff;
    border: 1px solid rgba(40, 167, 69, 0.3);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.25);
}

.btn-success:hover {
    background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.35);
    transform: translateY(-2px);
}

</style>

@endpush