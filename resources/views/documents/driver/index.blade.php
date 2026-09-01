@extends('layouts.app')

@section('title', 'Driver Documents')
@section('header', 'Driver Documents')

@section('content')
<div class="documents-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-id-card"></i>
                Driver Documents
            </h1>
            <div class="header-actions">
                <a href="{{ route('documents.driver.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Upload Document
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    {{-- Driver documents table --}}
    <div class="table-card">
        <div class="table-header">
            <h2>All Driver Documents</h2>
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search documents..." id="searchInput">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="modern-table" id="documentsTable">
                <thead>
                    <tr>
                        <th data-sort="driver"><span>Driver</span><i class="fas fa-sort"></i></th>
                        <th data-sort="type"><span>Document Type</span><i class="fas fa-sort"></i></th>
                        <th data-sort="file"><span>File Name</span><i class="fas fa-sort"></i></th>
                        <th data-sort="expiry"><span>Expiry Date</span><i class="fas fa-sort"></i></th>
                        <th data-sort="status"><span>Status</span><i class="fas fa-sort"></i></th>
                        <th data-sort="created"><span>Uploaded On</span><i class="fas fa-sort"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr>
                        <td>
                            <strong>{{ $document->driver->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $document->driver->contact_no }}</small>
                        </td>
                        <td>
                            <span class="document-type">{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</span>
                        </td>
                        <td>
                            <div class="file-info">
                                <i class="fas fa-file-pdf text-danger"></i>
                                <span class="file-name">{{ basename($document->document_path) }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="{{ $document->expiry_date->isPast() ? 'text-danger' : ($document->expiry_date->diffInDays(now()) <= 30 ? 'text-warning' : '') }}">
                                {{ $document->expiry_date->format('M d, Y') }}
                                @if($document->expiry_date->isPast())
                                    <i class="fas fa-exclamation-triangle ml-1" title="Expired"></i>
                                @elseif($document->expiry_date->diffInDays(now()) <= 30)
                                    <i class="fas fa-exclamation-circle ml-1" title="Expiring Soon"></i>
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $document->expiry_date->isPast() ? 'expired' : ($document->expiry_date->diffInDays(now()) <= 30 ? 'warning' : 'valid') }}">
                                <i class="fas fa-circle"></i> 
                                {{ $document->expiry_date->isPast() ? 'Expired' : ($document->expiry_date->diffInDays(now()) <= 30 ? 'Expiring Soon' : 'Valid') }}
                            </span>
                        </td>
                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                @php
    $driver = $document->driver->id;
@endphp
                       
                                <a href="{{ route('drivers.show', $driver) }}" 
                                   class="btn-action btn-info" title="View Driver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('documents.driver.download', $document) }}" 
                                   class="btn-action btn-primary" 
                                   title="Download Document">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('documents.driver.edit', $document) }}" 
                                   class="btn-action btn-warning" 
                                   title="Edit Document">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn-action btn-danger document-delete-trigger" 
                                        title="Delete Document" 
                                        data-documentid="{{ $document->id }}"
                                        data-documentname="{{ $document->driver->name }} - {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}">
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
                Showing {{ $documents->count() }} of {{ $documents->count() }} entries
            </div>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
<div class="modal" id="documentDeleteModal" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm Document Deletion
                </h5>
                <button type="button" class="close-btn" aria-label="Close">×</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="displayDocumentName" class="text-warning"></strong> document?</p>
                <p class="text-danger"><i class="fas fa-exclamation-circle me-1"></i> This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-btn">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <form id="deleteDocumentForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete Document
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('documentsTable');
    const rows = table.querySelectorAll('tbody tr');
    const deleteModal = document.getElementById('documentDeleteModal');
    const displayDocumentName = document.getElementById('displayDocumentName');
    const deleteDocumentForm = document.getElementById('deleteDocumentForm');
    const closeBtn = document.querySelector('.close-btn');
    const cancelBtn = document.querySelector('.cancel-btn');

    let currentDocumentId = null;

    // Search documents
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
    });

    // Open delete modal
    document.querySelectorAll('.document-delete-trigger').forEach(button => {
        button.addEventListener('click', function() {
            currentDocumentId = this.getAttribute('data-documentid');
            const documentName = this.getAttribute('data-documentname');
            
            displayDocumentName.textContent = documentName;
            deleteDocumentForm.action = "{{ route('documents.driver.destroy', ':id') }}".replace(':id', currentDocumentId);
            deleteModal.style.display = 'block';
            document.body.classList.add('modal-open');
        });
    });

    // Close delete modal
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    function closeModal() {
        deleteModal.style.display = 'none';
        document.body.classList.remove('modal-open');
        currentDocumentId = null;
    }

    // Close modal outside click
    deleteModal.addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });

    // Close modal with Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && deleteModal.style.display === 'block') {
            closeModal();
        }
    });
});
</script>

<style>
.document-type {
    font-weight: 600;
    color: #4ecdc4;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.file-name {
    font-size: 14px;
    color: #e8e8e8;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-valid {
    background: rgba(56, 193, 114, 0.15);
    color: #38c172;
}

.status-warning {
    background: rgba(255, 177, 66, 0.15);
    color: #ffb142;
}

.status-expired {
    background: rgba(255, 107, 107, 0.15);
    color: #ff6b6b;
}

.btn-warning {
    background: linear-gradient(135deg, #ffb142 0%, #cc8e35 100%);
    color: #fff;
}

/* Document page styles */
</style>
@endsection