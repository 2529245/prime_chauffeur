@extends('layouts.app')

@section('title', 'Edit Driver Document')
@section('header', 'Edit Driver Document')

@section('content')

<div class="documents-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Document: {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}
            </h1>
            <div class="header-actions">
                <a href="{{ route('documents.driver.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Documents
                </a>
                <a href="{{ route('documents.driver.show', $document) }}" class="btn btn-info ml-2">
                    <i class="fas fa-eye"></i> View Document
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
                    <form action="{{ route('documents.driver.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="driver_id">Driver *</label>
                                    <select class="form-control select2 @error('driver_id') is-invalid @enderror" 
                                            id="driver_id" name="driver_id" required>
                                        <option value="">Select Driver</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" {{ old('driver_id', $document->driver_id) == $driver->id ? 'selected' : '' }}>
                                                {{ $driver->name }} - {{ $driver->contact_no }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('driver_id')
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
                                        <option value="contract" {{ old('document_type', $document->document_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="emirates_id" {{ old('document_type', $document->document_type) == 'emirates_id' ? 'selected' : '' }}>Emirates ID</option>
                                        <option value="driving_license" {{ old('document_type', $document->document_type) == 'driving_license' ? 'selected' : '' }}>Driving License</option>
                                        <option value="passport" {{ old('document_type', $document->document_type) == 'passport' ? 'selected' : '' }}>Passport</option>
                                        <option value="rta_card" {{ old('document_type', $document->document_type) == 'rta_card' ? 'selected' : '' }}>RTA Card</option>
                                        <option value="visa" {{ old('document_type', $document->document_type) == 'visa' ? 'selected' : '' }}>Visa</option>
                                        <option value="home_country_id" {{ old('document_type', $document->document_type) == 'home_country_id' ? 'selected' : '' }}>Home Country ID</option>
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
                                           id="expiry_date" name="expiry_date" 
                                           value="{{ old('expiry_date', $document->expiry_date->format('Y-m-d')) }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="document_path">Replace Document File (Optional)</label>
                                    <div class="file-upload-area">
                                        <input type="file" class="file-input @error('document_path') is-invalid @enderror" 
                                               id="document_path" name="document_path" 
                                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <div class="file-upload-text">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <p>Click to upload or drag and drop</p>
                                            <span>PDF, JPG, PNG, DOC, DOCX (Max: 10MB)</span>
                                            <p class="mt-2 text-info">
                                                <small>Current file: {{ basename($document->document_path) }}</small>
                                            </p>
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
                                <a href="{{ route('documents.driver.show', $document) }}" class="btn btn-secondary mr-2">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Document
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
    // Setup driver dropdown
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Select driver'
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
                <p class="mt-2 text-warning">
                    <small>This will replace the current file</small>
                </p>
            `;
        } else {
            fileUploadText.innerHTML = `
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload or drag and drop</p>
                <span>PDF, JPG, PNG, DOC, DOCX (Max: 10MB)</span>
                <p class="mt-2 text-info">
                    <small>Current file: {{ basename($document->document_path) }}</small>
                </p>
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