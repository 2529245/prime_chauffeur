@extends('layouts.app')

@section('content')
<title>Register</title>
{{-- Registration page container --}}
<div class="register-container">
    {{-- Show company logo --}}
    <div class="logo">
        <img src="{{ asset('admin/img/logo.png') }}" alt="Logo">
    </div>

    {{-- Registration form card --}}
    <div class="register-card">
        <div class="card-header">{{ __('Create Account') }}</div>

        {{-- Submit registration details --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">{{ __('Full Name') }}</label>
                <div class="input-with-icon">
                    <i class="fas fa-user input-icon"></i>
                    <input id="name" type="text" class="form-control @error('name') error @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                </div>
                @error('name')
                    <span class="error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email Address') }}</label>
                <div class="input-with-icon">
                    <i class="fas fa-envelope input-icon"></i>
                    <input id="email" type="email" class="form-control @error('email') error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                </div>
                @error('email')
                    <span class="error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password" type="password" class="form-control @error('password') error @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                </div>
                @error('password')
                    <span class="error-message" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                </div>
            </div>

            <button type="submit" class="btn-register">
                {{ __('Create Account') }}
            </button>

            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </form>
    </div>
</div>

{{-- Registration page styles --}}
<style>
    .register-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
    }

    .logo {
        margin-bottom: 30px;
        text-align: center;
    }

    .logo img {
        max-width: 200px;
        height: auto;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    .register-card {
        background: rgba(26, 42, 58, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 30px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .card-header {
        font-size: 24px;
        font-weight: 600;
        color: #4ecdc4;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
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

    .btn-register {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #4ecdc4 0%, #3abab2 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 17px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        letter-spacing: 0.5px;
        transition: all 0.3s;
        margin-bottom: 20px;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
        background: linear-gradient(135deg, #3abab2 0%, #4ecdc4 100%);
    }

    .login-link {
        text-align: center;
        color: #a0aec0;
        font-size: 15px;
    }

    .login-link a {
        color: #4ecdc4;
        text-decoration: none;
        font-weight: 500;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 576px) {
        .register-container {
            padding: 15px;
        }

        .register-card {
            padding: 20px;
        }

        .logo img {
            max-width: 150px;
        }

        .card-header {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .form-control {
            padding: 14px 16px 14px 48px;
            font-size: 15px;
        }

        .btn-register {
            padding: 14px;
            font-size: 16px;
        }
    }
</style>
@endsection