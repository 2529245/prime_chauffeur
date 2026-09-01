@extends('layouts.app')

@section('title', 'Driver Details')
@section('header', 'Driver Details')

@section('content')

<div class="drivers-container">
    {{-- Page header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title text-white">
                <i class="fas fa-user"></i>
                Driver: {{ $driver->name }}
            </h1>

```
        <div class="header-actions">
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> All Drivers
            </a>

            <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-primary ml-2">
                <i class="fas fa-edit"></i> Edit Driver
            </a>
        </div>
    </div>
</div>

{{-- Show alert messages --}}
@include('common.alert')

<div class="row">

    <div class="col-lg-8">

        {{-- Driver details --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white" style="margin-bottom:5px;">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Driver Information
                </h5>
            </div>

            <div class="card-body text-white bg-dark">
                <div class="row">

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Driver ID:</label>
                            <span>#{{ $driver->id }}</span>
                        </div>

                        <div class="detail-item">
                            <label>Name:</label>
                            <span>{{ $driver->name }}</span>
                        </div>

                        <div class="detail-item">
                            <label>Contact Number:</label>
                            <span>{{ $driver->contact_no }}</span>
                        </div>

                        <div class="detail-item">
                            <label>Emergency Contact:</label>
                            <span>{{ $driver->emergency_contact ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Status:</label>
                            <span class="status-badge status-{{ str_replace('_', '-', $driver->status) }}">
                                {{ ucfirst(str_replace('_', ' ', $driver->status)) }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <label>Created On:</label>
                            <span>
                                {{ $driver->created_at?->format('M d, Y h:i A') ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Driver documents --}}
        <div class="card mb-4">
            <div class="card-header bg-info text-white" style="margin-bottom:5px;">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt"></i> Documents
                </h5>
            </div>

            <div class="card-body text-white bg-dark">

                @if($driver->documents->count() > 0)

                    <div class="row">

                        @foreach($driver->documents as $document)

                        <div class="col-md-6 mb-3">

                            <div class="document-card bg-dark border-light p-3 rounded">

                                <div class="document-info">
                                    <h6>
                                        {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}
                                    </h6>

                                    <p class="mb-1">
                                        <small class="text-muted">
                                            Expires:
                                            {{ $document->expiry_date?->format('M d, Y') ?? 'N/A' }}
                                        </small>
                                    </p>

                                    @if($document->expiry_date)
                                        <p class="mb-0">
                                            <span class="status-badge status-{{
                                                $document->expiry_date->isPast()
                                                    ? 'expired'
                                                    : ($document->expiry_date->diffInDays(now()) <= 30
                                                        ? 'warning'
                                                        : 'valid')
                                            }}">
                                                {{
                                                    $document->expiry_date->isPast()
                                                        ? 'Expired'
                                                        : ($document->expiry_date->diffInDays(now()) <= 30
                                                            ? 'Expiring Soon'
                                                            : 'Valid')
                                                }}
                                            </span>
                                        </p>
                                    @endif
                                </div>

                                <div class="document-actions mt-2">

                                    <a href="{{ route('documents.driver.view', $document) }}"
                                       class="btn btn-sm btn-outline-info"
                                       target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('documents.driver.download', $document) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i>
                                    </a>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                @else

                    <div class="text-center text-muted">
                        <p>No documents uploaded for this driver</p>
                    </div>

                @endif

            </div>
        </div>

    </div>

    <div class="col-lg-4">

        {{-- Booking statistics --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar"></i> Booking Statistics
                </h5>
            </div>

            <div class="card-body text-white bg-dark">

                <div class="detail-item">
                    <label>Total Bookings:</label>
                    <span>{{ $driver->bookings->count() }}</span>
                </div>

                <div class="detail-item">
                    <label>Active Bookings:</label>
                    <span>
                        {{ $driver->bookings->whereIn('status', [
                            'pending',
                            'confirmed',
                            'in_progress'
                        ])->count() }}
                    </span>
                </div>

                <div class="detail-item">
                    <label>Completed Bookings:</label>
                    <span>
                        {{ $driver->bookings->where('status', 'completed')->count() }}
                    </span>
                </div>

                <div class="detail-item">
                    <label>Cancelled Bookings:</label>
                    <span>
                        {{ $driver->bookings->where('status', 'cancelled')->count() }}
                    </span>
                </div>

                <div class="detail-item">
                    <label>Total Revenue:</label>
                    <span>
                        AED {{ number_format($driver->bookings->sum('gross_total'), 2) }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Available actions --}}
        <div class="card mb-4">

            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-cog"></i> Actions
                </h5>
            </div>

            <div class="card-body text-white bg-dark">

                <div class="d-grid gap-2">

                    <a href="{{ route('bookings.create', ['driver_id' => $driver->id]) }}"
                       class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i>
                        Create Booking for This Driver
                    </a>

                    <a href="{{ route('documents.driver.create', ['driver_id' => $driver->id]) }}"
                       class="btn btn-success btn-block">
                        <i class="fas fa-upload"></i>
                        Upload Document
                    </a>

                    <form action="{{ route('drivers.destroy', $driver->id) }}"
                          method="POST"
                          class="d-grid">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-block"
                                onclick="return confirm('Are you sure you want to delete this driver?')">
                            <i class="fas fa-trash"></i>
                            Delete Driver
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>

</div>
```

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

/* Status badges */
.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 12px;
    text-align: center;
    white-space: nowrap;
}

.status-active {
    background-color: #38c172;
    color: #fff;
}

.status-inactive {
    background-color: #ff6b6b;
    color: #fff;
}

.status-on-leave {
    background-color: #4299e1;
    color: #fff;
}

.status-valid {
    background-color: #38c172;
    color: #fff;
}

.status-warning {
    background-color: #ffb142;
    color: #fff;
}

.status-expired {
    background-color: #ff6b6b;
    color: #fff;
}

.btn-block {
    margin-bottom: 10px;
}

.document-card {
    border-radius: 12px;
    border: 1px solid #dee2e6;
    padding: 15px;
    background: #343a40;
}

.badge-success {
    background-color: #38c172;
    color: #fff;
}

.badge-primary {
    background-color: #4299e1;
    color: #fff;
}

.badge-info {
    background-color: #4ecdc4;
    color: #fff;
}

.badge-warning {
    background-color: #ffb142;
    color: #212529;
}

.badge-danger {
    background-color: #ff6b6b;
    color: #fff;
}
</style>

@endpush
