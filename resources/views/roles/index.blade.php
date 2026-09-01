@extends('layouts.app')

@section('title', 'Roles Management')
@section('header', 'Roles Management')

@section('content')

<div class="roles-container">

    {{-- Page header --}}
    <div class="page-header">

        <div class="d-flex justify-content-between align-items-center">

            <h1 class="page-title">
                <i class="fas fa-user-shield"></i>
                Roles Management
            </h1>

            <div class="header-actions">

                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    New Role
                </a>

            </div>

        </div>

    </div>


    {{-- Show alert messages --}}
    @include('common.alert')


    {{-- Roles table --}}
    <div class="table-card">

        <div class="table-header">

            <h2>All Roles</h2>

            <div class="table-actions">

                <div class="search-box">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        placeholder="Search roles..."
                        id="searchInput"
                    >

                </div>

            </div>

        </div>


        <div class="table-responsive">

            <table class="modern-table" id="rolesTable">

                <thead>

                    <tr>

                        <th data-sort="name">
                            <span>Name</span>
                            <i class="fas fa-sort"></i>
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($roles as $role)

                        <tr>

                            {{-- Role name --}}
                            <td>

                                <strong>
                                    {{ $role->name }}
                                </strong>

                                @if ($role->name === 'Super Admin')

                                    <span class="role-badge">
                                        <i class="fas fa-crown"></i>
                                        Super Admin
                                    </span>

                                @endif

                            </td>


                            {{-- Role actions --}}
                            <td>

                                <div class="action-buttons">

                                    @if ($role->name !== 'Super Admin')

                                        {{-- Edit role --}}
                                        <a
                                            href="{{ route('roles.edit', ['role' => $role->id]) }}"
                                            class="btn-action btn-primary"
                                            title="Edit Role"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        {{-- Delete role --}}
                                        <button
                                            type="button"
                                            class="btn-action btn-danger role-delete-trigger"
                                            title="Delete Role"
                                            data-roleid="{{ $role->id }}"
                                            data-rolename="{{ $role->name }}"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    @else

                                        <span class="full-access-badge">
                                            <i class="fas fa-check-circle"></i>
                                            Full Access
                                        </span>

                                    @endif

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
                Showing {{ $roles->count() }} of {{ $roles->count() }} entries
            </div>

            @if ($roles->hasPages())

                <div>
                    {{ $roles->withQueryString()->links('pagination::bootstrap-5') }}
                </div>

            @endif

        </div>

    </div>

</div>


{{-- Delete confirmation modal --}}

<div
    class="modal"
    id="roleDeleteModal"
    tabindex="-1"
    aria-hidden="true"
    style="display: none;"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>

                    Confirm Role Deletion

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
                    Are you sure you want to delete role
                    <strong
                        id="displayRoleName"
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
                    Delete Role
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


{{-- Role page scripts --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');

    const table = document.getElementById('rolesTable');

    const rows = table.querySelectorAll('tbody tr');


    /* Search roles */

    searchInput.addEventListener('input', function () {

        const searchTerm = this.value.toLowerCase().trim();

        rows.forEach(function (row) {

            const rowText = row.textContent.toLowerCase();

            row.style.display =
                rowText.includes(searchTerm) ? '' : 'none';

        });

    });


    /* Delete confirmation modal */

    const deleteModal =
        document.getElementById('roleDeleteModal');

    const displayRoleName =
        document.getElementById('displayRoleName');

    const closeBtn =
        document.querySelector('.close-btn');

    const cancelBtn =
        document.querySelector('.cancel-btn');

    const confirmDeleteBtn =
        document.querySelector('.confirm-delete-btn');

    const globalDeleteForm =
        document.getElementById('globalDeleteForm');


    let currentRoleId = null;


    /* Open delete modal */

    document
        .querySelectorAll('.role-delete-trigger')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                currentRoleId =
                    this.getAttribute('data-roleid');

                const roleName =
                    this.getAttribute('data-rolename');

                displayRoleName.textContent = roleName;

                deleteModal.style.display = 'block';

                document.body.classList.add('modal-open');

            });

        });


    /* Confirm role deletion */

    confirmDeleteBtn.addEventListener('click', function () {

        if (currentRoleId) {

            globalDeleteForm.action =
                "{{ route('roles.destroy', ':id') }}"
                    .replace(':id', currentRoleId);

            globalDeleteForm.submit();

        }

    });


    /* Close delete modal */

    function closeDeleteModal() {

        deleteModal.style.display = 'none';

        document.body.classList.remove('modal-open');

        currentRoleId = null;

    }


    closeBtn.addEventListener('click', closeDeleteModal);

    cancelBtn.addEventListener('click', closeDeleteModal);


    /* Close modal outside click */

    deleteModal.addEventListener('click', function (event) {

        if (event.target === this) {

            closeDeleteModal();

        }

    });


    /* Close modal with Escape */

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            deleteModal.style.display === 'block'
        ) {

            closeDeleteModal();

        }

    });


    /* Handle table sorting */

    const sortHeaders =
        document.querySelectorAll('th[data-sort]');

    sortHeaders.forEach(function (header) {

        header.addEventListener('click', function () {

            console.log(
                'Sort by:',
                this.getAttribute('data-sort')
            );

        });

    });

});

</script>


<style>

/* Role status badge */

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-left: 10px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    background: rgba(255, 193, 7, 0.15);
    color: #ffc107;
}

.full-access-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    background: rgba(56, 193, 114, 0.15);
    color: #38c172;
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


/* Roles table card */

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


/* Search roles */

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


/* TABLE */

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


/* Role action buttons */

.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
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