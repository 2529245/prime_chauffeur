@extends('layouts.app')

@section('title', 'POS Machine Details')
@section('header', 'POS Machine Details')

@section('content')

<div class="assets-container">

    {{-- Page header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title">
                <i class="fas fa-cash-register"></i>
                POS Machine: {{ $posMachine->machine_id }}
            </h1>

            <div class="header-actions">
                <a href="{{ route('assets.pos-machines.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All POS Machines
                </a>

                <a href="{{ route('assets.pos-machines.edit', $posMachine->id) }}"
                   class="btn btn-primary ml-2">
                    <i class="fas fa-edit"></i> Edit POS Machine
                </a>
            </div>

        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="row">

        <div class="col-lg-8">

            {{-- POS machine details --}}
            <div class="card mb-4">

                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i>
                        POS Machine Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="detail-item">
                                <label>Merchant ID:</label>
                                <span>{{ $posMachine->machine_id }}</span>
                            </div>

                            <div class="detail-item">
                                <label>TID Number:</label>
                                <span>{{ $posMachine->machine_model ?? 'N/A' }}</span>
                            </div>

                            <div class="detail-item">
                                <label>Purchase Date:</label>
                                <span>
                                    {{ $posMachine->purchase_date
                                        ? $posMachine->purchase_date->format('M d, Y')
                                        : 'N/A'
                                    }}
                                </span>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="detail-item">

                                <label>Status:</label>

                                <span class="status-badge status-{{ $posMachine->status }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($posMachine->status) }}
                                </span>

                            </div>

                            <div class="detail-item">

                                <label>Warranty Expiry:</label>

                                <span class="{{ $posMachine->warranty_expiry && $posMachine->warranty_expiry->isPast() ? 'text-danger' : '' }}">

                                    {{ $posMachine->warranty_expiry
                                        ? $posMachine->warranty_expiry->format('M d, Y')
                                        : 'N/A'
                                    }}

                                    @if($posMachine->warranty_expiry && $posMachine->warranty_expiry->isPast())
                                        <i class="fas fa-exclamation-triangle ml-1"
                                           title="Expired"></i>
                                    @endif

                                </span>

                            </div>

                            <div class="detail-item">
                                <label>Created On:</label>
                                <span>
                                    {{ $posMachine->created_at->format('M d, Y h:i A') }}
                                </span>
                            </div>

                        </div>

                    </div>

                    @if($posMachine->notes)

                        <div class="row mt-3">

                            <div class="col-12">

                                <div class="detail-item">
                                    <label>Notes:</label>
                                    <span>{{ $posMachine->notes }}</span>
                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- Assignment history --}}
            <div class="card mb-4">

                <div class="card-header bg-info text-white">

                    <h5 class="card-title mb-0">
                        <i class="fas fa-history"></i>
                        Assignment History
                    </h5>

                </div>

                <div class="card-body">

                    @if($posMachine->assetAssignments->count() > 0)

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover w-100 text-white">

                                <thead class="thead-light">

                                    <tr>
                                        <th style="min-width:150px;">Assigned To</th>
                                        <th style="min-width:100px;">Type</th>
                                        <th style="min-width:120px;">Date Assigned</th>
                                        <th style="min-width:120px;">Date Returned</th>
                                        <th style="min-width:200px;">Notes</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($posMachine->assetAssignments as $assignment)

                                        <tr>

                                            <td>
                                                {{ optional($assignment->assignable)->name
                                                    ?? 'Unknown ' . class_basename($assignment->assignable_type)
                                                }}
                                            </td>

                                            <td>
                                                {{ class_basename($assignment->assignable_type) }}
                                            </td>

                                            <td>
                                                {{ $assignment->date_assigned->format('M d, Y') }}
                                            </td>

                                            <td>

                                                @if($assignment->date_returned)

                                                    {{ $assignment->date_returned->format('M d, Y') }}

                                                @else

                                                    <span class="status-badge status-valid">
                                                        Currently Assigned
                                                    </span>

                                                @endif

                                            </td>

                                            <td>
                                                {{ $assignment->notes ?? 'N/A' }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center text-muted">
                            <p>No assignment history found for this POS machine</p>
                        </div>

                    @endif

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            {{-- Current assignment --}}
            @php
                $currentAssignment = $posMachine->assetAssignments
                    ->whereNull('date_returned')
                    ->first();
            @endphp

            <div class="card mb-4">

                <div class="card-header {{ $currentAssignment ? 'bg-success' : 'bg-secondary' }} text-white">

                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-check"></i>
                        Current Assignment
                    </h5>

                </div>

                <div class="card-body">

                    @if($currentAssignment)

                        <div class="detail-item">

                            <label>Assigned To:</label>

                            <span>
                                {{ optional($currentAssignment->assignable)->name
                                    ?? 'Unknown ' . class_basename($currentAssignment->assignable_type)
                                }}
                            </span>

                        </div>

                        <div class="detail-item">

                            <label>Type:</label>

                            <span>
                                {{ class_basename($currentAssignment->assignable_type) }}
                            </span>

                        </div>

                        <div class="detail-item">

                            <label>Date Assigned:</label>

                            <span>
                                {{ $currentAssignment->date_assigned->format('M d, Y') }}
                            </span>

                        </div>

                    @else

                        <div class="text-center text-muted">
                            <p>This POS machine is not currently assigned to anyone</p>
                        </div>

                    @endif

                </div>

            </div>


            {{-- Available actions --}}
            <div class="card mb-4">

                <div class="card-header bg-warning text-dark">

                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog"></i>
                        Actions
                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-grid gap-2">

                        @if(!$currentAssignment)

                            <button class="btn btn-primary btn-block assign-pos-trigger">

                                <i class="fas fa-user-plus"></i>
                                Assign POS Machine

                            </button>

                        @else

                            <form action="{{ route('assets.return', $currentAssignment->id) }}"
                                  method="POST"
                                  class="d-grid">

                                @csrf

                                <button type="submit"
                                        class="btn btn-info btn-block"
                                        onclick="return confirm('Are you sure you want to return this POS machine?')">

                                    <i class="fas fa-undo"></i>
                                    Return POS Machine

                                </button>

                            </form>

                        @endif


                        <form action="{{ route('assets.pos-machines.destroy', $posMachine->id) }}"
                              method="POST"
                              class="d-grid">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-block"
                                    onclick="return confirm('Are you sure you want to delete this POS machine?')">

                                <i class="fas fa-trash"></i>
                                Delete POS Machine

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- Assign POS modal --}}
@if(!$currentAssignment)

<div class="modal"
     id="assignPosModal"
     tabindex="-1"
     aria-hidden="true"
     style="display: none;">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fas fa-user-plus text-primary me-2"></i>
                    Assign POS Machine

                </h5>

                <button type="button"
                        class="close-btn"
                        aria-label="Close">
                    ×
                </button>

            </div>


            <form action="{{ route('assets.assign') }}"
                  method="POST">

                @csrf

                <input type="hidden"
                       name="asset_type"
                       value="pos_machine">

                <input type="hidden"
                       name="asset_id"
                       value="{{ $posMachine->id }}">


                <div class="modal-body">

                    {{-- Choose assignment type --}}
                    <div class="form-group">

                        <label for="assignable_type"
                               class="form-label">

                            Assign To Type *

                        </label>

                        <select class="form-control"
                                name="assignable_type"
                                id="assignable_type"
                                required>

                            <option value="">
                                Select Type
                            </option>

                            <option value="staff">
                                Staff
                            </option>

                            <option value="driver">
                                Driver
                            </option>

                        </select>

                    </div>


                    {{-- Choose assigned person --}}
                    <div class="form-group">

                        <label for="assignable_id"
                               class="form-label">

                            Assign To *

                        </label>

                        <select class="form-control"
                                name="assignable_id"
                                id="assignable_id"
                                required
                                disabled>

                            <option value="">
                                First select type
                            </option>

                        </select>

                    </div>


                    {{-- Choose assignment date --}}
                    <div class="form-group">

                        <label for="date_assigned"
                               class="form-label">

                            Date Assigned *

                        </label>

                        <input type="date"
                               class="form-control"
                               name="date_assigned"
                               value="{{ date('Y-m-d') }}"
                               required>

                    </div>


                    {{-- Add assignment notes --}}
                    <div class="form-group">

                        <label for="notes"
                               class="form-label">

                            Assignment Notes

                        </label>

                        <textarea class="form-control"
                                  name="notes"
                                  rows="3"
                                  placeholder="Optional notes about this assignment"></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary cancel-btn">

                        <i class="fas fa-times me-1"></i>
                        Cancel

                    </button>

                    <button type="submit"
                            class="btn btn-primary confirm-assign-btn">

                        <i class="fas fa-user-plus me-1"></i>
                        Assign POS Machine

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function() {

    const assignModal = document.getElementById('assignPosModal');

    const closeBtn = document.querySelector('.close-btn');

    const cancelBtn = document.querySelector('.cancel-btn');

    const assignableType = document.getElementById('assignable_type');

    const assignableId = document.getElementById('assignable_id');


    // Load staff and drivers

    const staffData = @json($staff ?? []);

    const driverData = @json($drivers ?? []);


    // Open assignment modal

    document.querySelectorAll('.assign-pos-trigger').forEach(button => {

        button.addEventListener('click', function() {

            if (!assignModal) {
                return;
            }

            assignableType.value = '';

            assignableId.innerHTML =
                '<option value="">First select type</option>';

            assignableId.disabled = true;

            assignModal.style.display = 'block';

            document.body.classList.add('modal-open');

            setTimeout(() => {

                if (assignableType) {
                    assignableType.focus();
                }

            }, 300);

        });

    });


    // Change assignment type

    if (assignableType) {

        assignableType.addEventListener('change', function() {

            const type = this.value;

            let label = '';

            let data = [];


            if (type === 'staff') {

                label = 'Staff';

                data = staffData;

            } else if (type === 'driver') {

                label = 'Driver';

                data = driverData;

            }


            if (!type) {

                assignableId.innerHTML =
                    '<option value="">First select type</option>';

                assignableId.disabled = true;

                return;

            }


            assignableId.innerHTML =
                '<option value="">Select ' + label + '</option>';

            assignableId.disabled = false;


            data.forEach(item => {

                const option =
                    document.createElement('option');

                option.value = item.id;

                let displayText =
                    item.name || 'Unknown';


                // Add staff details

                if (type === 'staff' && item.position) {

                    displayText +=
                        ' - ' + item.position;

                }


                // Add driver details

                if (type === 'driver' && item.contact_no) {

                    displayText +=
                        ' - ' + item.contact_no;

                }


                option.textContent = displayText;

                assignableId.appendChild(option);

            });

        });

    }


    // Close modal

    if (closeBtn) {

        closeBtn.addEventListener('click', function() {

            if (!assignModal) {
                return;
            }

            assignModal.style.display = 'none';

            document.body.classList.remove('modal-open');

        });

    }


    // Cancel modal

    if (cancelBtn) {

        cancelBtn.addEventListener('click', function() {

            if (!assignModal) {
                return;
            }

            assignModal.style.display = 'none';

            document.body.classList.remove('modal-open');

        });

    }


    // Close modal outside click

    if (assignModal) {

        assignModal.addEventListener('click', function(event) {

            if (event.target === this) {

                assignModal.style.display = 'none';

                document.body.classList.remove('modal-open');

            }

        });

    }


    // Close modal with Escape

    document.addEventListener('keydown', function(event) {

        if (
            event.key === 'Escape' &&
            assignModal &&
            assignModal.style.display === 'block'
        ) {

            assignModal.style.display = 'none';

            document.body.classList.remove('modal-open');

        }

    });

});

</script>

@endpush


@push('styles')

<style>

/* Dropdown text colors */

.modal .form-control option {

    color: #2d3748;

    background: #fff;

}


/* Detail Items */

.detail-item {

    display: flex;

    align-items: center;

    gap: 5px;

    margin-bottom: 12px;

}


.detail-item label {

    font-weight: 600;

    color: #fff;

    margin: 0;

}


.detail-item span {

    color: #fff;

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


.status-active {

    background: rgba(56,193,114,0.15);

    color: #38c172;

}


.status-inactive {

    background: rgba(255,107,107,0.15);

    color: #ff6b6b;

}


.status-maintenance {

    background: rgba(255,177,66,0.15);

    color: #ffb142;

}


.status-valid {

    background: rgba(56,193,114,0.15);

    color: #38c172;

}


/* Table */

.table thead th {

    border-bottom: 2px solid #dee2e6;

    padding: 12px 15px;

    color: #fff;

}


.table tbody td {

    border-bottom: 1px solid #dee2e6;

    padding: 12px 15px;

    color: #fff;

    word-break: break-word;

    white-space: normal;

}


.table {

    width: 100% !important;

    table-layout: auto;

}


.btn-block {

    margin-bottom: 10px;

}


/* Modal */

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


/* Form Styles */

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


.form-group {

    margin-bottom: 1rem;

}


/* Modal Open */

.modal-open {

    overflow: hidden;

}

</style>

@endpush