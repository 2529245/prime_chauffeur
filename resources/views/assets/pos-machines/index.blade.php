@extends('layouts.app')

@section('title', 'POS Machines')
@section('header', 'POS Machines Management')

@section('content')

<div class="assets-container">

    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title">
                <i class="fas fa-cash-register"></i>
                POS Machines Management
            </h1>

            <div class="header-actions">
                <a href="{{ route('assets.pos-machines.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    New POS Machine
                </a>
            </div>

        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    {{-- POS machines table --}}
    <div class="table-card">

        <div class="table-header">

            <h2>All POS Machines</h2>

            <div class="table-actions">

                <div class="search-box">
                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        placeholder="Search POS machines..."
                        id="searchInput"
                    >
                </div>

            </div>

        </div>

        <div class="table-responsive">

            <table class="modern-table" id="posMachinesTable">

                <thead>
                    <tr>

                        <th data-sort="machine_id">
                            <span>Merchant ID</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="model">
                            <span>TID Number</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="purchase_date">
                            <span>Purchase Date</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="warranty">
                            <span>Warranty Expiry</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="status">
                            <span>Status</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="assigned_to">
                            <span>Assigned To</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>

                    @foreach ($posMachines as $machine)

                    <tr>

                        {{-- Merchant ID --}}
                        <td>
                            {{ $machine->machine_id }}
                        </td>

                        {{-- TID number --}}
                        <td>
                            {{ $machine->machine_model ?? 'N/A' }}
                        </td>

                        {{-- Purchase date --}}
                        <td>
                            {{ $machine->purchase_date
                                ? $machine->purchase_date->format('M d, Y')
                                : 'N/A'
                            }}
                        </td>

                        {{-- Warranty expiry --}}
                        <td>

                            @if($machine->warranty_expiry)

                                <span class="{{ $machine->warranty_expiry->isPast() ? 'text-danger' : '' }}">

                                    {{ $machine->warranty_expiry->format('M d, Y') }}

                                </span>

                            @else

                                N/A

                            @endif

                        </td>

                        {{-- Machine status --}}
                        <td>

                            <span class="status-badge status-{{ $machine->status }}">

                                <i class="fas fa-circle"></i>

                                {{ ucfirst($machine->status) }}

                            </span>

                        </td>

                        {{-- Current assignee --}}
                        <td>

                            @php
                                $currentAssignment = $machine->assetAssignments
                                    ->whereNull('date_returned')
                                    ->first();
                            @endphp

                            @if($currentAssignment)

                                @php
                                    $type = strtolower(
                                        class_basename($currentAssignment->assignable_type)
                                    );
                                @endphp

                                {{-- Staff assignment --}}
                                @if($type === 'staff')

                                    @php
                                        $staff = \App\Models\Staff::find(
                                            $currentAssignment->assignable_id
                                        );
                                    @endphp

                                    {{ $staff->name ?? 'Unknown Staff' }}
                                    <span class="assignment-type">(Staff)</span>

                                {{-- Driver assignment --}}
                                @elseif($type === 'driver')

                                    @php
                                        $driver = \App\Models\Driver::find(
                                            $currentAssignment->assignable_id
                                        );
                                    @endphp

                                    {{ $driver->name ?? 'Unknown Driver' }}
                                    <span class="assignment-type">(Driver)</span>

                                {{-- Unknown assignment type --}}
                                @else

                                    <span class="text-muted">
                                        Not assigned
                                    </span>

                                @endif

                            @else

                                <span class="text-muted">
                                    Not assigned
                                </span>

                            @endif

                        </td>

                        {{-- Row actions --}}
                        <td>

                            <div class="action-buttons">

                                {{-- View machine --}}
                                <a
                                    href="{{ route('assets.pos-machines.show', $machine) }}"
                                    class="btn-action btn-info"
                                    title="View POS Machine"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Edit machine --}}
                                <a
                                    href="{{ route('assets.pos-machines.edit', $machine) }}"
                                    class="btn-action btn-primary"
                                    title="Edit POS Machine"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete machine --}}
                                <button
                                    type="button"
                                    class="btn-action btn-danger pos-machine-delete-trigger"
                                    title="Delete POS Machine"
                                    data-machineid="{{ $machine->id }}"
                                    data-machinecode="{{ $machine->machine_id }}"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- Table summary --}}
        <div class="table-footer">

            <div class="table-info">

                Showing
                {{ $posMachines->count() }}
                of
                {{ $posMachines->count() }}
                entries

            </div>

        </div>

    </div>

</div>


{{--  --}}
{{-- Delete confirmation modal --}}
{{--  --}}

<div
    class="modal"
    id="posMachineDeleteModal"
    tabindex="-1"
    aria-hidden="true"
    style="display: none;"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            {{-- Modal header --}}
            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>

                    Confirm POS Machine Deletion

                </h5>

                <button
                    type="button"
                    class="close-btn"
                    aria-label="Close"
                >
                    ×
                </button>

            </div>

            {{-- Modal message --}}
            <div class="modal-body">

                <p>

                    Are you sure you want to delete POS Machine

                    <strong
                        id="displayMachineCode"
                        class="text-warning"
                    ></strong>?

                </p>

                <p class="text-danger">

                    <i class="fas fa-exclamation-circle me-1"></i>

                    This action cannot be undone.

                </p>

            </div>

            {{-- Modal actions --}}
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

                    Delete POS Machine

                </button>

            </div>

        </div>

    </div>

</div>


{{--  --}}
{{-- Hidden delete form --}}
{{--  --}}

<form
    id="globalDeleteForm"
    method="POST"
    style="display: none;"
>

    @csrf

    @method('DELETE')

</form>


{{--  --}}
{{-- Page scripts --}}
{{--  --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    // Search table rows

    const searchInput = document.getElementById('searchInput');

    const table = document.getElementById('posMachinesTable');

    const rows = table.querySelectorAll('tbody tr');


    if (searchInput) {

        searchInput.addEventListener('input', function () {

            const searchTerm = this.value.toLowerCase().trim();

            rows.forEach(function (row) {

                const rowText = row.textContent.toLowerCase();

                row.style.display =
                    rowText.includes(searchTerm)
                        ? ''
                        : 'none';

            });

        });

    }


    // Setup delete modal

    const deleteModal =
        document.getElementById('posMachineDeleteModal');

    const displayMachineCode =
        document.getElementById('displayMachineCode');

    const closeBtn =
        document.querySelector('.close-btn');

    const cancelBtn =
        document.querySelector('.cancel-btn');

    const confirmDeleteBtn =
        document.querySelector('.confirm-delete-btn');

    const globalDeleteForm =
        document.getElementById('globalDeleteForm');


    let currentMachineId = null;


    // Open delete modal

    document
        .querySelectorAll('.pos-machine-delete-trigger')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                currentMachineId =
                    this.getAttribute('data-machineid');

                const machineCode =
                    this.getAttribute('data-machinecode');


                displayMachineCode.textContent =
                    machineCode;


                deleteModal.style.display = 'block';

                document.body.classList.add('modal-open');

            });

        });


    // Confirm machine deletion

    if (confirmDeleteBtn) {

        confirmDeleteBtn.addEventListener('click', function () {

            if (currentMachineId) {

                globalDeleteForm.action =
                    "{{ route('assets.pos-machines.destroy', ':id') }}"
                    .replace(':id', currentMachineId);

                globalDeleteForm.submit();

            }

        });

    }


    // Close modal

    function closeDeleteModal() {

        deleteModal.style.display = 'none';

        document.body.classList.remove('modal-open');

        currentMachineId = null;

    }


    // Close modal

    if (closeBtn) {

        closeBtn.addEventListener('click', function () {

            closeDeleteModal();

        });

    }


    // Cancel modal

    if (cancelBtn) {

        cancelBtn.addEventListener('click', function () {

            closeDeleteModal();

        });

    }


    // Close modal outside click

    if (deleteModal) {

        deleteModal.addEventListener('click', function (event) {

            if (event.target === this) {

                closeDeleteModal();

            }

        });

    }


    // Close modal with Escape

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            deleteModal &&
            deleteModal.style.display === 'block'
        ) {

            closeDeleteModal();

        }

    });


    // Handle table sorting

    const sortHeaders =
        document.querySelectorAll('th[data-sort]');


    sortHeaders.forEach(function (header) {

        header.addEventListener('click', function () {

            const sortBy =
                this.getAttribute('data-sort');

            console.log('Sort by:', sortBy);

        });

    });

});

</script>


{{--  --}}
{{-- Page styles --}}
{{--  --}}

<style>

/* Status Badges */

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

    background: rgba(56, 193, 114, 0.15);

    color: #38c172;

}


.status-inactive {

    background: rgba(255, 107, 107, 0.15);

    color: #ff6b6b;

}


.status-maintenance {

    background: rgba(255, 177, 66, 0.15);

    color: #ffb142;

}


/* Assignment Type */

.assignment-type {

    color: #a0aec0;

    font-size: 12px;

    margin-left: 3px;

}


/* Page Header */

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


/* Table Card */

.table-card {

    background: rgba(26, 42, 58, 0.85);

    border-radius: 16px;

    border: 1px solid rgba(255,255,255,0.05);

    overflow: hidden;

}


.table-header {

    padding: 20px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    border-bottom: 1px solid rgba(255,255,255,0.05);

}


.table-header h2 {

    color: #e8e8e8;

    font-size: 18px;

    font-weight: 600;

    margin: 0;

}


.table-actions {

    display: flex;

    gap: 15px;

    align-items: center;

}


// Search table rows

.search-box {

    position: relative;

    display: flex;

    align-items: center;

}


.search-box i {

    position: absolute;

    left: 12px;

    color: #a0aec0;

    z-index: 1;

}


.search-box input {

    padding: 10px 15px 10px 40px;

    background: rgba(255,255,255,0.08);

    border: 1px solid rgba(255,255,255,0.1);

    border-radius: 12px;

    color: #e8e8e8;

    width: 250px;

    transition: all 0.3s ease;

}


.search-box input:focus {

    outline: none;

    border-color: #4ecdc4;

    background: rgba(255,255,255,0.12);

}


.search-box input::placeholder {

    color: #a0aec0;

}


/* Modern Table */

.modern-table {

    width: 100%;

    border-collapse: collapse;

    color: #e8e8e8;

}


.modern-table th {

    background: rgba(255,255,255,0.05);

    padding: 15px;

    text-align: left;

    font-weight: 600;

    color: #a0aec0;

    cursor: pointer;

    transition: background-color 0.3s ease;

    border-bottom: 1px solid rgba(255,255,255,0.05);

}


.modern-table th:hover {

    background: rgba(255,255,255,0.08);

}


.modern-table th span {

    margin-right: 8px;

}


.modern-table td {

    padding: 15px;

    border-bottom: 1px solid rgba(255,255,255,0.05);

    transition: background-color 0.3s ease;

}


.modern-table tbody tr:hover td {

    background: rgba(255,255,255,0.03);

}


/* Action Buttons */

.action-buttons {

    display: flex;

    gap: 8px;

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

    background: linear-gradient(
        135deg,
        #6cb2eb 0%,
        #4299e1 100%
    );

    color: #fff;

}


.btn-primary {

    background: linear-gradient(
        135deg,
        #4ecdc4 0%,
        #2bb5ad 100%
    );

    color: #fff;

}


.btn-danger {

    background: linear-gradient(
        135deg,
        #ff6b6b 0%,
        #e53e3e 100%
    );

    color: #fff;

}


/* Buttons */

.btn {

    padding: 12px 24px;

    border: none;

    border-radius: 12px;

    font-size: 16px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.3s ease;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    text-decoration: none;

}


.btn:hover {

    transform: translateY(-2px);

}


.btn-primary {

    background: linear-gradient(
        135deg,
        #4ecdc4 0%,
        #2bb5ad 100%
    );

    color: #fff;

    border: 1px solid rgba(78, 205, 196, 0.3);

    box-shadow:
        0 4px 15px rgba(78, 205, 196, 0.25);

}


.btn-primary:hover {

    background: linear-gradient(
        135deg,
        #2bb5ad 0%,
        #4ecdc4 100%
    );

    box-shadow:
        0 6px 20px rgba(78, 205, 196, 0.35);

}


/* Table Footer */

.table-footer {

    padding: 20px;

    display: flex;

    justify-content: space-between;

    align-items: center;

    border-top: 1px solid rgba(255,255,255,0.05);

}


.table-info {

    color: #a0aec0;

    font-size: 14px;

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

    box-shadow:
        0 20px 40px rgba(0,0,0,0.4);

    color: #e8e8e8;

}


.modal-header {

    border-bottom:
        1px solid rgba(255,255,255,0.1);

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

    border-top:
        1px solid rgba(255,255,255,0.1);

    padding: 1.5rem;

    display: flex;

    gap: 12px;

    justify-content: flex-end;

}


/* Modal Open */

.modal-open {

    overflow: hidden;

}


/* Responsive */

@media (max-width: 1024px) {

    .table-header {

        flex-direction: column;

        gap: 15px;

        align-items: flex-start;

    }

    .search-box input {

        width: 200px;

    }

}


@media (max-width: 768px) {

    .page-header .d-flex {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }

    .header-actions {

        width: 100%;

        justify-content: flex-start;

    }

    .action-buttons {

        flex-wrap: wrap;

    }

    .table-footer {

        flex-direction: column;

        gap: 15px;

        align-items: flex-start;

    }

    .search-box input {

        width: 100%;

    }

}


@media (max-width: 576px) {

    .header-actions {

        flex-direction: column;

        width: 100%;

    }

    .header-actions .btn {

        width: 100%;

    }

    .modal-dialog {

        margin: 50px 15px;

    }

    .page-title {

        font-size: 20px;

    }

    .btn {

        padding: 10px 20px;

        font-size: 14px;

    }

    .modern-table {

        font-size: 14px;

    }

    .modern-table th,
    .modern-table td {

        padding: 10px;

    }

}

</style>

@endsection