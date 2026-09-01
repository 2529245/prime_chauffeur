@auth
    {{-- Logged in error page --}}
    @extends('layouts.app')

    @section('title', 'Permission Error')

@section('content')
<!-- Error page content -->
<div class="error-container">
    <div class="error-content">
        <div class="error-icon">
            <i class="fas fa-ban"></i>
        </div>
        <div class="error-code">403</div>
        <h1 class="error-title">Permission Denied</h1>
        <p class="error-message">You don't have permission to access this page.</p>
        <p class="error-description">Please contact your administrator if you believe this is an error.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>
</div>

{{-- Error page styles --}}
<style>
    .error-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
        padding: 20px;
    }

    .error-content {
        text-align: center;
        background: rgba(26, 42, 58, 0.85);
        backdrop-filter: blur(8px);
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.08);
        max-width: 500px;
        width: 100%;
    }

    .error-icon {
        font-size: 80px;
        color: #ff6b6b;
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .error-code {
        font-size: 100px;
        font-weight: 800;
        color: #4ecdc4;
        line-height: 1;
        margin-bottom: 10px;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
    }

    .error-title {
        font-size: 28px;
        font-weight: 600;
        color: #fff;
        margin-bottom: 15px;
    }

    .error-message {
        color: #ff6b6b;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .error-description {
        color: #a0aec0;
        font-size: 16px;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    .btn {
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4ecdc4 0%, #2bb5ad 100%);
        color: #fff;
        border: 1px solid rgba(78, 205, 196, 0.3);
        box-shadow: 0 4px 15px rgba(78, 205, 196, 0.25);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2bb5ad 0%, #4ecdc4 100%);
        box-shadow: 0 6px 20px rgba(78, 205, 196, 0.35);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .error-content {
            padding: 40px 30px;
            margin: 20px;
        }

        .error-code {
            font-size: 80px;
        }

        .error-title {
            font-size: 24px;
        }

        .error-message {
            font-size: 16px;
        }

        .error-description {
            font-size: 15px;
        }
    }

    @media (max-width: 576px) {
        .error-content {
            padding: 30px 20px;
        }

        .error-code {
            font-size: 60px;
        }

        .error-icon {
            font-size: 60px;
        }

        .error-title {
            font-size: 22px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 15px;
        }
    }
</style>
@endsection
@endauth

@guest
{{-- Guest error page --}}
<!-- Guest page layout -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission Denied</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Guest page styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #1a2a3a 0%, #2d3b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e8e8e8;
            padding: 20px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('images/b2.jpg') }}') no-repeat center center;
            background-size: cover;
            opacity: 0.15;
            z-index: -1;
            pointer-events: none;
        }

        .error-container {
            background: rgba(26, 42, 58, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.1);
            max-width: 500px;
            width: 100%;
        }

        .error-icon {
            font-size: 80px;
            color: #ff6b6b;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .error-code {
            font-size: 100px;
            font-weight: 800;
            color: #4ecdc4;
            line-height: 1;
            margin-bottom: 10px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
        }

        .error-title {
            font-size: 28px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 15px;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .error-description {
            color: #a0aec0;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .login-link {
            display: inline-block;
            color: #4ecdc4;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 20px;
            border: 2px solid #4ecdc4;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            background: #4ecdc4;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(78, 205, 196, 0.3);
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 40px 30px;
                margin: 20px;
            }

            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 24px;
            }

            .error-message {
                font-size: 16px;
            }

            .error-description {
                font-size: 15px;
            }
        }

        @media (max-width: 576px) {
            .error-container {
                padding: 30px 20px;
            }

            .error-code {
                font-size: 60px;
            }

            .error-icon {
                font-size: 60px;
            }

            .error-title {
                font-size: 22px;
            }

            .login-link {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Show error message -->
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-ban"></i>
        </div>
        <div class="error-code">403</div>
        <h1 class="error-title">Permission Denied</h1>
        <p class="error-message">You don't have permission to access this page.</p>
        <p class="error-description">Please log in with appropriate credentials to continue.</p>
        <a href="{{ route('login') }}" class="login-link">
            <i class="fas fa-sign-in-alt"></i>
            Login Now
        </a>
    </div>
</body>
</html>
@endguest