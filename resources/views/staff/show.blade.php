@extends('layouts.app')

@section('title', 'Staff Details')
@section('header', 'Staff Details')

@section('content')
<div class="staff-container">
    {{-- Page header --}}
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">
                <i class="fas fa-user"></i> Staff: {{ $staff->name }}
            </h1>
            <div class="header-actions">
                <a href="{{ route('staff.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Staff
                </a>
            </div>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="row">
        <div class="col-lg-8">
            {{-- Staff details card --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Staff Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item"><label>Staff ID:</label><span>#{{ $staff->id }}</span></div>
                            <div class="detail-item"><label>Name:</label><span>{{ $staff->name }}</span></div>
                            <div class="detail-item"><label>Position:</label><span>{{ $staff->position ?? 'N/A' }}</span></div>
                            <div class="detail-item"><label>Contact Info:</label><span>{{ $staff->contact_info }}</span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item"><label>Emergency Contact:</label><span>{{ $staff->emergency_contact ?? 'N/A' }}</span></div>
                            <div class="detail-item">
                                <label>Status:</label>
                                <span class="status-badge status-{{ str_replace('_','-',$staff->status) }}">
                                    <i class="fas fa-circle"></i> {{ ucfirst(str_replace('_',' ',$staff->status)) }}
                                </span>
                            </div>
                            <div class="detail-item"><label>Created On:</label><span>{{ $staff->created_at->format('M d, Y h:i A') }}</span></div>
                            <div class="detail-item"><label>Last Updated:</label><span>{{ $staff->updated_at->format('M d, Y h:i A') }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Staff documents card --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt"></i> Documents
                        <span class="badge badge-light ml-2">{{ $staff->documents->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($staff->documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover w-100 text-white">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Document Type</th>
                                        <th>File Name</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Uploaded At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff->documents as $document)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_',' ',$document->document_type)) }}</td>
                                        <td>
                                            <i class="fas fa-file-pdf text-danger mr-1"></i>
                                            {{ $document->original_filename ?? basename($document->document_path) }}
                                        </td>
                                        <td>{{ $document->expiry_date ? $document->expiry_date->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            @if($document->expiry_date && $document->expiry_date->isPast())
                                                <span class="badge badge-danger">Expired</span>
                                            @elseif($document->expiry_date && $document->expiry_date->diffInDays(now()) <= 30)
                                                <span class="badge badge-warning">Expiring Soon</span>
                                            @else
                                                <span class="badge badge-success">Valid</span>
                                            @endif
                                        </td>
                                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('staff.documents.view', ['staff'=>$staff->id,'document'=>$document->id]) }}" target="_blank" class="btn btn-info btn-sm" title="View Document">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('staff.documents.download', ['staff'=>$staff->id,'document'=>$document->id]) }}" class="btn btn-success btn-sm" title="Download Document">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form action="{{ route('staff.documents.destroy', ['staff'=>$staff->id,'document'=>$document->id]) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this document?')" title="Delete Document">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-file-alt fa-3x mb-3"></i>
                            <p>No documents uploaded for this staff member</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Staff actions card --}}
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog"></i> Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary btn-block"><i class="fas fa-edit"></i> Edit Staff</a>
                        <button type="button" class="btn btn-info btn-block upload-document-trigger"><i class="fas fa-upload"></i> Upload Document</button>
                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="d-grid">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this staff member?')">
                                <i class="fas fa-trash"></i> Delete Staff
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Staff quick stats --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar"></i> Quick Stats
                    </h5>
                </div>
                <div class="card-body">
                    <div class="detail-item"><label>Total Documents:</label><span class="badge badge-primary">{{ $staff->documents->count() }}</span></div>
                    <div class="detail-item"><label>Valid Documents:</label><span class="badge badge-success">{{ $staff->documents->filter(fn($doc)=> !$doc->expiry_date || $doc->expiry_date->isFuture())->count() }}</span></div>
                    <div class="detail-item"><label>Expired Documents:</label><span class="badge badge-danger">{{ $staff->documents->filter(fn($doc)=> $doc->expiry_date && $doc->expiry_date->isPast())->count() }}</span></div>
                    <div class="detail-item"><label>Expiring Soon:</label><span class="badge badge-warning">{{ $staff->documents->filter(fn($doc)=> $doc->expiry_date && $doc->expiry_date->isFuture() && $doc->expiry_date->diffInDays(now()) <= 30)->count() }}</span></div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Upload document modal --}}
<div class="modal" id="uploadDocumentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload text-primary me-2"></i> Upload Document for {{ $staff->name }}
                </h5>
                <button type="button" class="close-btn" aria-label="Close">×</button>
            </div>
            <form action="{{ route('staff.documents.store', $staff->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="document_type" class="form-label">Document Type *</label>
                        <select class="form-control" id="document_type" name="document_type" required>
                            <option value="">Select Document Type</option>
                            <option value="emirates_id">Emirates ID</option>
                            <option value="visa">Visa</option>
                            <option value="passport">Passport</option>
                            <option value="employee_contract">Employee Contract</option>
                            <option value="driving_license">Driving License</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date" class="form-label">Expiry Date *</label>
                        <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="form-group">
                        <label for="document_path" class="form-label">Document File *</label>
                        <input type="file" class="form-control" id="document_path" name="document_path" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                        <small class="form-text text-muted">Supported formats: PDF, JPG, JPEG, PNG, DOC, DOCX. Max file size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn"><i class="fas fa-times me-1"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary confirm-upload-btn"><i class="fas fa-upload me-1"></i> Upload Document</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.detail-item{display:flex;align-items:center;gap:5px;margin-bottom:12px;}
.detail-item label{font-weight:600;color:#fff;margin:0;min-width:140px;}
.detail-item span{color:#fff;flex:1;word-break:break-word;white-space:normal;}
.status-badge{display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:500;}
.status-active{background:rgba(56,193,114,0.15);color:#38c172;}
.status-inactive{background:rgba(255,107,107,0.15);color:#ff6b6b;}
.status-on-leave{background:rgba(66,153,225,0.15);color:#4299e1;}
.btn-block{margin-bottom:10px;}
.table thead th{border-bottom:2px solid #dee2e6;padding:12px 15px;color:#fff;}
.table tbody td{border-bottom:1px solid #dee2e6;padding:12px 15px;color:#fff;word-break:break-word;white-space:normal;}
.modal{position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.7);display:none;z-index:10000;overflow:hidden;}
.modal-dialog{max-width:600px;margin:100px auto;}
.modal-content{background:rgba(26,42,58,0.95);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.1);border-radius:16px;color:#e8e8e8;}
.modal-header{border-bottom:1px solid rgba(255,255,255,0.1);padding:1.5rem;display:flex;justify-content:space-between;align-items:center;}
.modal-title{color:#3490dc;font-weight:600;display:flex;align-items:center;margin:0;}
.close-btn{background:none;border:none;color:#a0aec0;font-size:24px;cursor:pointer;padding:0;width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:4px;}
.close-btn:hover{color:#fff;background:rgba(255,255,255,0.1);}
.modal-body{padding:1.5rem;}
.modal-footer{border-top:1px solid rgba(255,255,255,0.1);padding:1.5rem;display:flex;gap:12px;justify-content:flex-end;}
.form-control{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.1);color:#e8e8e8;}
.form-control:focus{background:rgba(255,255,255,0.12);border-color:#4ecdc4;box-shadow:0 0 0 2px rgba(78,205,196,0.25);color:#e8e8e8;}
.form-label{color:#a0aec0;font-weight:600;}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadModal = document.getElementById('uploadDocumentModal');
    const closeBtn = document.querySelector('.close-btn');
    const cancelBtn = document.querySelector('.cancel-btn');

    document.querySelectorAll('.upload-document-trigger').forEach(button => {
        button.addEventListener('click', function() {
            if(uploadModal) { uploadModal.style.display='block'; document.body.classList.add('modal-open'); }
        });
    });

    [closeBtn, cancelBtn].forEach(el=>{
        if(el) el.addEventListener('click', ()=>{ if(uploadModal){ uploadModal.style.display='none'; document.body.classList.remove('modal-open'); } });
    });

    if(uploadModal){
        uploadModal.addEventListener('click', (e)=>{ if(e.target===uploadModal){ uploadModal.style.display='none'; document.body.classList.remove('modal-open'); } });
    }

    document.addEventListener('keydown', function(event){
        if(event.key==='Escape' && uploadModal && uploadModal.style.display==='block'){
            uploadModal.style.display='none';
            document.body.classList.remove('modal-open');
        }
    });
});
</script>
@endpush
@endsection
