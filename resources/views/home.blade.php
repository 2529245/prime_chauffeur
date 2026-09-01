@extends('layouts.app')

@section('content')

<title>Dashboard</title>

{{-- Show flash messages --}}
@include('common.alert')

<!-- Dashboard quick stats -->
<div class="stats-grid">

    <div class="stat-box" style="color:red">
        <div class="stat-label">Today's Bookings</div>

        <div class="stat-value" style="color:red">
            {{ App\Models\Booking::whereDate('pick_up_time', today())->count() }}
        </div>

        <div class="stat-label">
            {{ App\Models\Booking::where('status', 'in_progress')->whereDate('pick_up_time', today())->count() }}
            in progress
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-label">Total Vehicles</div>

        <div class="stat-value">
            {{ App\Models\Vehicle::count() }}
        </div>

        <div class="stat-label">
            {{ App\Models\Vehicle::where('status', 'maintenance')->count() }}
            need maintenance
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-label">Active Drivers</div>

        <div class="stat-value">
            {{ App\Models\Driver::where('status', 'active')->count() }}
        </div>

        <div class="stat-label">
            {{ App\Models\DriverDocument::whereDate('expiry_date', '<=', now()->addDays(30))->count() }}
            docs expiring
        </div>
    </div>

</div>


<!-- Dashboard quick actions -->
<h3 class="section-title">Quick Actions</h3>

<div class="grid">

    <div class="card">
        <a href="{{ route('bookings.create') }}">
            <div>
                <div class="card-title">New Booking</div>
                <div class="card-value">Create trip</div>
            </div>

            <i class="fas fa-plus-circle card-icon"></i>
        </a>
    </div>


    <div class="card">
        <a href="{{ route('vehicles.create') }}">
            <div>
                <div class="card-title">Add Vehicle</div>
                <div class="card-value">Register new</div>
            </div>

            <i class="fas fa-car card-icon"></i>
        </a>
    </div>


    <div class="card">
        <a href="{{ route('drivers.create') }}">
            <div>
                <div class="card-title">Add Driver</div>
                <div class="card-value">Register new</div>
            </div>

            <i class="fas fa-id-card card-icon"></i>
        </a>
    </div>

</div>


<!-- Recent bookings -->
<h3 class="section-title">Recent Bookings</h3>

<div class="recent-list">

    @forelse(App\Models\Booking::with(['vehicle'])->latest()->take(5)->get() as $booking)

        <div class="recent-item">

            <div>
                <strong>#{{ $booking->id }}</strong>
                -
                {{ $booking->guest_name }}

                @if($booking->service)
                    <span>({{ $booking->service }})</span>
                @endif
            </div>

            <div>
                <span class="status-badge status-{{ $booking->status }}">
                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>

        </div>

    @empty

        <div class="recent-item">
            <div class="text-muted">
                No recent bookings
            </div>
        </div>

    @endforelse

</div>


<!-- Document expiry alerts -->
<h3 class="section-title">Document Alerts</h3>

<div class="grid">

    <div class="card">
        <a href="/documents?filter=expiring">

            <div>
                <div class="card-title">Expiring Soon</div>

                <div class="card-value">
                    {{ App\Models\DriverDocument::whereDate('expiry_date', '<=', now()->addDays(30))
                        ->whereDate('expiry_date', '>=', now())
                        ->count() }}
                    Documents
                </div>
            </div>

            <i class="fas fa-exclamation-triangle card-icon"></i>

        </a>
    </div>


    <div class="card">
        <a href="/documents?filter=expired">

            <div>
                <div class="card-title">Expired</div>

                <div class="card-value">
                    {{ App\Models\DriverDocument::whereDate('expiry_date', '<', now())->count() }}
                    Documents
                </div>
            </div>

            <i class="fas fa-times-circle card-icon"></i>

        </a>
    </div>


    <div class="card">
        <a href="{{ route('vehicles.index') }}">

            <div>
                <div class="card-title">Vehicle Mulkiya</div>

                <div class="card-value">
                    {{ App\Models\Vehicle::whereDate('mulkiya_expiry_date', '<=', now()->addDays(30))->count() }}
                    Expiring
                </div>
            </div>

            <i class="fas fa-file-contract card-icon"></i>

        </a>
    </div>

</div>


<!-- System status -->
<h3 class="section-title">System Status</h3>

<div class="grid">

    <div class="card">
        <a href="{{ route('bookings.index') }}">

            <div>
                <div class="card-title">Pending Bookings</div>

                <div class="card-value">
                    {{ App\Models\Booking::where('status', 'pending')->count() }}
                </div>
            </div>

            <i class="fas fa-clock card-icon"></i>

        </a>
    </div>


    <div class="card">
        <a href="{{ route('vehicles.index') }}">

            <div>
                <div class="card-title">Active Vehicles</div>

                <div class="card-value">
                    {{ App\Models\Vehicle::where('status', 'active')->count() }}
                </div>
            </div>

            <i class="fas fa-car card-icon"></i>

        </a>
    </div>


    <div class="card">
        <a href="{{ route('drivers.index') }}">

            <div>
                <div class="card-title">Available Drivers</div>

                <div class="card-value">
                    {{ App\Models\Driver::where('status', 'active')->count() }}
                </div>
            </div>

            <i class="fas fa-id-card-alt card-icon"></i>

        </a>
    </div>

</div>

@endsection


<style>

/* Status badge styles */

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


/* Stats grid styles */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-box {
    background: rgba(26, 42, 58, 0.85);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

.stat-label {
    color: #a0aec0;
    font-size: 14px;
    margin-bottom: 8px;
}

.stat-value {
    color: #4ecdc4;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 5px;
}


/* Section title styles */

.section-title {
    color: #4ecdc4;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 40px 0 20px 0;
    border-bottom: 2px solid rgba(78, 205, 196, 0.3);
    padding-bottom: 10px;
}


/* Grid layout styles */

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}


/* Dashboard card styles */

.card {
    background: rgba(26, 42, 58, 0.85);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px;
    padding: 25px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    border-color: rgba(78, 205, 196, 0.3);
}

.card a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-decoration: none;
    color: inherit;
    height: 100%;
}

.card-title {
    color: #e8e8e8;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.card-value {
    color: #4ecdc4;
    font-size: 1.5rem;
    font-weight: 700;
}

.card-icon {
    font-size: 2.5rem;
    color: #4ecdc4;
    opacity: 0.8;
}


/* Recent booking styles */

.recent-list {
    background: rgba(26, 42, 58, 0.85);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 30px;
}

.recent-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: background 0.3s ease;
}

.recent-item:hover {
    background: rgba(255,255,255,0.03);
}

.recent-item:last-child {
    border-bottom: none;
}

.recent-item strong {
    color: #4ecdc4;
}


/* Responsive page styles */

@media (max-width: 768px) {

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .grid {
        grid-template-columns: 1fr;
    }

    .recent-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .stat-value {
        font-size: 2rem;
    }

    .card-value {
        font-size: 1.3rem;
    }

}

@media (max-width: 480px) {

    .stat-box,
    .card {
        padding: 20px;
    }

    .section-title {
        font-size: 1.3rem;
    }

}

</style>