<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    position: absolute; inset: 0;
    background: url('{{ asset('images/b2.jpg') }}') no-repeat center/cover;
    opacity: 0.15;
    z-index: -1;
}

/* Authentication container */
.auth-container {
    width: 100%;
    max-width: 450px;
    padding: 40px 30px;
    background: rgba(26, 42, 58, 0.85);
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    backdrop-filter: blur(6px);
    text-align: center;
}
.auth-container h2 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 25px;
    color: #4ecdc4;
}
.logo img {
    max-width: 50%;
    margin-bottom: 20px;
}

/* Email input */
.form-group { margin-bottom: 22px; text-align: left; }
.input-with-icon { position: relative; }
.input-icon {
    position: absolute;
    left: 15px; top: 50%;
    transform: translateY(-50%);
    color: #4ecdc4;
    font-size: 16px;
}
.form-control {
    width: 100%;
    padding: 14px 20px 14px 45px;
    border-radius: 12px;
    border: 1px solid #444;
    background: rgba(30,28,28,0.7);
    color: #e8e8e8;
    font-size: 14px;
}
.form-control:focus {
    outline: none;
    border-color: #4ecdc4;
    box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
    background: rgba(30,28,28,0.85);
}

/* Form button */
.btn-primary {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #4ecdc4 0%, #2d9c92 100%);
    color: #fff;
    font-weight: 600;
    font-size: 16px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.35);
}

/* Login link */
.back-to-login {
    margin-top: 20px;
    font-size: 14px;
}
.back-to-login a {
    color: #4ecdc4;
    font-weight: 500;
    text-decoration: none;
}
.back-to-login a:hover { text-decoration: underline; }

/* Status messages */
.error-message { color: #ff6b6b; font-size: 13px; margin-top: 5px; display: block; }
.success-message { color: #4ecdc4; font-size: 13px; margin-top: 5px; display: block; }

@media (max-width: 600px) {
    .auth-container { width: 90%; padding: 30px 20px; }
    .logo img { max-width: 70%; margin-bottom: 15px; }
}
</style>
</head>
<body>
<!-- Password reset request -->
<div class="auth-container">


    <h2>Reset Your Password</h2>

    @if (session('status'))
        <span class="success-message">{{ session('status') }}</span>
    @endif

    @if (session('error'))
        <span class="error-message">{{ session('error') }}</span>
    @endif

    <!-- Send reset email -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <div class="input-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input id="email" type="email" 
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" 
                    required autocomplete="email" autofocus
                    placeholder="Enter your email address">
            </div>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Send Password Reset Link</button>
    </form>

    <div class="back-to-login">
        <a href="{{ route('login') }}">← Back to Login</a>
    </div>
</div>
</body>
</html>
