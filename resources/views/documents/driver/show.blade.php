@extends('layouts.app')

@section('title', 'View Driver Document')
@section('header', 'View Driver Document')

@section('content')

<div class="documents-container">
    {{-- Page header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title text-white">
                <i class="fas fa-file-alt"></i>
                Document: {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}
            </h1>
            <div class="header-actions">
                <a href="{{ route('documents.driver.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Documents
                </a>
                <a href="{{ route('documents.driver.edit', $document) }}" class="btn btn-primary ml-2">
                    <i class="fas fa-edit"></i> Edit Document
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="row">
        <div class="col-lg-8">
            {{-- Document details --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Document Information</h5><br>
                </div>
                <div class="card-body text-white bg-dark">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="detail-item">
                                <label>Driver:</label>
                                <span>
                                    <strong>{{ $document->driver->name }}</strong>
                                </span>
                            </div>
                            <div class="detail-item"><label>Document Type:</label> <span>{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</span></div>
                            <div class="detail-item"><label>File Name:</label> <span>{{ basename($document->document_path) }}</span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Expiry Date:</label>
                                <span class="{{ $document->expiry_date->isPast() ? 'text-danger' : ($document->expiry_date->diffInDays(now()) <= 30 ? 'text-warning' : '') }}">
                                    {{ $document->expiry_date->format('M d, Y') }}
                                    @if($document->expiry_date->isPast())
                                        <i class="fas fa-exclamation-triangle ml-1" title="Expired"></i>
                                    @elseif($document->expiry_date->diffInDays(now()) <= 30)
                                        <i class="fas fa-exclamation-circle ml-1" title="Expiring Soon"></i>
                                    @endif
                                </span>
                            </div>
                            <div class="detail-item">
                                <label>Status:</label>
                                <span class="status-badge status-{{ $document->expiry_date->isPast() ? 'expired' : ($document->expiry_date->diffInDays(now()) <= 30 ? 'warning' : 'valid') }}">
                                    {{ $document->expiry_date->isPast() ? 'Expired' : ($document->expiry_date->diffInDays(now()) <= 30 ? 'Expiring Soon' : 'Valid') }}
                                </span>
                            </div>
                            <div class="detail-item"><label>Uploaded On:</label> <span>{{ $document->created_at->format('M d, Y h:i A') }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document preview --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-eye"></i> Document Preview</h5><br>
                </div>
                <div class="card-body text-white bg-dark">
                    @php
                        $mimeType = Storage::mimeType($document->document_path);
                        $isViewable = in_array($mimeType, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf']);
                    @endphp
                    
                    @if($isViewable)
                        @if(strpos($mimeType, 'image/') === 0)
                            <div class="text-center">
                                <img src="{{ route('documents.driver.view', $document) }}" 
                                     alt="Document Preview" 
                                     class="img-fluid rounded shadow"
                                     style="max-height: 600px;">
                            </div>
                        @elseif($mimeType === 'application/pdf')
                            <div class="text-center">
                                <iframe src="{{ route('documents.driver.view', $document) }}" 
                                        width="100%" 
                                        height="600" 
                                        frameborder="0"
                                        class="rounded shadow">
                                </iframe>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-file fa-4x mb-3"></i>
                            <p class="mb-2">This file type cannot be previewed in the browser.</p>
                            <p>Please download the file to view its contents.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Driver information --}}
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white"><h5 class="mb-0"><i class="fas fa-user"></i> Driver Information</h5><br></div>
                <div class="card-body text-white bg-dark">
                    <div class="detail-item"><label>Name:</label> <span>{{ $document->driver->name }}</span></div>
                    <div class="detail-item"><label>Contact:</label> <span>{{ $document->driver->contact_no }}</span></div>
                    <div class="detail-item"><label>Emergency Contact:</label> <span>{{ $document->driver->emergency_contact ?? 'N/A' }}</span></div>
                    <div class="detail-item">
                        <label>Status:</label>
                        <span class="status-badge status-{{ $document->driver->status == 'active' ? 'valid' : 'expired' }}">
                            {{ ucfirst($document->driver->status) }}
                        </span>
                    </div>
                </div>
            </div>
            {{-- Document actions --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white"><h5 class="mb-0"><i class="fas fa-cog"></i> Document Actions</h5><br></div>
                <div class="card-body text-white bg-dark">
                    <div class="d-grid gap-2">
                        <a href="{{ route('documents.driver.view', $document) }}" class="btn btn-info btn-block" target="_blank"><i class="fas fa-eye"></i> View Full Screen</a>
                        <a href="{{ route('documents.driver.download', $document) }}" class="btn btn-primary btn-block"><i class="fas fa-download"></i> Download Document</a>
                        <a href="{{ route('documents.driver.edit', $document) }}" class="btn btn-warning btn-block" style="background:#378047;border-color:#378047"><i class="fas fa-edit"></i> Edit Document</a>
                        <form action="{{ route('documents.driver.destroy', $document) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this document?')">
                                <i class="fas fa-trash"></i> Delete Document
                            </button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@push('styles')
<style>
.detail-item {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 12px;
}

.detail-item label {
    font-weight: 700;
    color: #f8f9fa;
    margin: 0;
    white-space: nowrap;
}

.detail-item span {
    text-align: left;
    color: #ffffff;
}

/* Status badges */
.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 12px;
    text-align: center;
    white-space: nowrap;
}

.status-valid { background-color: #38c172; color: #fff; }
.status-warning { background-color: #ffb142; color: #fff; }
.status-expired { background-color: #ff6b6b; color: #fff; }

.btn-block { margin-bottom: 10px; }
</style>
@endpush
@endsection
