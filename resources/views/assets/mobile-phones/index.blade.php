@extends('layouts.app')

@section('title', 'Mobile Phones')
@section('header', 'Mobile Phones Management')

@section('content')

<div class="container-fluid">

    <div class="assets-container">

        {{-- Page header --}}
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">

                <h1 class="page-title">
                    <i class="fas fa-mobile-alt"></i>
                    Mobile Phones Management
                </h1>

                <div class="header-actions">
                    <a href="{{ route('assets.mobile-phones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        New Mobile Phone
                    </a>
                </div>

            </div>
        </div>

        {{-- Show alert messages --}}
        @include('common.alert')

        {{-- Mobile phones table --}}
        <div class="table-card">

            <div class="table-header">

                <h2>All Mobile Phones</h2>

                <div class="table-actions">

                    <div class="search-box">
                        <i class="fas fa-search"></i>

                        <input
                            type="text"
                            placeholder="Search mobile phones..."
                            id="searchInput"
                        >
                    </div>

                </div>

            </div>

            <div class="table-responsive">

                <table class="modern-table" id="mobilePhonesTable">

                    <thead>
                        <tr>

                            <th data-sort="model">
                                <span>Phone Model</span>
                                <i class="fas fa-sort"></i>
                            </th>

                            <th data-sort="imei">
                                <span>IMEI Number</span>
                                <i class="fas fa-sort"></i>
                            </th>

                            <th data-sort="number">
                                <span>Phone Number</span>
                                <i class="fas fa-sort"></i>
                            </th>

                            <th data-sort="purchase_date">
                                <span>Purchase Date</span>
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

                            <th>
                                Actions
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($mobilePhones as $phone)

                            <tr>

                                {{-- Phone model --}}
                                <td>
                                    {{ $phone->phone_model }}
                                </td>

                                {{-- IMEI number --}}
                                <td>
                                    {{ $phone->imei_number ?? 'N/A' }}
                                </td>

                                {{-- Phone number --}}
                                <td>
                                    {{ $phone->phone_number ?? 'N/A' }}
                                </td>

                                {{-- Purchase date --}}
                                <td>
                                    {{ $phone->purchase_date
                                        ? $phone->purchase_date->format('M d, Y')
                                        : 'N/A'
                                    }}
                                </td>

                                {{-- Phone status --}}
                                <td>

                                    <span class="status-badge status-{{ $phone->status }}">

                                        <i class="fas fa-circle"></i>

                                        {{ ucfirst($phone->status) }}

                                    </span>

                                </td>

                                {{-- Current assignee --}}
                                <td>

                                    @php
                                        $currentAssignment = $phone->assetAssignments
                                            ->whereNull('date_returned')
                                            ->first();
                                    @endphp

                                    @if($currentAssignment)

                                        @php
                                            $type = strtolower(
                                                class_basename(
                                                    $currentAssignment->assignable_type
                                                )
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
                                            (Staff)

                                        {{-- Driver assignment --}}
                                        @elseif($type === 'driver')

                                            @php
                                                $driver = \App\Models\Driver::find(
                                                    $currentAssignment->assignable_id
                                                );
                                            @endphp

                                            {{ $driver->name ?? 'Unknown Driver' }}
                                            (Driver)

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

                                        {{-- View phone --}}
                                        <a
                                            href="{{ route('assets.mobile-phones.show', $phone) }}"
                                            class="btn-action btn-info"
                                            title="View Mobile Phone"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit phone --}}
                                        <a
                                            href="{{ route('assets.mobile-phones.edit', $phone) }}"
                                            class="btn-action btn-primary"
                                            title="Edit Mobile Phone"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Delete phone --}}
                                        <button
                                            type="button"
                                            class="btn-action btn-danger mobile-phone-delete-trigger"
                                            title="Delete Mobile Phone"
                                            data-phoneid="{{ $phone->id }}"
                                            data-phonemodel="{{ $phone->phone_model }}"
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
                    Showing {{ $mobilePhones->count() }}
                    of {{ $mobilePhones->count() }}
                    entries
                </div>

            </div>

        </div>

    </div>

</div>


{{-- Delete confirmation modal --}}
<div
    class="modal"
    id="mobilePhoneDeleteModal"
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

                    Confirm Mobile Phone Deletion

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
                    Are you sure you want to delete mobile phone

                    <strong
                        id="displayPhoneModel"
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
                    Delete Mobile Phone
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

    // Search table rows

    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('mobilePhonesTable');
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {

        const searchTerm = this.value.toLowerCase().trim();

        rows.forEach(function (row) {

            const rowText = row.textContent.toLowerCase();

            if (rowText.includes(searchTerm)) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    });


    // Setup delete modal

    const deleteModal = document.getElementById(
        'mobilePhoneDeleteModal'
    );

    const displayPhoneModel = document.getElementById(
        'displayPhoneModel'
    );

    const closeBtn = document.querySelector(
        '.close-btn'
    );

    const cancelBtn = document.querySelector(
        '.cancel-btn'
    );

    const confirmDeleteBtn = document.querySelector(
        '.confirm-delete-btn'
    );

    const globalDeleteForm = document.getElementById(
        'globalDeleteForm'
    );

    let currentPhoneId = null;


    // Setup delete modal

    document
        .querySelectorAll('.mobile-phone-delete-trigger')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                currentPhoneId = this.getAttribute(
                    'data-phoneid'
                );

                const phoneModel = this.getAttribute(
                    'data-phonemodel'
                );

                displayPhoneModel.textContent = phoneModel;

                deleteModal.style.display = 'block';

                document.body.classList.add(
                    'modal-open'
                );

            });

        });


    // Confirm phone deletion

    confirmDeleteBtn.addEventListener('click', function () {

        if (currentPhoneId) {

            globalDeleteForm.action =
                "{{ route('assets.mobile-phones.destroy', ':id') }}"
                    .replace(
                        ':id',
                        currentPhoneId
                    );

            globalDeleteForm.submit();

        }

    });


    // Close assignment modal

    function closeDeleteModal() {

        deleteModal.style.display = 'none';

        document.body.classList.remove(
            'modal-open'
        );

        currentPhoneId = null;

    }


    closeBtn.addEventListener(
        'click',
        closeDeleteModal
    );


    cancelBtn.addEventListener(
        'click',
        closeDeleteModal
    );


    // Close modal outside click

    deleteModal.addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeDeleteModal();

            }

        }
    );


    // Close modal with Escape

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                deleteModal.style.display === 'block'
            ) {

                closeDeleteModal();

            }

        }
    );


    // Handle table sorting

    const sortHeaders = document.querySelectorAll(
        'th[data-sort]'
    );

    sortHeaders.forEach(function (header) {

        header.addEventListener('click', function () {

            const sortBy = this.getAttribute(
                'data-sort'
            );

            console.log(
                'Sort by:',
                sortBy
            );

        });

    });

});

</script>


<style>

/* Status badges */

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


.status-broken {

    background: rgba(255, 177, 66, 0.15);

    color: #ffb142;

}


.status-retired {

    background: rgba(108, 117, 125, 0.15);

    color: #6c757d;

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


/* Table card */

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


/* Main table */

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


/* Action buttons */

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


/* Main buttons */

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


/* Modal open state */

.modal-open {

    overflow: hidden;

}


/* Responsive styles */

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