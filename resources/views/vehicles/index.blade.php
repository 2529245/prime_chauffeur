@extends('layouts.app')

@section('title', 'Vehicles List')
@section('header', 'Vehicles Management')

@section('content')

<div class="vehicles-container">

    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-car"></i>
                Vehicles Management
            </h1>

            <div class="header-actions">
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    New Vehicle
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    {{-- Vehicles table --}}
    <div class="table-card">

        <div class="table-header">
            <h2>
                All Vehicles ({{ $vehicles->count() }})
            </h2>

            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        placeholder="Search vehicles..."
                        id="searchInput"
                    >
                </div>
            </div>
        </div>

        <div class="table-responsive">

            <table class="modern-table" id="vehiclesTable">

                <thead>
                    <tr>
                        <th data-sort="plate">
                            <span>Plate No</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="name">
                            <span>Vehicle Name</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="model">
                            <span>Model</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="color">
                            <span>Color</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="driver">
                            <span>Primary Driver</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="expiry">
                            <span>Mulkiya Expiry</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th data-sort="status">
                            <span>Status</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($vehicles as $vehicle)

                        <tr>

                            {{-- Vehicle plate --}}
                            <td>
                                <strong>
                                    {{ $vehicle->vehicle_plate_no }}
                                </strong>
                            </td>

                            {{-- Vehicle name --}}
                            <td>
                                {{ $vehicle->vehicle_name }}
                            </td>

                            {{-- Vehicle model --}}
                            <td>
                                {{ $vehicle->vehicle_model }}
                            </td>

                            {{-- Vehicle color --}}
                            <td>
                                <span
                                    class="color-badge"
                                    style="background-color: {{ $vehicle->vehicle_color }};"
                                ></span>

                                {{ $vehicle->vehicle_color }}
                            </td>

                            {{-- Select primary driver --}}
                            <td>

                                @if($vehicle->primaryDriver)

                                    <strong>
                                        {{ $vehicle->primaryDriver->name }}
                                    </strong>

                                @else

                                    <span class="text-muted">
                                        Not assigned
                                    </span>

                                @endif

                            </td>

                            {{-- Mulkiya expiry --}}
                            <td>

                                @if($vehicle->mulkiya_expiry_date)

                                    @if($vehicle->mulkiya_expiry_date->isPast())

                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            {{ $vehicle->mulkiya_expiry_date->format('M d, Y') }}
                                        </span>

                                    @else

                                        {{ $vehicle->mulkiya_expiry_date->format('M d, Y') }}

                                    @endif

                                @else

                                    <span class="text-muted">
                                        N/A
                                    </span>

                                @endif

                            </td>

                            {{-- Vehicle status --}}
                            <td>

                                <span class="status-badge status-{{ $vehicle->status }}">

                                    <i class="fas fa-circle"></i>

                                    {{ ucfirst($vehicle->status) }}

                                </span>

                            </td>

                            {{-- Vehicle actions --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- View vehicle --}}
                                    <a
                                        href="{{ route('vehicles.show', $vehicle) }}"
                                        class="btn-action btn-info"
                                        title="View Vehicle"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit vehicle --}}
                                    <a
                                        href="{{ route('vehicles.edit', $vehicle) }}"
                                        class="btn-action btn-primary"
                                        title="Edit Vehicle"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete vehicle --}}
                                    <button
                                        type="button"
                                        class="btn-action btn-danger vehicle-delete-trigger"
                                        title="Delete Vehicle"
                                        data-vehicleid="{{ $vehicle->id }}"
                                        data-vehiclename="{{ $vehicle->vehicle_name }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-car"></i>

                                    <h4>
                                        No Vehicles Found
                                    </h4>

                                    <p>
                                        No vehicles have been added yet.
                                    </p>

                                    <a
                                        href="{{ route('vehicles.create') }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-plus"></i>
                                        Add Vehicle
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Table footer --}}
        <div class="table-footer">

            <div class="table-info">

                Showing
                <span id="visibleCount">
                    {{ $vehicles->count() }}
                </span>
                of
                {{ $vehicles->count() }}
                vehicles

            </div>

        </div>

    </div>

</div>


{{-- Delete confirmation modal --}}
<div
    class="modal"
    id="vehicleDeleteModal"
    tabindex="-1"
    aria-hidden="true"
    style="display: none;"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>

                    Confirm Vehicle Deletion

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
                    Are you sure you want to delete vehicle
                    <strong
                        id="displayVehicleName"
                        class="text-warning"
                    ></strong>?
                </p>

                <p class="text-danger">

                    <i class="fas fa-exclamation-circle me-1"></i>

                    This action cannot be undone and will remove
                    all associated data.

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
                    Delete Vehicle
                </button>

            </div>

        </div>

    </div>

</div>


{{-- Hidden delete form --}}
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

    /* Search vehicles */

    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('vehiclesTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    const visibleCount = document.getElementById('visibleCount');

    searchInput.addEventListener('input', function () {

        const searchTerm = this.value
            .toLowerCase()
            .trim();

        let count = 0;

        rows.forEach(row => {

            const text = row.textContent.toLowerCase();

            if (text.includes(searchTerm)) {

                row.style.display = '';
                count++;

            } else {

                row.style.display = 'none';

            }

        });

        visibleCount.textContent = count;

    });


    /* Delete confirmation modal */

    const deleteModal =
        document.getElementById('vehicleDeleteModal');

    const displayVehicleName =
        document.getElementById('displayVehicleName');

    const closeBtn =
        document.querySelector('.close-btn');

    const cancelBtn =
        document.querySelector('.cancel-btn');

    const confirmDeleteBtn =
        document.querySelector('.confirm-delete-btn');

    const globalDeleteForm =
        document.getElementById('globalDeleteForm');

    let currentVehicleId = null;


    /* Open delete modal */

    document
        .querySelectorAll('.vehicle-delete-trigger')
        .forEach(button => {

            button.addEventListener('click', function () {

                currentVehicleId =
                    this.dataset.vehicleid;

                displayVehicleName.textContent =
                    this.dataset.vehiclename;

                deleteModal.style.display = 'block';

                document.body.classList.add('modal-open');

            });

        });


    /* Confirm vehicle deletion */

    confirmDeleteBtn.addEventListener('click', function () {

        if (!currentVehicleId) {
            return;
        }

        globalDeleteForm.action =
            "{{ route('vehicles.destroy', ':id') }}"
                .replace(':id', currentVehicleId);

        globalDeleteForm.submit();

    });


    /* Close delete modal */

    function closeDeleteModal() {

        deleteModal.style.display = 'none';

        document.body.classList.remove('modal-open');

        currentVehicleId = null;

    }


    closeBtn.addEventListener(
        'click',
        closeDeleteModal
    );

    cancelBtn.addEventListener(
        'click',
        closeDeleteModal
    );


    deleteModal.addEventListener('click', function (event) {

        if (event.target === deleteModal) {

            closeDeleteModal();

        }

    });


    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            deleteModal.style.display === 'block'
        ) {

            closeDeleteModal();

        }

    });


    /* Sort table columns */

    document
        .querySelectorAll('#vehiclesTable th[data-sort]')
        .forEach(header => {

            header.addEventListener('click', function () {

                const columnIndex =
                    this.cellIndex;

                const currentDirection =
                    this.dataset.direction || 'asc';

                const newDirection =
                    currentDirection === 'asc'
                        ? 'desc'
                        : 'asc';

                this.dataset.direction = newDirection;


                const sortedRows = rows
                    .filter(row => row.style.display !== 'none')
                    .sort(function (a, b) {

                        const aValue =
                            a.cells[columnIndex]
                                .textContent
                                .trim()
                                .toLowerCase();

                        const bValue =
                            b.cells[columnIndex]
                                .textContent
                                .trim()
                                .toLowerCase();


                        if (aValue < bValue) {
                            return newDirection === 'asc'
                                ? -1
                                : 1;
                        }

                        if (aValue > bValue) {
                            return newDirection === 'asc'
                                ? 1
                                : -1;
                        }

                        return 0;

                    });


                sortedRows.forEach(row => {
                    tbody.appendChild(row);
                });


                /* Update sort icons */

                document
                    .querySelectorAll('#vehiclesTable th[data-sort] i')
                    .forEach(icon => {

                        icon.className =
                            'fas fa-sort';

                    });

                const icon =
                    this.querySelector('i');

                icon.className =
                    newDirection === 'asc'
                        ? 'fas fa-sort-up'
                        : 'fas fa-sort-down';

            });

        });

});

</script>


<style>

/* Vehicle status badges */

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

.status-maintenance {
    background: rgba(255, 177, 66, 0.15);
    color: #ffb142;
}

.status-inactive {
    background: rgba(255, 107, 107, 0.15);
    color: #ff6b6b;
}


/* Vehicle color badge */

.color-badge {
    display: inline-block;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    margin-right: 7px;
    vertical-align: middle;
    border: 2px solid rgba(255,255,255,0.25);
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


/* Vehicle table card */

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


/* Search vehicles */

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


/* Table */

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
    white-space: nowrap;
}

.modern-table th:last-child {
    cursor: default;
}

.modern-table th:hover {
    background: rgba(255,255,255,0.08);
}

.modern-table th:last-child:hover {
    background: rgba(255,255,255,0.05);
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


/* Action button styles */

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
    text-decoration: none;
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


/* Button styles */

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
    box-shadow: 0 4px 15px rgba(78, 205, 196, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(
        135deg,
        #2bb5ad 0%,
        #4ecdc4 100%
    );
    box-shadow: 0 6px 20px rgba(78, 205, 196, 0.35);
}


/* Empty table state */

.empty-state {
    padding: 50px 20px;
    text-align: center;
}

.empty-state i {
    font-size: 50px;
    color: #4ecdc4;
    margin-bottom: 15px;
}

.empty-state h4 {
    color: #e8e8e8;
    margin-bottom: 8px;
}

.empty-state p {
    color: #a0aec0;
    margin-bottom: 20px;
}


/* Table footer */

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


/* Delete modal styles */

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

.modal-open {
    overflow: hidden;
}


/* Responsive page styles */

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

    .search-box {
        width: 100%;
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