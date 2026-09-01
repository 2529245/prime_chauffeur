@extends('layouts.app')

@section('title', 'Create New Booking')
@section('header', 'Create New Booking')

@section('content')

<div class="bookings-container">

    {{-- Page header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-calendar-plus"></i> Create New Booking
            </h1>

            <div class="header-actions">
                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Bookings
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf

                        {{-- Guest information --}}
                        <div class="row">
                            <div class="col-12">

                                <div class="form-section">

                                    <h4 class="section-title">
                                        <i class="fas fa-user"></i> Guest Information
                                    </h4>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="guest_name">Guest Name *</label>

                                                <input
                                                    type="text"
                                                    class="form-control @error('guest_name') is-invalid @enderror"
                                                    id="guest_name"
                                                    name="guest_name"
                                                    value="{{ old('guest_name') }}"
                                                    required
                                                >

                                                @error('guest_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="guest_contact_number">
                                                    Contact Number
                                                </label>

                                                <input
                                                    type="tel"
                                                    class="form-control @error('guest_contact_number') is-invalid @enderror"
                                                    id="guest_contact_number"
                                                    name="guest_contact_number"
                                                    value="{{ old('guest_contact_number') }}"
                                                >

                                                @error('guest_contact_number')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>


                        {{-- Trip details --}}
                        <div class="row mt-4">
                            <div class="col-12">

                                <div class="form-section">

                                    <h4 class="section-title">
                                        <i class="fas fa-route"></i> Trip Details
                                    </h4>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="pick_up_time">
                                                    Pickup Time *
                                                </label>

                                                <input
                                                    type="datetime-local"
                                                    class="form-control @error('pick_up_time') is-invalid @enderror"
                                                    id="pick_up_time"
                                                    name="pick_up_time"
                                                    value="{{ old('pick_up_time') }}"
                                                    required
                                                >

                                                @error('pick_up_time')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="drop_off_time">
                                                    Drop-off Time
                                                </label>

                                                <input
                                                    type="datetime-local"
                                                    class="form-control @error('drop_off_time') is-invalid @enderror"
                                                    id="drop_off_time"
                                                    name="drop_off_time"
                                                    value="{{ old('drop_off_time') }}"
                                                >

                                                @error('drop_off_time')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="pick_up_location">
                                                    Pickup Location *
                                                </label>

                                                <textarea
                                                    class="form-control @error('pick_up_location') is-invalid @enderror"
                                                    id="pick_up_location"
                                                    name="pick_up_location"
                                                    rows="2"
                                                    required
                                                >{{ old('pick_up_location') }}</textarea>

                                                @error('pick_up_location')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="drop_off_location">
                                                    Drop-off Location
                                                </label>

                                                <textarea
                                                    class="form-control @error('drop_off_location') is-invalid @enderror"
                                                    id="drop_off_location"
                                                    name="drop_off_location"
                                                    rows="2"
                                                >{{ old('drop_off_location') }}</textarea>

                                                @error('drop_off_location')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="service">
                                                    Service Type
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control @error('service') is-invalid @enderror"
                                                    id="service"
                                                    name="service"
                                                    value="{{ old('service') }}"
                                                >

                                                @error('service')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>


                        {{-- Vehicle and driver --}}
                        <div class="row mt-4">
                            <div class="col-12">

                                <div class="form-section">

                                    <h4 class="section-title">
                                        <i class="fas fa-car"></i> Vehicle & Driver
                                    </h4>

                                    <div class="row">

                                        {{-- Vehicle field --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="vehicle_id">
                                                    Vehicle
                                                </label>

                                                <select
                                                    class="form-control select2 @error('vehicle_id') is-invalid @enderror"
                                                    id="vehicle_id"
                                                    name="vehicle_id"
                                                >

                                                    <option value="">
                                                        Select Vehicle
                                                    </option>

                                                    @foreach($vehicles as $vehicle)

                                                        <option
                                                            value="{{ $vehicle->id }}"
                                                            {{ old('vehicle_id', request('vehicle_id')) == $vehicle->id ? 'selected' : '' }}
                                                        >
                                                            {{ $vehicle->vehicle_name }}
                                                            -
                                                            {{ $vehicle->vehicle_plate_no }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                                @error('vehicle_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>


                                        {{-- Driver field --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="driver_id">
                                                    Driver
                                                </label>

                                                <select
                                                    class="form-control select2 @error('driver_id') is-invalid @enderror"
                                                    id="driver_id"
                                                    name="driver_id"
                                                >

                                                    <option value="">
                                                        Select Driver
                                                    </option>

                                                    @foreach($drivers as $driver)

                                                        <option
                                                            value="{{ $driver->id }}"
                                                            {{ old(
                                                                'driver_id',
                                                                request('driver_id') ??
                                                                (isset($preselected_driver)
                                                                    ? $preselected_driver->id
                                                                    : null)
                                                            ) == $driver->id ? 'selected' : '' }}
                                                        >
                                                            {{ $driver->name }}
                                                            -
                                                            {{ $driver->contact_no }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                                @error('driver_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>


                        {{-- Special instructions --}}
                        <div class="row mt-4">
                            <div class="col-12">

                                <div class="form-section">

                                    <h4 class="section-title">
                                        <i class="fas fa-sticky-note"></i>
                                        Special Instructions
                                    </h4>

                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="special_instructions">
                                                    Special Instructions
                                                </label>

                                                <textarea
                                                    class="form-control @error('special_instructions') is-invalid @enderror"
                                                    id="special_instructions"
                                                    name="special_instructions"
                                                    rows="4"
                                                >{{ old('special_instructions') }}</textarea>

                                                @error('special_instructions')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>


                        {{-- Status filter --}}
                        <div class="row mt-4">

                            <div class="col-md-6">

                                <div class="form-group" style="padding: 0 10px;">

                                    <label for="status">
                                        Status
                                    </label>

                                    <select
                                        class="form-control @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                    >

                                        <option
                                            value="pending"
                                            {{ old('status') == 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="confirmed"
                                            {{ old('status') == 'confirmed' ? 'selected' : '' }}
                                        >
                                            Confirmed
                                        </option>

                                        <option
                                            value="in_progress"
                                            {{ old('status') == 'in_progress' ? 'selected' : '' }}
                                        >
                                            In Progress
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


                        {{-- Payment & Additional Charges --}}
                        <div class="row mt-4">
                            <div class="col-12">

                                <div class="form-section">

                                    <h4 class="section-title">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Payment & Charges
                                    </h4>

                                    <div class="row">

                                        {{-- Basic Amount --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="basic_amount">
                                                    Basic Amount (AED) *
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control @error('basic_amount') is-invalid @enderror"
                                                    id="basic_amount"
                                                    name="basic_amount"
                                                    value="{{ old('basic_amount') }}"
                                                    required
                                                >

                                                @error('basic_amount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>


                                        {{-- Extra Hours --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="no_of_extra_hrs">
                                                    Extra Hours
                                                </label>

                                                <input
                                                    type="number"
                                                    class="form-control @error('no_of_extra_hrs') is-invalid @enderror"
                                                    id="no_of_extra_hrs"
                                                    name="no_of_extra_hrs"
                                                    value="{{ old('no_of_extra_hrs', 0) }}"
                                                    min="0"
                                                >

                                                @error('no_of_extra_hrs')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>


                                        {{-- Extra Hours Amount --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="extra_hrs_amount">
                                                    Extra Hours Amount (AED)
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control @error('extra_hrs_amount') is-invalid @enderror"
                                                    id="extra_hrs_amount"
                                                    name="extra_hrs_amount"
                                                    value="{{ old('extra_hrs_amount', 0) }}"
                                                    min="0"
                                                >

                                                @error('extra_hrs_amount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>


                                        {{-- Other Amounts --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="other_amounts">
                                                    Other Amounts (AED)
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control @error('other_amounts') is-invalid @enderror"
                                                    id="other_amounts"
                                                    name="other_amounts"
                                                    value="{{ old('other_amounts', 0) }}"
                                                    min="0"
                                                >

                                                @error('other_amounts')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>


                                        {{-- Gross Total --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="gross_total">
                                                    Total Amount (AED)
                                                </label>

                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control bg-light"
                                                    id="gross_total"
                                                    name="gross_total"
                                                    readonly
                                                >

                                            </div>
                                        </div>


                                        {{-- Payment Method --}}
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding: 0 10px;">

                                                <label for="payment_method">
                                                    Payment Method
                                                </label>

                                                <select
                                                    class="form-control @error('payment_method') is-invalid @enderror"
                                                    id="payment_method"
                                                    name="payment_method"
                                                >

                                                    <option value="">
                                                        Select Payment Method
                                                    </option>

                                                    <option
                                                        value="cash"
                                                        {{ old('payment_method') == 'cash' ? 'selected' : '' }}
                                                    >
                                                        Cash
                                                    </option>

                                                    <option
                                                        value="credit"
                                                        {{ old('payment_method') == 'credit' ? 'selected' : '' }}
                                                    >
                                                        Credit
                                                    </option>

                                                    <option
                                                        value="bank_transfer"
                                                        {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}
                                                    >
                                                        Bank Transfer
                                                    </option>

                                                    <option
                                                        value="online"
                                                        {{ old('payment_method') == 'online' ? 'selected' : '' }}
                                                    >
                                                        Online Payment
                                                    </option>

                                                </select>

                                                @error('payment_method')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>


                        {{-- Form Actions --}}
                        <div class="form-actions mt-4 d-flex justify-content-end">

                            <a
                                href="{{ route('bookings.index') }}"
                                class="btn btn-secondary me-2"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-save"></i>
                                Create Booking
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection


@push('styles')

<link
    href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
    rel="stylesheet"
/>

@endpush


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function() {

    // Total Calculation
    const calculateTotal = function() {

        const basicAmount =
            parseFloat(
                document.getElementById('basic_amount')?.value
            ) || 0;

        const extraHrsAmount =
            parseFloat(
                document.getElementById('extra_hrs_amount')?.value
            ) || 0;

        const otherAmounts =
            parseFloat(
                document.getElementById('other_amounts')?.value
            ) || 0;

        document.getElementById('gross_total').value =
            (
                basicAmount +
                extraHrsAmount +
                otherAmounts
            ).toFixed(2);

    };


    [
        'basic_amount',
        'extra_hrs_amount',
        'other_amounts'
    ].forEach(id => {

        document
            .getElementById(id)
            ?.addEventListener('input', calculateTotal);

    });

    calculateTotal();


    // Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });


    // Validate pickup/dropoff
    const bookingForm =
        document.getElementById('bookingForm');

    bookingForm?.addEventListener('submit', function(e) {

        const pickupValue =
            document.getElementById('pick_up_time').value;

        const dropoffValue =
            document.getElementById('drop_off_time').value;

        if (pickupValue && dropoffValue) {

            const pickupTime =
                new Date(pickupValue);

            const dropoffTime =
                new Date(dropoffValue);

            if (dropoffTime <= pickupTime) {

                e.preventDefault();

                alert(
                    'Drop-off time must be after pick-up time.'
                );

                return false;
            }
        }

    });


    // Prevent past pickup time
    const now = new Date();

    const localDateTime =
        new Date(
            now.getTime() -
            now.getTimezoneOffset() * 60000
        )
        .toISOString()
        .slice(0, 16);

    document.getElementById('pick_up_time').min =
        localDateTime;

    document.getElementById('drop_off_time').min =
        localDateTime;

});

</script>

@endpush