@extends('layouts.app')

@section('title', 'Add Users')

@section('content')

    <title>Add New User</title>
<div class="add-user-container">
    {{-- Page header --}}
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-user-plus"></i>
                Add New User
            </h1>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')
   
    {{-- User form --}}
    <div class="form-card">
        <div class="card-header">
            <h2>User Information</h2>
        </div>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="card-body">
                <div class="form-grid">
                    {{-- First name field --}}
                    <div class="form-group">
                        <label for="first_name">First Name <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                type="text" 
                                class="form-control @error('first_name') error @enderror" 
                                id="first_name"
                                placeholder="Enter first name" 
                                name="first_name" 
                                value="{{ old('first_name') }}">
                        </div>
                        @error('first_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Last name field --}}
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                type="text" 
                                class="form-control @error('last_name') error @enderror" 
                                id="last_name"
                                placeholder="Enter last name" 
                                name="last_name" 
                                value="{{ old('last_name') }}">
                        </div>
                        @error('last_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email field --}}
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email" 
                                class="form-control @error('email') error @enderror" 
                                id="email"
                                placeholder="Enter email address" 
                                name="email" 
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Mobile number field --}}
                    <div class="form-group">
                        <label for="mobile_number">Mobile Number</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone input-icon"></i>
                            <input 
                                type="text" 
                                class="form-control @error('mobile_number') error @enderror" 
                                id="mobile_number"
                                placeholder="Enter mobile number" 
                                name="mobile_number" 
                                value="{{ old('mobile_number') }}">
                        </div>
                        @error('mobile_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User role field --}}
                    <div class="form-group">
                        <label for="role_id">Role <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-shield-alt input-icon"></i>
                            <select class="form-control @error('role_id') error @enderror" name="role_id" id="role_id">
                                <option value="" selected disabled>Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- User status field --}}
                    <div class="form-group">
                        <label for="status">Status <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-circle input-icon"></i>
                            <select class="form-control @error('status') error @enderror" name="status" id="status">
                                <option value="" disabled>Select Status</option>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @error('status')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save User
                    </button>
                    <a class="btn btn-secondary" href="{{ route('users.index') }}">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.add-user-container {
    padding: 25px;
}

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

.form-card {
    background: rgba(26, 42, 58, 0.85);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.05);
    overflow: hidden;
}

.card-header {
    padding: 25px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.card-header h2 {
    font-size: 20px;
    font-weight: 600;
    color: #4ecdc4;
    margin: 0;
}

.card-body {
    padding: 25px;
}

.card-footer {
    padding: 25px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.form-group {
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 15px;
    color: #d0d0d0;
}

.required {
    color: #ff6b6b;
}

.input-with-icon {
    position: relative;
    width: 100%;
}

.input-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #4ecdc4;
    font-size: 18px;
    z-index: 1;
}

.form-control {
    width: 100%;
    padding: 16px 20px 16px 52px;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    font-size: 16px;
    background: rgba(26, 42, 58, 0.7);
    color: #e8e8e8;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4ecdc4;
    box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
    outline: none;
    background: rgba(26, 42, 58, 0.8);
}

.form-control.error {
    border-color: #ff6b6b;
    box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
}

.error-message {
    color: #ff6b6b;
    font-size: 14px;
    margin-top: 8px;
    display: block;
    font-weight: 500;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-success {
    background: linear-gradient(135deg, #38c172 0%, #2aa65c 100%);
    color: #fff;
    box-shadow: 0 4px 15px rgba(56, 193, 114, 0.25);
}

.btn-success:hover {
    background: linear-gradient(135deg, #2aa65c 0%, #38c172 100%);
    box-shadow: 0 6px 20px rgba(56, 193, 114, 0.35);
}

.btn-secondary {
    background: rgba(160, 174, 192, 0.2);
    color: #a0aec0;
    border: 1px solid rgba(160, 174, 192, 0.3);
}

.btn-secondary:hover {
    background: rgba(160, 174, 192, 0.3);
    color: #fff;
}

/* Responsive page styles */
@media (max-width: 768px) {
    .add-user-container {
        padding: 15px;
    }
    
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .card-body, .card-header, .card-footer {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 20px;
    }
    
    .form-control {
        padding: 14px 16px 14px 48px;
        font-size: 15px;
    }
    
    .btn {
        padding: 10px 20px;
        font-size: 15px;
    }
}
</style>
@endsection