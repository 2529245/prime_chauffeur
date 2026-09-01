@extends('layouts.app')

@section('title', 'Bookings List')
@section('header', 'Bookings Management')

@section('content')

<div class="bookings-container">

    {{-- Page header --}}

    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title">
                <i class="fas fa-calendar-check"></i>
                Bookings Management
            </h1>

            <div class="header-actions">

                <a
                    href="{{ route('bookings.create') }}"
                    class="btn btn-primary"
                >
                    <i class="fas fa-plus"></i>
                    New Booking
                </a>

            </div>

        </div>

    </div>


    {{-- Show alert messages --}}

    @include('common.alert')


    {{-- Booking filters --}}

    <div class="filters-card mb-4">

        <div class="filters-header">

            <h3>
                <i class="fas fa-filter"></i>
                Filters
            </h3>

            <button
                type="button"
                class="btn btn-sm btn-outline-secondary"
                id="toggleFilters"
            >
                <i class="fas fa-sliders-h"></i>
                Show Filters
            </button>

        </div>


        <div
            class="filters-body"
            id="filtersBody"
        >

            <form
                action="{{ route('bookings.index') }}"
                method="GET"
                id="filterForm"
            >

                <div class="row">

                    {{-- Status filter --}}

                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="status">
                                Status
                            </label>

                            <select
                                class="form-control"
                                id="status"
                                name="status"
                            >

                                <option value="">
                                    All Statuses
                                </option>

                                <option
                                    value="pending"
                                    {{ request('status') == 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="confirmed"
                                    {{ request('status') == 'confirmed' ? 'selected' : '' }}
                                >
                                    Confirmed
                                </option>

                                <option
                                    value="in_progress"
                                    {{ request('status') == 'in_progress' ? 'selected' : '' }}
                                >
                                    In Progress
                                </option>

                                <option
                                    value="completed"
                                    {{ request('status') == 'completed' ? 'selected' : '' }}
                                >
                                    Completed
                                </option>

                                <option
                                    value="cancelled"
                                    {{ request('status') == 'cancelled' ? 'selected' : '' }}
                                >
                                    Cancelled
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- Date range filter --}}

                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="date_range">
                                Date Range
                            </label>

                            <select
                                class="form-control"
                                id="date_range"
                                name="date_range"
                            >

                                <option value="">
                                    Custom Range
                                </option>

                                <option
                                    value="today"
                                    {{ request('date_range') == 'today' ? 'selected' : '' }}
                                >
                                    Today
                                </option>

                                <option
                                    value="yesterday"
                                    {{ request('date_range') == 'yesterday' ? 'selected' : '' }}
                                >
                                    Yesterday
                                </option>

                                <option
                                    value="this_week"
                                    {{ request('date_range') == 'this_week' ? 'selected' : '' }}
                                >
                                    This Week
                                </option>

                                <option
                                    value="last_week"
                                    {{ request('date_range') == 'last_week' ? 'selected' : '' }}
                                >
                                    Last Week
                                </option>

                                <option
                                    value="this_month"
                                    {{ request('date_range') == 'this_month' ? 'selected' : '' }}
                                >
                                    This Month
                                </option>

                                <option
                                    value="last_month"
                                    {{ request('date_range') == 'last_month' ? 'selected' : '' }}
                                >
                                    Last Month
                                </option>

                                <option
                                    value="this_year"
                                    {{ request('date_range') == 'this_year' ? 'selected' : '' }}
                                >
                                    This Year
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- Start date filter --}}

                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="start_date">
                                From Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="start_date"
                                name="start_date"
                                value="{{ request('start_date') }}"
                            >

                        </div>

                    </div>


                    {{-- End date filter --}}

                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="end_date">
                                To Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="end_date"
                                name="end_date"
                                value="{{ request('end_date') }}"
                            >

                        </div>

                    </div>

                </div>


                {{-- Search and filter actions --}}

                <div class="row mt-3">

                    {{-- Search bookings --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="search">
                                Search
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="search"
                                name="search"
                                placeholder="Search by guest name, contact number, or booking ID"
                                value="{{ request('search') }}"
                            >

                        </div>

                    </div>


                    {{-- Filter buttons --}}

                    <div class="col-md-6">

                        <div class="form-group d-flex align-items-end gap-2">

                            {{-- Apply filters --}}

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-search"></i>
                                Apply Filters
                            </button>


                            {{-- Export booking CSV --}}

                            <a
                                href="{{ route('bookings.export') }}"
                                class="btn btn-success"
                                id="exportCsvBtn"
                            >
                                <i class="fas fa-file-csv"></i>
                                Export CSV
                            </a>


                            {{-- Clear filters --}}

                            <a
                                href="{{ route('bookings.index') }}"
                                class="btn btn-secondary"
                            >
                                <i class="fas fa-times"></i>
                                Clear
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Bookings table --}}

    <div class="table-card">

        <div class="table-header">

            <h2>

                @if(
                    request()->anyFilled([
                        'status',
                        'start_date',
                        'end_date',
                        'search',
                        'date_range'
                    ])
                )

                    Filtered Bookings
                    ({{ $bookings->total() }})

                @else

                    All Bookings
                    ({{ $bookings->total() }})

                @endif

            </h2>


            <div class="table-actions">

                <div class="search-box">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        placeholder="Quick search..."
                        id="quickSearch"
                    >

                </div>

            </div>

        </div>


        {{-- TABLE --}}

        <div class="table-responsive">

            <table
                class="modern-table"
                id="bookingsTable"
            >

                <thead>

                    <tr>

                        <th data-sort="id">
                            <span>Booking ID</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="guest">
                            <span>Guest</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="pickup">
                            <span>Pickup Time</span>
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

                        <th data-sort="amount">
                            <span>Amount</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($bookings as $booking)

                        <tr
                            data-pickup-date="{{ optional($booking->pick_up_time)->format('Y-m-d') }}"
                            data-status="{{ $booking->status }}"
                            data-search="{{ $booking->guest_name }} {{ $booking->guest_contact_number }} {{ $booking->id }}"
                        >

                            {{-- Booking ID --}}

                            <td>
                                #{{ $booking->id }}
                            </td>


                            {{-- Guest details --}}

                            <td>

                                <strong>
                                    {{ $booking->guest_name }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    {{ $booking->guest_contact_number }}
                                </small>

                            </td>


                            {{-- PICKUP --}}

                            <td>

                                {{ optional($booking->pick_up_time)->format('M d, Y H:i') }}

                            </td>


                            {{-- Vehicle field --}}

                            <td>

                                {{ $booking->vehicle?->vehicle_name ?? 'N/A' }}

                            </td>


                            {{-- Driver field --}}

                            <td>

                                {{ $booking->driver?->name ?? 'N/A' }}

                            </td>


                            {{-- Status filter --}}

                            <td>

                                <span
                                    class="status-badge status-{{ $booking->status }}"
                                >

                                    <i class="fas fa-circle"></i>

                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}

                                </span>

                            </td>


                            {{-- AMOUNT --}}

                            <td>

                                AED
                                {{ number_format($booking->gross_total ?? 0, 2) }}

                            </td>


                            {{-- Booking actions --}}

                            <td>

                                <div class="action-buttons">

                                    {{-- View booking --}}

                                    <a
                                        href="{{ route('bookings.show', $booking) }}"
                                        class="btn-action btn-info"
                                        title="View Booking"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>


                                    {{-- Edit booking --}}

                                    <a
                                        href="{{ route('bookings.edit', $booking) }}"
                                        class="btn-action btn-primary"
                                        title="Edit Booking"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    {{-- DELETE --}}

                                    <button
                                        type="button"
                                        class="btn-action btn-danger booking-delete-trigger"
                                        title="Delete Booking"
                                        data-bookingid="{{ $booking->id }}"
                                        data-guestname="{{ $booking->guest_name }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-4"
                            >

                                <i
                                    class="fas fa-calendar-times fa-2x mb-2"
                                ></i>

                                <br>

                                No bookings found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        <div class="table-footer">

            <div class="table-info">

                @if($bookings->total() > 0)

                    Showing
                    {{ $bookings->firstItem() }}
                    to
                    {{ $bookings->lastItem() }}
                    of
                    {{ $bookings->total() }}
                    entries

                @else

                    No entries

                @endif

            </div>


            <div class="pagination">

                {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>


{{-- DELETE MODAL --}}

<div
    class="modal"
    id="bookingDeleteModal"
    tabindex="-1"
    aria-hidden="true"
    style="display: none;"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>

                    Confirm Booking Deletion

                </h5>

                <button
                    type="button"
                    class="close-btn"
                    aria-label="Close"
                >
                    ×
                </button>

            </div>


            <div class="modal-body">

                <p>

                    Are you sure you want to delete booking for

                    <strong
                        id="displayGuestName"
                        class="text-warning"
                    ></strong>?

                </p>

                <p class="text-danger">

                    <i class="fas fa-exclamation-circle me-1"></i>

                    This action cannot be undone.

                </p>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary cancel-btn"
                >
                    <i class="fas fa-times me-1"></i>
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-danger confirm-delete-btn"
                >
                    <i class="fas fa-trash me-1"></i>
                    Delete Booking
                </button>

            </div>

        </div>

    </div>

</div>


{{-- HIDDEN DELETE FORM --}}

<form
    id="globalDeleteForm"
    method="POST"
    style="display: none;"
>

    @csrf

    @method('DELETE')

</form>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ELEMENTS */

    const toggleFilters =
        document.getElementById('toggleFilters');

    const filtersBody =
        document.getElementById('filtersBody');

    const filterForm =
        document.getElementById('filterForm');

    const statusInput =
        document.getElementById('status');

    const dateRangeInput =
        document.getElementById('date_range');

    const startDateInput =
        document.getElementById('start_date');

    const endDateInput =
        document.getElementById('end_date');

    const searchInput =
        document.getElementById('search');

    const exportCsvBtn =
        document.getElementById('exportCsvBtn');


    /* FILTER VISIBILITY */

    const filtersApplied =
        (
            statusInput &&
            statusInput.value
        )
        ||
        (
            dateRangeInput &&
            dateRangeInput.value
        )
        ||
        (
            startDateInput &&
            startDateInput.value
        )
        ||
        (
            endDateInput &&
            endDateInput.value
        )
        ||
        (
            searchInput &&
            searchInput.value
        );


    if (filtersApplied) {

        filtersBody.style.display = 'block';

        toggleFilters.innerHTML =
            '<i class="fas fa-sliders-h"></i> Hide Filters';

    } else {

        filtersBody.style.display = 'none';

        toggleFilters.innerHTML =
            '<i class="fas fa-sliders-h"></i> Show Filters';
    }


    /* TOGGLE FILTERS */

    toggleFilters.addEventListener(
        'click',
        function () {

            const isHidden =
                filtersBody.style.display === 'none';

            filtersBody.style.display =
                isHidden
                    ? 'block'
                    : 'none';

            this.innerHTML =
                isHidden
                    ? '<i class="fas fa-sliders-h"></i> Hide Filters'
                    : '<i class="fas fa-sliders-h"></i> Show Filters';
        }
    );


    /* Date range filter */

    if (dateRangeInput) {

        dateRangeInput.addEventListener(
            'change',
            function () {

                const today =
                    new Date();

                let startDate = '';

                let endDate = '';


                switch (this.value) {

                    case 'today':

                        startDate =
                            formatDate(today);

                        endDate =
                            startDate;

                        break;


                    case 'yesterday':

                        const yesterday =
                            new Date(today);

                        yesterday.setDate(
                            yesterday.getDate() - 1
                        );

                        startDate =
                            formatDate(yesterday);

                        endDate =
                            startDate;

                        break;


                    case 'this_week':

                        const startOfWeek =
                            new Date(today);

                        const day =
                            startOfWeek.getDay();

                        const diff =
                            day === 0
                                ? 6
                                : day - 1;

                        startOfWeek.setDate(
                            startOfWeek.getDate() - diff
                        );

                        const endOfWeek =
                            new Date(startOfWeek);

                        endOfWeek.setDate(
                            startOfWeek.getDate() + 6
                        );

                        startDate =
                            formatDate(startOfWeek);

                        endDate =
                            formatDate(endOfWeek);

                        break;


                    case 'last_week':

                        const currentMonday =
                            new Date(today);

                        const currentDay =
                            currentMonday.getDay();

                        const currentDiff =
                            currentDay === 0
                                ? 6
                                : currentDay - 1;

                        currentMonday.setDate(
                            currentMonday.getDate() - currentDiff
                        );

                        const lastWeekStart =
                            new Date(currentMonday);

                        lastWeekStart.setDate(
                            currentMonday.getDate() - 7
                        );

                        const lastWeekEnd =
                            new Date(lastWeekStart);

                        lastWeekEnd.setDate(
                            lastWeekStart.getDate() + 6
                        );

                        startDate =
                            formatDate(lastWeekStart);

                        endDate =
                            formatDate(lastWeekEnd);

                        break;


                    case 'this_month':

                        startDate =
                            formatDate(
                                new Date(
                                    today.getFullYear(),
                                    today.getMonth(),
                                    1
                                )
                            );

                        endDate =
                            formatDate(
                                new Date(
                                    today.getFullYear(),
                                    today.getMonth() + 1,
                                    0
                                )
                            );

                        break;


                    case 'last_month':

                        const firstDayLastMonth =
                            new Date(
                                today.getFullYear(),
                                today.getMonth() - 1,
                                1
                            );

                        const lastDayLastMonth =
                            new Date(
                                today.getFullYear(),
                                today.getMonth(),
                                0
                            );

                        startDate =
                            formatDate(
                                firstDayLastMonth
                            );

                        endDate =
                            formatDate(
                                lastDayLastMonth
                            );

                        break;


                    case 'this_year':

                        startDate =
                            formatDate(
                                new Date(
                                    today.getFullYear(),
                                    0,
                                    1
                                )
                            );

                        endDate =
                            formatDate(
                                new Date(
                                    today.getFullYear(),
                                    11,
                                    31
                                )
                            );

                        break;


                    default:

                        startDate = '';

                        endDate = '';

                        break;
                }


                startDateInput.value =
                    startDate;

                endDateInput.value =
                    endDate;

            }
        );
    }


    /* FORMAT DATE */

    function formatDate(date) {

        const year =
            date.getFullYear();

        const month =
            String(
                date.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                date.getDate()
            ).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }


    /* DATE VALIDATION */

    if (startDateInput) {

        startDateInput.addEventListener(
            'change',
            function () {

                if (
                    this.value &&
                    endDateInput.value &&
                    this.value > endDateInput.value
                ) {

                    endDateInput.value =
                        this.value;
                }

            }
        );
    }


    if (endDateInput) {

        endDateInput.addEventListener(
            'change',
            function () {

                if (
                    this.value &&
                    startDateInput.value &&
                    this.value < startDateInput.value
                ) {

                    startDateInput.value =
                        this.value;
                }

            }
        );
    }


    /* Export booking CSV */

    if (exportCsvBtn) {

        exportCsvBtn.addEventListener(
            'click',
            function (event) {

                event.preventDefault();


                const params =
                    new URLSearchParams();


                /* Status filter */

                if (
                    statusInput &&
                    statusInput.value
                ) {

                    params.set(
                        'status',
                        statusInput.value
                    );
                }


                /* Date range filter */

                if (
                    dateRangeInput &&
                    dateRangeInput.value
                ) {

                    params.set(
                        'date_range',
                        dateRangeInput.value
                    );
                }


                /* Start date filter */

                if (
                    startDateInput &&
                    startDateInput.value
                ) {

                    params.set(
                        'start_date',
                        startDateInput.value
                    );
                }


                /* End date filter */

                if (
                    endDateInput &&
                    endDateInput.value
                ) {

                    params.set(
                        'end_date',
                        endDateInput.value
                    );
                }


                /* Search bookings */

                if (
                    searchInput &&
                    searchInput.value.trim()
                ) {

                    params.set(
                        'search',
                        searchInput.value.trim()
                    );
                }


                /* BUILD EXPORT URL */

                const exportUrl =
                    "{{ route('bookings.export') }}";

                const queryString =
                    params.toString();

                const finalUrl =
                    queryString
                        ? exportUrl + '?' + queryString
                        : exportUrl;


                /* START DOWNLOAD */

                window.location.href =
                    finalUrl;

            }
        );
    }


    /* QUICK SEARCH */

    const quickSearch =
        document.getElementById(
            'quickSearch'
        );

    const table =
        document.getElementById(
            'bookingsTable'
        );


    if (
        quickSearch &&
        table
    ) {

        const rows =
            table.querySelectorAll(
                'tbody tr'
            );


        quickSearch.addEventListener(
            'input',
            function () {

                const searchTerm =
                    this.value
                        .toLowerCase()
                        .trim();


                rows.forEach(
                    row => {

                        const searchData =
                            (
                                row.getAttribute(
                                    'data-search'
                                ) || ''
                            )
                            .toLowerCase();


                        row.style.display =
                            searchData.includes(
                                searchTerm
                            )
                                ? ''
                                : 'none';

                    }
                );
            }
        );
    }


    /* DELETE MODAL */

    const deleteModal =
        document.getElementById(
            'bookingDeleteModal'
        );

    const displayGuestName =
        document.getElementById(
            'displayGuestName'
        );

    const closeBtn =
        document.querySelector(
            '.close-btn'
        );

    const cancelBtn =
        document.querySelector(
            '.cancel-btn'
        );

    const confirmDeleteBtn =
        document.querySelector(
            '.confirm-delete-btn'
        );

    const globalDeleteForm =
        document.getElementById(
            'globalDeleteForm'
        );

    let currentBookingId =
        null;


    /* OPEN DELETE MODAL */

    document
        .querySelectorAll(
            '.booking-delete-trigger'
        )
        .forEach(
            button => {

                button.addEventListener(
                    'click',
                    function () {

                        currentBookingId =
                            this.getAttribute(
                                'data-bookingid'
                            );


                        displayGuestName.textContent =
                            this.getAttribute(
                                'data-guestname'
                            );


                        deleteModal.style.display =
                            'block';


                        document.body.classList.add(
                            'modal-open'
                        );

                    }
                );

            }
        );


    /* CONFIRM DELETE */

    if (confirmDeleteBtn) {

        confirmDeleteBtn.addEventListener(
            'click',
            function () {

                if (currentBookingId) {

                    globalDeleteForm.action =
                        "{{ route('bookings.destroy', ':id') }}"
                            .replace(
                                ':id',
                                currentBookingId
                            );

                    globalDeleteForm.submit();

                }

            }
        );
    }


    /* CLOSE DELETE MODAL */

    [closeBtn, cancelBtn].forEach(
        function (element) {

            if (!element) {
                return;
            }

            element.addEventListener(
                'click',
                function () {

                    deleteModal.style.display =
                        'none';

                    document.body.classList.remove(
                        'modal-open'
                    );

                    currentBookingId =
                        null;

                }
            );

        }
    );


    /* CLICK OUTSIDE MODAL */

    if (deleteModal) {

        deleteModal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === this
                ) {

                    deleteModal.style.display =
                        'none';

                    document.body.classList.remove(
                        'modal-open'
                    );

                    currentBookingId =
                        null;

                }

            }
        );
    }


    /* ESCAPE KEY */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                deleteModal &&
                deleteModal.style.display === 'block'
            ) {

                deleteModal.style.display =
                    'none';

                document.body.classList.remove(
                    'modal-open'
                );

                currentBookingId =
                    null;

            }

        }
    );

});
</script>


<style>

/* Booking filters */

.filters-card {
    background: rgba(26, 42, 58, 0.85);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.05);
    overflow: hidden;
}

.filters-header {
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.filters-header h3 {
    color: #e8e8e8;
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.filters-body {
    display: none;
    padding: 20px;
}

.filters-body .form-group {
    margin-bottom: 0;
}

.filters-body label {
    color: #e8e8e8;
    font-weight: 500;
    margin-bottom: 6px;
}

.filters-body .form-control {
    min-height: 40px;
}


/* Trip sheet header */

.header-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}


/* SUCCESS BUTTON */

.btn-success {
    background: linear-gradient(
        135deg,
        #28a745 0%,
        #20c997 100%
    );

    color: #fff;

    border: 1px solid rgba(
        40,
        167,
        69,
        0.3
    );

    box-shadow:
        0 4px 15px rgba(
            40,
            167,
            69,
            0.25
        );
}

.btn-success:hover {
    background: linear-gradient(
        135deg,
        #20c997 0%,
        #28a745 100%
    );

    color: #fff;

    box-shadow:
        0 6px 20px rgba(
            40,
            167,
            69,
            0.35
        );

    transform: translateY(-2px);
}


/* GAP */

.gap-2 {
    gap: 8px;
}


/* FORM */

.form-control {
    background:
        rgba(255,255,255,0.08);

    border:
        1px solid
        rgba(255,255,255,0.1);

    color: #e8e8e8;
}

.form-control:focus {
    background:
        rgba(255,255,255,0.12);

    border-color: #4ecdc4;

    box-shadow:
        0 0 0 2px
        rgba(78,205,196,0.25);

    color: #e8e8e8;
}


/* =========================================================
   DROPDOWN OPTIONS
   Same dark background as the form fields
========================================================= */

.form-control option {
    background: #1a2a3a;
    color: #e8e8e8;
}

.form-control option:checked {
    background: #1a2a3a;
    color: #e8e8e8;
}

.form-control option:hover {
    background: #1a2a3a;
    color: #e8e8e8;
}


/* DATE INPUT / SELECT DARK THEME */

select.form-control {
    background-color: rgba(255,255,255,0.08);
    color: #e8e8e8;
}

select.form-control:focus {
    background-color: rgba(255,255,255,0.12);
    color: #e8e8e8;
}

select.form-control option {
    background-color: #1a2a3a;
    color: #e8e8e8;
}


/* MODAL */

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    background-color:
        rgba(0,0,0,0.7);

    display: none;

    z-index: 10000;

    overflow: hidden;
}

.modal-dialog {
    max-width: 500px;
    margin: 100px auto;
}

.modal-content {
    background:
        rgba(26,42,58,0.95);

    backdrop-filter: blur(10px);

    border:
        1px solid
        rgba(255,255,255,0.1);

    border-radius: 16px;

    color: #e8e8e8;
}

.modal-header {
    border-bottom:
        1px solid
        rgba(255,255,255,0.1);

    padding: 1.5rem;

    display: flex;

    justify-content:
        space-between;

    align-items: center;
}

.modal-title {
    color: #3490dc;

    font-weight: 600;

    display: flex;

    align-items: center;

    margin: 0;
}

.close-btn {
    background: none;

    border: none;

    color: #a0aec0;

    font-size: 24px;

    cursor: pointer;

    padding: 0;

    width: 30px;

    height: 30px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 4px;
}

.close-btn:hover {
    color: #fff;

    background:
        rgba(255,255,255,0.1);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top:
        1px solid
        rgba(255,255,255,0.1);

    padding: 1.5rem;

    display: flex;

    gap: 12px;

    justify-content:
        flex-end;
}


/* MOBILE */

@media (max-width: 768px) {

    .filters-body .d-flex {
        flex-wrap: wrap;
    }

    .filters-body .btn {
        margin-bottom: 5px;
    }

    .modal-dialog {
        margin: 30px 15px;
    }

}

</style>

@endsection