@extends('layouts.app')

@section('title', 'Upload Staff Document')
@section('header', 'Upload Staff Document')

@section('content')

<div class="documents-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-upload"></i>
                Upload Staff Document
            </h1>
            <div class="header-actions">
                <a href="{{ route('documents.staff.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Documents
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('documents.staff.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff_id">Staff *</label>
                                    <select class="form-control select2 @error('staff_id') is-invalid @enderror" 
                                            id="staff_id" name="staff_id" required>
                                        <option value="">Select Staff</option>
                                        @foreach($staff as $employee)
                                            <option value="{{ $employee->id }}" {{ old('staff_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} - {{ $employee->position }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('staff_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_type">Document Type *</label>
                                    <select class="form-control @error('document_type') is-invalid @enderror" 
                                            id="document_type" name="document_type" required>
                                        <option value="">Select Document Type</option>
                                        <option value="emirates_id" {{ old('document_type') == 'emirates_id' ? 'selected' : '' }}>Emirates ID</option>
                                        <option value="visa" {{ old('document_type') == 'visa' ? 'selected' : '' }}>Visa</option>
                                        <option value="passport" {{ old('document_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="employee_contract" {{ old('document_type') == 'employee_contract' ? 'selected' : '' }}>Employee Contract</option>
                                    </select>
                                    @error('document_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date *</label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                           id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="document_path">Document File *</label>
                                    <div class="file-upload-area">
                                        <input type="file" class="file-input @error('document_path') is-invalid @enderror" 
                                               id="document_path" name="document_path" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                                        <div class="file-upload-text">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <p>Click to upload or drag and drop</p>
                                            <span>PDF, JPG, PNG, DOC, DOCX (Max: 10MB)</span>
                                        </div>
                                    </div>
                                    @error('document_path')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-actions mt-4">
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="{{ route('documents.staff.index') }}" class="btn btn-secondary mr-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Upload Document
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Setup staff dropdown
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select staff'
    });

    // Preview selected file
    const fileInput = document.getElementById('document_path');
    const fileUploadText = document.querySelector('.file-upload-text');
    
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileUploadText.innerHTML = `
                <i class="fas fa-file-check text-success"></i>
                <p>${this.files[0].name}</p>
                <span>${(this.files[0].size / 1024 / 1024).toFixed(2)} MB</span>
            `;
        }
    });

    // Set minimum expiry date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('expiry_date').min = today;
});
</script>
@endpush

<style>
.file-upload-area {
    border: 2px dashed #4ecdc4;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    background: rgba(78, 205, 196, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.file-upload-area:hover {
    border-color: #2bb5ad;
    background: rgba(78, 205, 196, 0.1);
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-text {
    pointer-events: none;
}

.file-upload-text i {
    font-size: 48px;
    color: #4ecdc4;
    margin-bottom: 15px;
}

.file-upload-text p {
    font-size: 18px;
    font-weight: 600;
    color: #4ecdc4;
    margin-bottom: 8px;
}

.file-upload-text span {
    font-size: 14px;
    color: #a0aec0;
}
</style>
@endsection