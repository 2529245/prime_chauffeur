<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Montserrat', sans-serif;
        background: linear-gradient(135deg, #1a2a3a 0%, #2d3b4b 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #e8e8e8;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        opacity: 0.15;
        z-index: -1;
        pointer-events: none;
    }

    .login-container {
        width: 100%;
        max-width: 1000px;
        min-height: 650px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(26, 42, 58, 0.85);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.08);
        flex-direction: column;
        padding: 40px 30px;
        text-align: center;
    }

    .logo img {
        height: auto;
        max-width: 60%;
        margin-bottom: 30px;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
        width: 400px;
        max-width: 100%;
    }
    .form-group label {
        display: block;
        margin-bottom: 10px;
        font-weight: 500;
        font-size: 15px;
        color: #d0d0d0;
        text-align: left;
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

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 15px;
    }
    .remember input { margin-right: 10px; accent-color: #4ecdc4; }
    .forgot-password { color: #4ecdc4; text-decoration: none; font-weight: 500; }
    .forgot-password:hover { text-decoration: underline; }

    .btn-login {
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
    }
    .btn-login:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
        background: linear-gradient(135deg, #3abab2 0%, #4ecdc4 100%);
    }

    .error-message { color: #ff6b6b; font-size: 14px; margin-top: 8px; display: block; }
    .success-message { color: #4ecdc4; font-size: 14px; margin-top: 8px; display: block; }

    .copyright {
        position: absolute;
        bottom: 20px;
        width: 100%;
        text-align: center;
        color: rgba(255,255,255,0.5);
        font-size: 13px;
    }

    @media (max-width: 992px) {
        .login-container { flex-direction: column; height: auto; margin: 40px 0; padding: 30px 20px; }
    }

    @media (max-width: 600px) {
        .login-container { width: 95%; padding: 20px 15px; min-height: auto; }
        .logo img { max-width: 80%; margin-bottom: 20px; }
        .form-group { width: 100%; }
        .remember-forgot { flex-direction: column; align-items: flex-start; gap: 10px; font-size: 14px; }
        .forgot-password { align-self: flex-end; }
        .btn-login { font-size: 16px; padding: 14px; }
        .copyright { display: none; }
    }
</style>
</head>
<body>
<!-- Login form container -->
<div class="login-container">
    <!-- Show company logo -->
    <div class="logo">
        <img src="{{ asset('admin/img/logo.png') }}" alt="Logo" width="35%">
    </div>

    <!-- Submit login details -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Login extra options -->
        <div class="remember-forgot">
            <div class="remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <a href="{{route('password.request')}}" class="forgot-password">Forgot Password?</a>
        </div>

        <button type="submit" class="btn-login">Sign In</button>
    </form>
</div>

<!-- Show copyright text -->
<div class="copyright">
    &copy; {{ date('Y') }}. All rights reserved.
</div>
</body>
</html>