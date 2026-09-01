@extends('layouts.app')

@section('content')
<title>Verify</title>
{{-- Verification page container --}}
<div class="verify-container">
    {{-- Show company logo --}}
    <div class="logo">
        <img src="{{ asset('admin/img/logo.png') }}" alt="Logo">
    </div>

    {{-- Email verification card --}}
    <div class="verify-card">
        <div class="card-header">
            <i class="fas fa-envelope-circle-check"></i>
            {{ __('Verify Your Email Address') }}
        </div>

        <div class="card-body">
            {{-- Show resend confirmation --}}
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            {{-- Show verification message --}}
            <div class="verify-message">
                <i class="fas fa-envelope-open-text"></i>
                <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            </div>

            {{-- Resend verification email --}}
            <div class="resend-section">
                <p>{{ __('If you did not receive the email') }},</p>
                <form class="resend-form" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn-resend">
                        <i class="fas fa-paper-plane"></i>
                        {{ __('click here to request another') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Verification page styles --}}
<style>
    .verify-container {
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

    .verify-card {
        background: rgba(26, 42, 58, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 40px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        text-align: center;
    }

    .card-header {
        font-size: 24px;
        font-weight: 600;
        color: #4ecdc4;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }

    .card-header i {
        font-size: 28px;
    }

    .alert-success {
        background: rgba(78, 205, 196, 0.15);
        color: #4ecdc4;
        border: 1px solid rgba(78, 205, 196, 0.3);
        padding: 12px 18px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .verify-message {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .verify-message i {
        font-size: 48px;
        color: #4ecdc4;
        opacity: 0.8;
    }

    .verify-message p {
        color: #e8e8e8;
        font-size: 16px;
        line-height: 1.5;
        margin: 0;
    }

    .resend-section {
        color: #a0aec0;
        font-size: 15px;
        line-height: 1.5;
    }

    .resend-section p {
        margin-bottom: 15px;
    }

    .resend-form {
        display: inline;
    }

    .btn-resend {
        background: transparent;
        border: none;
        color: #4ecdc4;
        text-decoration: underline;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        padding: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
    }

    .btn-resend:hover {
        color: #fff;
    }

    @media (max-width: 576px) {
        .verify-container {
            padding: 15px;
        }

        .verify-card {
            padding: 30px 20px;
        }

        .logo img {
            max-width: 150px;
        }

        .card-header {
            font-size: 20px;
            margin-bottom: 25px;
            flex-direction: column;
            gap: 8px;
        }

        .card-header i {
            font-size: 24px;
        }

        .verify-message i {
            font-size: 40px;
        }

        .verify-message p {
            font-size: 15px;
        }

        .resend-section {
            font-size: 14px;
        }

        .btn-resend {
            font-size: 14px;
        }
    }
</style>
@endsection