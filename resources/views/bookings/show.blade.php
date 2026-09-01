@extends('layouts.app')

@section('title', 'Booking Details')
@section('header', 'Booking Details')

@section('content')

<div class="bookings-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title text-white">
                <i class="fas fa-calendar-check"></i>
                Booking #{{ $booking->id }}
            </h1>
        <div class="header-actions">
                {{-- Download trip sheet --}}
                <a href="{{ route('bookings.viewPdf', $booking) }}" class="btn btn-danger" target=_blank>
                    <i class="fas fa-file-pdf"></i>Trip Sheet PDF
                </a>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i> All Bookings
            </a>

            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-primary ml-2">
                <i class="fas fa-edit"></i> Edit Booking
            </a>
        </div>
    </div>
</div>

{{-- Show alert messages --}}
@include('common.alert')

<div class="row">
    <div class="col-lg-8">

        {{-- Booking summary --}}
        <div class="card mb-4">
            <div class="card-header bg-primary">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-info-circle"></i> Booking Summary
                </h5>
            </div>

            <div class="card-body text-white bg-dark">
                <div class="row">
                    <div class="col-md-6">

                        <div class="detail-item">
                            <label>Booking ID:</label>
                            <span>#{{ $booking->id }}</span>
                        </div>

                        <div class="detail-item">
                            <label>Status:</label>
                            <span class="badge badge-{{
                                $booking->status == 'completed' ? 'success' :
                                ($booking->status == 'confirmed' ? 'primary' :
                                ($booking->status == 'in_progress' ? 'info' :
                                ($booking->status == 'cancelled' ? 'danger' : 'warning')))
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <label>Service Type:</label>
                            <span>{{ $booking->service }}</span>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="detail-item">
                            <label>Created On:</label>
                            <span>{{ $booking->created_at->format('M d, Y h:i A') }}</span>
                        </div>

                        <div class="detail-item">
                            <label>Last Updated:</label>
                            <span>{{ $booking->updated_at->format('M d, Y h:i A') }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Cancellation reason --}}
        @if($booking->status == 'cancelled' && $booking->cancel_reason)
        <div class="card mb-4">
            <div class="card-header bg-danger">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-ban"></i> Cancellation Reason
                </h5>
            </div>

            <div class="card-body text-white bg-dark">
                <p>{{ $booking->cancel_reason }}</p>
            </div>
        </div>
        @endif

        {{-- Trip details --}}
        <div class="card mb-4">
            <div class="card-header bg-info">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-route"></i> Trip Details
                </h5>
            </div>

            <div class="card-body text-white bg-dark">
                <div class="row">

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Pickup Time:</label>
                            <span>
                                {{ \Carbon\Carbon::parse($booking->pick_up_time)->format('M d, Y h:i A') }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <label>Pickup Location:</label>
                            <span>{{ $booking->pick_up_location }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Drop-off Time:</label>
                            <span>
                                {{ $booking->drop_off_time?->format('M d, Y h:i A') ?? 'N/A' }}
                            </span>
                        </div>

                        <div class="detail-item">
                            <label>Drop-off Location:</label>
                            <span>{{ $booking->drop_off_location }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Special instructions --}}
        <div class="card mb-4">
            <div class="card-header bg-secondary">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-sticky-note"></i> Special Instructions
                </h5>
            </div>

            <div class="card-body text-white bg-dark">
                @if($booking->special_instructions)
                    <p>{{ $booking->special_instructions }}</p>
                @else
                    <p class="text-muted">No special instructions provided.</p>
                @endif
            </div>
        </div>

        {{-- Guest information --}}
        <div class="card mb-4">
            <div class="card-header bg-success">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-user"></i> Guest Information
                </h5>
            </div>

            <div class="card-body text-white bg-dark">
                <div class="row">

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Guest Name:</label>
                            <span>{{ $booking->guest_name }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Contact Number:</label>
                            <span>{{ $booking->guest_contact_number }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-4">

        {{-- Vehicle and driver --}}
        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h5 class="card-title mb-0 text-dark">
                    <i class="fas fa-car"></i> Vehicle & Driver
                </h5>
            </div>

            <div class="card-body text-white bg-dark">

                <div class="detail-item">
                    <label>Vehicle:</label>
                    <span>
                        @if($booking->vehicle)
                            {{ $booking->vehicle->vehicle_name }}
                            ({{ $booking->vehicle->vehicle_plate_no }})
                        @else
                            Not assigned
                        @endif
                    </span>
                </div>

                <div class="detail-item">
                    <label>Driver:</label>
                    <span>
                        @if($booking->driver)
                            {{ $booking->driver->name }}
                            ({{ $booking->driver->contact_no }})
                        @else
                            Not assigned
                        @endif
                    </span>
                </div>

            </div>
        </div>

        {{-- Payment information --}}
        <div class="card mb-4">
            <div class="card-header bg-dark">
                <h5 class="card-title mb-0 text-white">
                    <i class="fas fa-money-bill-wave"></i> Payment Information
                </h5>
            </div>

            <div class="card-body text-white bg-secondary">

                <div class="detail-item">
                    <label>Payment Method:</label>
                    <span>
                        {{ $booking->payment_method
                            ? ucfirst(str_replace('_', ' ', $booking->payment_method))
                            : 'N/A'
                        }}
                    </span>
                </div>

                <div class="detail-item">
                    <label>Basic Amount:</label>
                    <span>
                        AED {{ number_format($booking->basic_amount, 2) }}
                    </span>
                </div>

                <div class="detail-item">
                    <label>Extra Hours:</label>
                    <span>{{ $booking->no_of_extra_hrs }} hrs</span>
                </div>

                <div class="detail-item">
                    <label>Extra Hours Amount:</label>
                    <span>
                        AED {{ number_format($booking->extra_hrs_amount, 2) }}
                    </span>
                </div>

                <div class="detail-item">
                    <label>Other Amounts:</label>
                    <span>
                        AED {{ number_format($booking->other_amounts, 2) }}
                    </span>
                </div>

                <hr class="bg-light">

                <div class="detail-item total-amount">
                    <label>Total Amount:</label>
                    <span>
                        AED {{ number_format($booking->gross_total, 2) }}
                    </span>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Action Buttons --}}
<div class="row mt-5" style="margin-top: 40px !important;">
    <div class="col-12">
        <div class="d-flex justify-content-start flex-wrap" style="gap: 10px;">

            {{-- Confirm Booking --}}
            @if($booking->status == 'pending')
            <form action="{{ route('bookings.updateStatus', $booking->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="confirmed">

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Confirm Booking
                </button>
            </form>
            @endif

            {{-- Start Trip --}}
            @if($booking->status == 'confirmed')
            <form action="{{ route('bookings.updateStatus', $booking->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="in_progress">

                <button type="submit" class="btn btn-info">
                    <i class="fas fa-play-circle"></i> Start Trip
                </button>
            </form>
            @endif

            {{-- Complete Trip --}}
            @if($booking->status == 'in_progress')
            <form action="{{ route('bookings.updateStatus', $booking->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="completed">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-flag-checkered"></i> Complete Trip
                </button>
            </form>
            @endif

            {{-- Cancel & Delete --}}
            @if($booking->status != 'completed')

                @if($booking->status != 'cancelled')
                <button type="button"
                        class="btn btn-danger cancel-booking-trigger"
                        data-bookingid="{{ $booking->id }}">
                    <i class="fas fa-times-circle"></i> Cancel Booking
                </button>
                @endif

                <form action="{{ route('bookings.destroy', $booking->id) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger"
                            onclick="return confirm('Are you sure you want to delete this booking?')">
                        <i class="fas fa-trash"></i> Delete Booking
                    </button>
                </form>

            @endif

            {{-- Reopen Booking --}}
            @if($booking->status == 'cancelled')
            <form action="{{ route('bookings.updateStatus', $booking->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="pending">

                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-undo"></i> Reopen Booking
                </button>
            </form>
            @endif

        </div>
    </div>
</div>
 

</div>

{{-- Cancel Booking Modal --}}

<div class="modal" id="cancelBookingModal" tabindex="-1" aria-hidden="true" style="display: none;">

 
<div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">
                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                Cancel Booking
            </h5>

            <button type="button" class="close-btn" aria-label="Close">
                ×
            </button>
        </div>

        <form id="cancelBookingForm" method="POST">

            @csrf
            @method('PATCH')

            <input type="hidden" name="status" value="cancelled">

            <div class="modal-body">

                <p>
                    Are you sure you want to cancel booking for
                    <strong class="text-warning">
                        {{ $booking->guest_name }}
                    </strong>?
                </p>

                <div class="form-group">
                    <label for="cancel_reason" class="form-label">
                        Cancellation Reason *
                    </label>

                    <textarea class="form-control"
                              id="cancel_reason"
                              name="cancel_reason"
                              rows="3"
                              placeholder="Please provide a reason for cancellation..."
                              required></textarea>

                    <small class="form-text text-muted">
                        This reason will be recorded with the booking.
                    </small>
                </div>

                <p class="text-danger mt-3">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    This action cannot be undone.
                </p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary cancel-btn">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>

                <button type="submit" class="btn btn-danger confirm-cancel-btn">
                    <i class="fas fa-ban me-1"></i> Confirm Cancellation
                </button>

            </div>

        </form>

    </div>
</div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {

    const cancelModal = document.getElementById('cancelBookingModal');
    const cancelForm = document.getElementById('cancelBookingForm');
    const closeBtn = document.querySelector('.close-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const cancelReasonInput = document.getElementById('cancel_reason');

    let currentBookingId = null;

    // Cancel button click handler
    document.querySelectorAll('.cancel-booking-trigger').forEach(button => {

        button.addEventListener('click', function() {

            currentBookingId = this.getAttribute('data-bookingid');

            cancelReasonInput.value = '';

            cancelForm.action =
                "{{ route('bookings.updateStatus', ':id') }}"
                .replace(':id', currentBookingId);

            cancelModal.style.display = 'block';
            document.body.classList.add('modal-open');

            setTimeout(() => {
                cancelReasonInput.focus();
            }, 300);
        });

    });

    // Form submission validation
    cancelForm.addEventListener('submit', function(e) {

        if (!cancelReasonInput.value.trim()) {

            e.preventDefault();

            cancelReasonInput.focus();

            alert('Please provide a cancellation reason.');

            return false;
        }

    });

    // Close modal
    function closeModal() {

        cancelModal.style.display = 'none';

        document.body.classList.remove('modal-open');

        currentBookingId = null;
    }

    closeBtn.addEventListener('click', closeModal);

    cancelBtn.addEventListener('click', closeModal);

    cancelModal.addEventListener('click', function(event) {

        if (event.target === this) {
            closeModal();
        }

    });

    document.addEventListener('keydown', function(event) {

        if (
            event.key === 'Escape' &&
            cancelModal.style.display === 'block'
        ) {
            closeModal();
        }

    });

});
</script>

@endpush

@push('styles')

<style>

.detail-item {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.detail-item label {
    font-weight: 700;
    color: #f8f9fa;
    margin: 0;
    white-space: nowrap;
}

.detail-item span {
    color: #ffffff;
    text-align: left;
    word-break: break-word;
}

.detail-item .badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 12px;
    min-width: 0;
    text-align: center;
}

.badge-success {
    background-color: #38c172;
    color: #fff;
}

.badge-primary {
    background-color: #3490dc;
    color: #fff;
}

.badge-info {
    background-color: #6cb2eb;
    color: #fff;
}

.badge-danger {
    background-color: #ff6b6b;
    color: #fff;
}

.badge-warning {
    background-color: #f6993f;
    color: #fff;
}

.total-amount {
    font-size: 1.1rem;
    font-weight: bold;
    color: #4ade80;
    padding-top: 10px;
    border-top: 1px solid #6c757d;
}

.card-header {
    font-weight: 600;
}

.page-title {
    font-weight: 600;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn i {
    margin-right: 5px;
}

body {
    background-color: #343a40;
    color: #ffffff;
}

.card {
    border: 1px solid #495057;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
}

.card-body {
    border-radius: 0 0 0.25rem 0.25rem;
}

/* Modal styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    display: none;
    z-index: 10000;
    overflow: hidden;
}

.modal-dialog {
    max-width: 500px;
    margin: 100px auto;
}

.modal-content {
    background: rgba(26, 42, 58, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    color: #e8e8e8;
}

.modal-header {
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    color: #ff6b6b;
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
    background: rgba(255,255,255,0.1);
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 1.5rem;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.form-control {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    color: #e8e8e8;
}

.form-control:focus {
    background: rgba(255,255,255,0.12);
    border-color: #4ecdc4;
    box-shadow: 0 0 0 2px rgba(78, 205, 196, 0.25);
    color: #e8e8e8;
}

.form-label {
    color: #a0aec0;
    font-weight: 600;
}

.modal-open {
    overflow: hidden;
}

@media (max-width: 768px) {

    .header-actions {
        flex-wrap: wrap;
        gap: 10px;
    }

    .header-actions .btn {
        margin-bottom: 5px;
    }

}

@media (max-width: 576px) {

    .header-actions {
        flex-direction: column;
        width: 100%;
    }

    .header-actions .btn {
        width: 100%;
        margin-bottom: 10px;
    }

}

</style>

@endpush
