@extends('layouts.app')

@section('title', 'Drivers List')
@section('header', 'Drivers Management')

@section('content')
<title>Drivers Management</title>
<div class="drivers-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-id-card"></i>
                Drivers Management
            </h1>
            <div class="header-actions">
                <a href="{{ route('drivers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Driver
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    {{-- Drivers table --}}
    <div class="table-card">
        <div class="table-header">
            <h2>All Drivers</h2>
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search drivers..." id="searchInput">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table" id="driversTable">
                <thead>
                    <tr>
                        <th data-sort="name"><span>Name</span><i class="fas fa-sort"></i></th>
                        <th data-sort="contact"><span>Contact No</span><i class="fas fa-sort"></i></th>
                        <th data-sort="emergency"><span>Emergency Contact</span><i class="fas fa-sort"></i></th>
                        <th data-sort="vehicle"><span>Primary Vehicle</span><i class="fas fa-sort"></i></th>
                        <th data-sort="status"><span>Status</span><i class="fas fa-sort"></i></th>
                        <th data-sort="bookings"><span>Active Bookings</span><i class="fas fa-sort"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                    <tr>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->contact_no }}</td>
                        <td>{{ $driver->emergency_contact ?? 'N/A' }}</td>
                        <td>
                            @if($driver->primaryVehicle)
                                {{ $driver->primaryVehicle->vehicle_name }} ({{ $driver->primaryVehicle->vehicle_plate_no }})
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-{{ str_replace('_', '-', $driver->status) }}">
                                <i class="fas fa-circle"></i> {{ ucfirst(str_replace('_', ' ', $driver->status)) }}
                            </span>
                        </td>
                        <td>
                            {{ $driver->bookings->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count() }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('drivers.show', $driver) }}" 
                                   class="btn-action btn-info" title="View Driver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('drivers.edit', $driver) }}" 
                                   class="btn-action btn-primary" title="Edit Driver">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn-action btn-danger driver-delete-trigger" 
                                        title="Delete Driver" 
                                        data-driverid="{{ $driver->id }}"
                                        data-drivername="{{ $driver->name }}">
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
                Showing {{ $drivers->count() }} of {{ $drivers->count() }} entries
            </div>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
<div class="modal" id="driverDeleteModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm Driver Deletion
                </h5>
                <button type="button" class="close-btn" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete driver <strong id="displayDriverName" class="text-warning"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> This action cannot be undone and will remove all associated data.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-btn">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger confirm-delete-btn">
                    <i class="fas fa-trash me-1"></i> Delete Driver
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden delete form --}}
<form id="globalDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('driversTable');
    const rows = table.querySelectorAll('tbody tr');
    
    // Get delete modal elements
    const deleteModal = document.getElementById('driverDeleteModal');
    const displayDriverName = document.getElementById('displayDriverName');
    const closeBtn = document.querySelector('.close-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const confirmDeleteBtn = document.querySelector('.confirm-delete-btn');
    const globalDeleteForm = document.getElementById('globalDeleteForm');

    let currentDriverId = null;

    // Search drivers
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
    });

    // Open delete modal
    document.querySelectorAll('.driver-delete-trigger').forEach(button => {
        button.addEventListener('click', function() {
            currentDriverId = this.getAttribute('data-driverid');
            const driverName = this.getAttribute('data-drivername');
            
            // Set selected driver name
            displayDriverName.textContent = driverName;
            
            // Show delete modal
            deleteModal.style.display = 'block';
            document.body.classList.add('modal-open');
        });
    });

    // Confirm driver deletion
    confirmDeleteBtn.addEventListener('click', function() {
        if (currentDriverId) {
            globalDeleteForm.action = "{{ route('drivers.destroy', ':id') }}".replace(':id', currentDriverId);
            globalDeleteForm.submit();
        }
    });

    // Close delete modal
    closeBtn.addEventListener('click', function() {
        deleteModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        currentDriverId = null;
    });

    cancelBtn.addEventListener('click', function() {
        deleteModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        currentDriverId = null;
    });

    // Close modal outside click
    deleteModal.addEventListener('click', function(event) {
        if (event.target === this) {
            deleteModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            currentDriverId = null;
        }
    });

    // Close modal with Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && deleteModal.style.display === 'block') {
            deleteModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            currentDriverId = null;
        }
    });

    // Handle table sorting
    const sortHeaders = document.querySelectorAll('th[data-sort]');
    sortHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.getAttribute('data-sort');
            // Sorting logic goes here
            console.log('Sort by:', sortBy);
        });
    });
});
</script>

<style>
/* Driver status badges */
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

.status-on-leave {
    background: rgba(66, 153, 225, 0.15);
    color: #4299e1;
}

/* Driver page styles */
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

/* Table card styles */
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

/* Driver table styles */
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

/* Row action buttons */
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

/* Main button styles */
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
    background: linear-gradient(135deg, '4ecdc4' 0%, '2bb5ad' 100%);
    color: #fff;
    border: 1px solid rgba(78, 205, 196, 0.3);
    box-shadow: 0 4px 15px rgba(78, 205, 196, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(135deg, '2bb5ad' 0%, '4ecdc4' 100%);
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