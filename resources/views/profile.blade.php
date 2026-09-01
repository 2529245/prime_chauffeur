@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <title>Profile</title>
<div class="profile-container">
    {{-- Profile page heading --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-circle"></i>
            Profile
        </h1>
    </div>

    {{-- Show alert messages --}}
    @include('common.alert')

    <div class="profile-content">
        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-avatar">
                    <img src="{{ asset('admin/img/undraw_profile.svg') }}" alt="Profile Avatar">
                </div>
                <div class="profile-info">
                    <h3>{{ auth()->user()->full_name }}</h3>
                    <p class="profile-role">
                        <i class="fas fa-shield-alt"></i>
                        Role: {{ auth()->user()->roles ? auth()->user()->roles->pluck('name')->first() : 'N/A' }}
                    </p>
                    <p class="profile-email">
                        <i class="fas fa-envelope"></i>
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>
        </div>

        <div class="profile-main">
            {{-- Update profile form --}}
            <div class="profile-section">
                <div class="section-header">
                    <i class="fas fa-user-edit"></i>
                    <h2>Profile Information</h2>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="first_name" name="first_name" 
                                       class="form-control @error('first_name') error @enderror"
                                       placeholder="First Name"
                                       value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name }}">
                            </div>
                            @error('first_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" id="last_name" name="last_name"
                                       class="form-control @error('last_name') error @enderror"
                                       placeholder="Last Name"
                                       value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name }}">
                            </div>
                            @error('last_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text" id="mobile_number" name="mobile_number"
                                       class="form-control @error('mobile_number') error @enderror"
                                       placeholder="Mobile Number"
                                       value="{{ old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number }}">
                            </div>
                            @error('mobile_number')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            {{-- Change password form --}}
            <div class="profile-section">
                <div class="section-header">
                    <i class="fas fa-lock"></i>
                    <h2>Change Password</h2>
                </div>
                
                <form action="{{ route('profile.change-password') }}" method="POST" class="profile-form">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="input-with-icon">
                                <i class="fas fa-key input-icon"></i>
                                <input type="password" id="current_password" name="current_password"
                                       class="form-control @error('current_password') error @enderror"
                                       placeholder="Current Password" required>
                            </div>
                            @error('current_password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-with-icon">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" id="new_password" name="new_password"
                                       class="form-control @error('new_password') error @enderror"
                                       placeholder="New Password" required>
                            </div>
                            @error('new_password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_confirm_password">Confirm Password</label>
                            <div class="input-with-icon">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" id="new_confirm_password" name="new_confirm_password"
                                       class="form-control @error('new_confirm_password') error @enderror"
                                       placeholder="Confirm Password" required>
                            </div>
                            @error('new_confirm_password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-success">
                            <i class="fas fa-key"></i>
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-container {
        padding: 25px;
    }

    .page-header {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #4ecdc4;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        font-size: 28px;
    }

    .profile-content {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 30px;
    }

    .profile-card {
        background: rgba(26, 42, 58, 0.85);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.05);
    }

    .profile-avatar img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 4px solid #4ecdc4;
    }

    .profile-info h3 {
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .profile-role, .profile-email {
        color: #a0aec0;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .profile-role i, .profile-email i {
        color: #4ecdc4;
    }

    .profile-section {
        background: rgba(26, 42, 58, 0.85);
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.05);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .section-header h2 {
        font-size: 20px;
        font-weight: 600;
        color: #4ecdc4;
        margin: 0;
    }

    .section-header i {
        font-size: 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
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
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    .btn-primary, .btn-success {
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
    }

    .btn-primary {
        background: linear-gradient(135deg, #4ecdc4 0%, #3abab2 100%);
        color: #fff;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: #fff;
    }

    .btn-primary:hover, .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    }

    @media (max-width: 1024px) {
        .profile-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .profile-sidebar {
            order: 2;
        }
        
        .profile-main {
            order: 1;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 15px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-card, .profile-section {
            padding: 20px;
        }
        
        .profile-avatar img {
            width: 120px;
            height: 120px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 20px;
        }
        
        .section-header h2 {
            font-size: 18px;
        }
        
        .form-control {
            padding: 14px 16px 14px 48px;
            font-size: 15px;
        }
        
        .btn-primary, .btn-success {
            padding: 10px 20px;
            font-size: 15px;
        }
    }
</style>
@endsection