@extends('layouts.app')

@section('title', 'Users List')

@section('content')

<title>Manage Users</title>
<div class="users-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                Users Management
            </h1>
            <div class="header-actions">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add New User
                </a>
                <a href="{{ route('users.export') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Export Users
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    {{-- Users table --}}
    <div class="table-card">
        <div class="table-header">
            <h2>All Users</h2>
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search users..." id="searchInput">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table" id="usersTable">
                <thead>
                    <tr>
                        <th data-sort="name"><span>Name</span><i class="fas fa-sort"></i></th>
                        <th data-sort="email"><span>Email</span><i class="fas fa-sort"></i></th>
                        <th data-sort="mobile"><span>Mobile</span><i class="fas fa-sort"></i></th>
                        <th data-sort="role"><span>Role</span><i class="fas fa-sort"></i></th>
                        <th data-sort="status"><span>Status</span><i class="fas fa-sort"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <img src="{{ asset('admin/img/undraw_profile.svg') }}" alt="{{ $user->full_name }}">
                                </div>
                                <div class="user-details">
                                    <span class="user-name">{{ $user->full_name }}</span>
                                    <span class="user-id">ID: {{ $user->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile_number ?? 'N/A' }}</td>
                        <td>
                            <span class="role-badge">{{ $user->roles ? $user->roles->pluck('name')->first() : 'N/A' }}</span>
                        </td>
                             <td> {{-- Show user status --}} @if ($user->getAttributes()['status'] == 1) <span class="status-badge status-active"><i class="fas fa-circle"></i> Active</span> @else <span class="status-badge status-inactive"><i class="fas fa-circle"></i> Inactive</span> @endif </td>
                        <td>
                            <div class="action-buttons">
                               {{-- Toggle user status --}} @if ($user->getAttributes()['status'] == 0) <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 1]) }}" class="btn-action btn-success" title="Activate User"><i class="fas fa-check"></i></a> @else <a href="{{ route('users.status', ['user_id' => $user->id, 'status' => 0]) }}" class="btn-action btn-warning" title="Deactivate User"><i class="fas fa-ban"></i></a> @endif

                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                   class="btn-action btn-primary" title="Edit User"><i class="fas fa-edit"></i></a>

                                {{-- Delete user button --}}
                                <button class="btn-action btn-danger user-delete-trigger" 
                                        title="Delete User" 
                                        data-userid="{{ $user->id }}"
                                        data-username="{{ $user->full_name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Table pagination --}}
        <div class="table-footer">
            <div class="table-info">
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
            </div>
            <div class="pagination">
                {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
<div class="modal" id="userDeleteModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm User Deletion
                </h5>
                <button type="button" class="close-btn" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete user <strong id="displayUserName" class="text-warning"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-btn">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger confirm-delete-btn">
                    <i class="fas fa-trash me-1"></i> Delete User
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
    const table = document.getElementById('usersTable');
    const rows = table.querySelectorAll('tbody tr');
    
    // Get modal elements
    const deleteModal = document.getElementById('userDeleteModal');
    const displayUserName = document.getElementById('displayUserName');
    const closeBtn = document.querySelector('.close-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const confirmDeleteBtn = document.querySelector('.confirm-delete-btn');
    const globalDeleteForm = document.getElementById('globalDeleteForm');

    let currentUserId = null;

    // Search users
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
    });

    // Open delete modal
    document.querySelectorAll('.user-delete-trigger').forEach(button => {
        button.addEventListener('click', function() {
            currentUserId = this.getAttribute('data-userid');
            const userName = this.getAttribute('data-username');
            
            // Update modal content
            displayUserName.textContent = userName;
            
            // Show delete modal
            deleteModal.style.display = 'block';
            document.body.classList.add('modal-open');
        });
    });

    // Confirm user deletion
    confirmDeleteBtn.addEventListener('click', function() {
        if (currentUserId) {
            // Set user delete route
            globalDeleteForm.action = "{{ route('users.destroy', ':id') }}".replace(':id', currentUserId);
            globalDeleteForm.submit();
        }
    });

    // Close delete modal
    closeBtn.addEventListener('click', function() {
        deleteModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        currentUserId = null;
    });

    cancelBtn.addEventListener('click', function() {
        deleteModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        currentUserId = null;
    });

    // Close modal outside click
    deleteModal.addEventListener('click', function(event) {
        if (event.target === this) {
            deleteModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            currentUserId = null;
        }
    });

    // Close modal with Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && deleteModal.style.display === 'block') {
            deleteModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            currentUserId = null;
        }
    });

    // Setup Bootstrap tooltips
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>

<style>
/* Page header styles */
.page-header {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
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

/* Button styles */
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

.btn-primary {
    background: linear-gradient(135deg, #4ecdc4 0%, #2bb5ad 100%);
    color: #fff;
}

.btn-success {
    background: linear-gradient(135deg, #38c172 0%, #2aa65c 100%);
    color: #fff;
}

.btn-warning {
    background: linear-gradient(135deg, #ffed4a 0%, #f2d024 100%);
    color: #2d3748;
}

.btn-danger {
    background: linear-gradient(135deg, #ff6b6b 0%, #e53e3e 100%);
    color: #fff;
}

/* Modal open state */
.modal-open {
    overflow: hidden;
}

/* Responsive page styles */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .header-actions {
        width: 100%;
        justify-content: flex-start;
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
}
</style>
@endsection