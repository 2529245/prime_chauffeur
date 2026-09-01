@extends('layouts.app')

@section('title', 'Today\'s Bookings')
@section('header', 'Today\'s Bookings')

@section('content')
<title>Today's Bookings</title>

<div class="bookings-container">

    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-calendar-day"></i>
                Today's Bookings - {{ now()->format('M d, Y') }}
            </h1>

            <div class="header-actions">
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Booking
                </a>

                <a href="{{ route('bookings.index') }}" class="btn btn-secondary ml-2">
                    <i class="fas fa-list"></i> All Bookings
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    {{-- Today's booking summary --}}
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="stat-content">
                    <h3>{{ $bookings->whereIn('status', ['pending', 'confirmed'])->count() }}</h3>
                    <p>Upcoming</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-play-circle"></i>
                </div>

                <div class="stat-content">
                    <h3>{{ $bookings->where('status', 'in_progress')->count() }}</h3>
                    <p>In Progress</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="stat-content">
                    <h3>{{ $bookings->where('status', 'completed')->count() }}</h3>
                    <p>Completed</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>

                <div class="stat-content">
                    <h3>{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                    <p>Cancelled</p>
                </div>
            </div>
        </div>

    </div>


    {{-- Bookings table --}}
    <div class="table-card">

        <div class="table-header">

            <h2>Today's Bookings ({{ $bookings->total() }})</h2>

            <div class="table-actions">

                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        placeholder="Search today's bookings..."
                        id="searchInput">
                </div>

                <div class="time-filter">
                    <select id="timeFilter" class="form-control">
                        <option value="all">All Times</option>
                        <option value="morning">Morning (6AM - 12PM)</option>
                        <option value="afternoon">Afternoon (12PM - 6PM)</option>
                        <option value="evening">Evening (6PM - 12AM)</option>
                        <option value="night">Night (12AM - 6AM)</option>
                    </select>
                </div>

            </div>
        </div>


        <div class="table-responsive">

            <table class="modern-table" id="bookingsTable">

                <thead>
                    <tr>
                        <th data-sort="time">
                            <span>Time</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="id">
                            <span>Booking ID</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        {{-- Client field removed --}}

                        <th data-sort="guest">
                            <span>Guest</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="pickup">
                            <span>Pickup Location</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="vehicle">
                            <span>Vehicle</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="driver">
                            <span>Driver</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="status">
                            <span>Status</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th>Actions</th>
                    </tr>
                </thead>


                <tbody>

                    @foreach ($bookings as $booking)

                        @php
                            $pickupHour = $booking->pick_up_time->format('H');

                            if ($pickupHour >= 6 && $pickupHour < 12) {
                                $timeCategory = 'morning';
                            } elseif ($pickupHour >= 12 && $pickupHour < 18) {
                                $timeCategory = 'afternoon';
                            } elseif ($pickupHour >= 18 && $pickupHour < 24) {
                                $timeCategory = 'evening';
                            } else {
                                $timeCategory = 'night';
                            }
                        @endphp


                        <tr data-time="{{ $timeCategory }}">

                            {{-- Pickup time --}}
                            <td>
                                <div class="time-badge time-{{ $timeCategory }}">
                                    <i class="fas fa-clock"></i>
                                    {{ $booking->pick_up_time->format('H:i') }}
                                </div>
                            </td>


                            {{-- Booking ID --}}
                            <td>
                                #{{ $booking->id }}
                            </td>


                            {{-- Client field removed --}}


                            {{-- Guest details --}}
                            <td>
                                <strong>{{ $booking->guest_name }}</strong>

                                <br>

                                <small class="text-muted">
                                    {{ $booking->guest_contact_number }}
                                </small>
                            </td>


                            {{-- Pickup location --}}
                            <td>
                                <div class="location-info">

                                    <i class="fas fa-map-marker-alt text-danger"></i>

                                    <span title="{{ $booking->pick_up_location }}">
                                        {{ Str::limit($booking->pick_up_location, 30) }}
                                    </span>

                                </div>
                            </td>


                            {{-- Vehicle field --}}
                            <td>
                                <div class="vehicle-info">

                                    <i class="fas fa-car text-info"></i>

                                    {{ $booking->vehicle?->vehicle_name ?? 'N/A' }}

                                </div>
                            </td>


                            {{-- Driver field --}}
                            <td>
                                <div class="driver-info">

                                    <i class="fas fa-id-card text-warning"></i>

                                    {{ $booking->driver?->name ?? 'N/A' }}

                                </div>
                            </td>


                            {{-- Status filter --}}
                            <td>

                                <span class="status-badge status-{{ $booking->status }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>

                                @if(
                                    $booking->pick_up_time->isPast() &&
                                    in_array($booking->status, ['pending', 'confirmed'])
                                )

                                    <br>

                                    <small class="text-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Overdue
                                    </small>

                                @endif

                            </td>


                            {{-- Booking actions --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- View booking --}}
                                    <a
                                        href="{{ route('bookings.show', $booking) }}"
                                        class="btn-action btn-info"
                                        title="View Booking">

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    {{-- Edit booking --}}
                                    <a
                                        href="{{ route('bookings.edit', $booking) }}"
                                        class="btn-action btn-primary"
                                        title="Edit Booking">

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    {{-- Booking status actions --}}
                                    @if(in_array($booking->status, [
                                        'pending',
                                        'confirmed',
                                        'in_progress'
                                    ]))

                                        <div class="status-actions">

                                            {{-- Confirm --}}
                                            @if($booking->status == 'pending')

                                                <form
                                                    action="{{ route('bookings.updateStatus', $booking->id) }}"
                                                    method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="confirmed">

                                                    <button
                                                        type="submit"
                                                        class="btn-action btn-success"
                                                        title="Confirm Booking">

                                                        <i class="fas fa-check"></i>

                                                    </button>

                                                </form>

                                            @endif


                                            {{-- Start Trip --}}
                                            @if($booking->status == 'confirmed')

                                                <form
                                                    action="{{ route('bookings.updateStatus', $booking->id) }}"
                                                    method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="in_progress">

                                                    <button
                                                        type="submit"
                                                        class="btn-action btn-info"
                                                        title="Start Trip">

                                                        <i class="fas fa-play"></i>

                                                    </button>

                                                </form>

                                            @endif


                                            {{-- Complete Trip --}}
                                            @if($booking->status == 'in_progress')

                                                <form
                                                    action="{{ route('bookings.updateStatus', $booking->id) }}"
                                                    method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('PATCH')

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="completed">

                                                    <button
                                                        type="submit"
                                                        class="btn-action btn-success"
                                                        title="Complete Trip">

                                                        <i class="fas fa-flag-checkered"></i>

                                                    </button>

                                                </form>

                                            @endif

                                        </div>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        <div class="table-footer">

            <div class="table-info">

                Showing
                {{ $bookings->firstItem() }}
                to
                {{ $bookings->lastItem() }}
                of
                {{ $bookings->total() }}
                entries

            </div>

            <div class="pagination">

                {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const timeFilter = document.getElementById('timeFilter');
    const table = document.getElementById('bookingsTable');

    if (!searchInput || !timeFilter || !table) {
        return;
    }

    const rows = table.querySelectorAll('tbody tr');


    function filterBookings() {

        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedTime = timeFilter.value;

        rows.forEach(row => {

            const rowText = row.textContent.toLowerCase();

            const matchesSearch =
                rowText.includes(searchTerm);

            const matchesTime =
                selectedTime === 'all' ||
                row.getAttribute('data-time') === selectedTime;

            row.style.display =
                (matchesSearch && matchesTime)
                    ? ''
                    : 'none';

        });

    }


    // Search
    searchInput.addEventListener('input', filterBookings);


    // Time Filter
    timeFilter.addEventListener('change', filterBookings);


    // Auto-refresh every 5 minutes
    setInterval(function () {
        window.location.reload();
    }, 300000);

});
</script>


<style>

/* Statistics Cards */

.stat-card {
    background: rgba(26, 42, 58, 0.85);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border: 1px solid rgba(255,255,255,0.05);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.stat-content h3 {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    color: #4ecdc4;
}

.stat-content p {
    margin: 0;
    color: #a0aec0;
    font-size: 14px;
}


/* Time Badges */

.time-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.time-morning {
    background: rgba(255, 177, 66, 0.15);
    color: #ffb142;
}

.time-afternoon {
    background: rgba(56, 193, 114, 0.15);
    color: #38c172;
}

.time-evening {
    background: rgba(66, 153, 225, 0.15);
    color: #4299e1;
}

.time-night {
    background: rgba(108, 117, 125, 0.15);
    color: #6c757d;
}


/* Location / Vehicle / Driver */

.location-info,
.vehicle-info,
.driver-info {
    display: flex;
    align-items: center;
    gap: 8px;
}


/* Booking status actions */

.status-actions {
    display: flex;
    gap: 4px;
    margin-top: 4px;
}

.status-actions .btn-action {
    width: 28px;
    height: 28px;
}


/* Time Filter */

.time-filter {
    margin-left: 15px;
}

.time-filter select {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    color: #e8e8e8;
    padding: 8px 12px;
}


/* Overdue */

.text-warning {
    color: #ffc107 !important;
}


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


/* Status Badge */

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-pending {
    background: rgba(255, 177, 66, 0.15);
    color: #ffb142;
}

.status-confirmed {
    background: rgba(56, 193, 114, 0.15);
    color: #38c172;
}

.status-in_progress {
    background: rgba(66, 153, 225, 0.15);
    color: #4299e1;
}

.status-completed {
    background: rgba(78, 205, 196, 0.15);
    color: #4ecdc4;
}

.status-cancelled {
    background: rgba(255, 107, 107, 0.15);
    color: #ff6b6b;
}


/* Action Buttons */

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action {
    padding: 8px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.btn-info {
    background: linear-gradient(135deg, #6cb2eb 0%, #4299e1 100%);
    color: #fff;
}

.btn-primary {
    background: linear-gradient(135deg, #4ecdc4 0%, #2bb5ad 100%);
    color: #fff;
}

.btn-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #e53e3e 100%);
    color: #fff;
}

.btn-success {
    background: linear-gradient(135deg, #38c172 0%, #2d995b 100%);
    color: #fff;
}


/* Mobile */

@media (max-width: 768px) {

    .page-header .d-flex {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .header-actions {
        width: 100%;
        flex-wrap: wrap;
    }

    .table-header {
        flex-direction: column;
        gap: 15px;
    }

    .table-actions {
        width: 100%;
        flex-direction: column;
    }

    .time-filter {
        margin-left: 0;
        width: 100%;
    }

    .time-filter select {
        width: 100%;
    }

}

</style>

@endsection