<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Password</title>
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
    margin-bottom: 15px;
    color: #4ecdc4;
}
.auth-container p {
    font-size: 14px;
    color: #ccc;
    margin-bottom: 25px;
}

/* Password input */
.form-group { margin-bottom: 20px; text-align: left; }
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

/* Form buttons */
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
    margin-bottom: 12px;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.35);
}
.link-btn {
    display: inline-block;
    font-size: 14px;
    color: #4ecdc4;
    text-decoration: none;
}
.link-btn:hover { text-decoration: underline; }

.error-message { color: #ff6b6b; font-size: 13px; margin-top: 5px; display: block; }

@media (max-width: 600px) {
    .auth-container { width: 90%; padding: 30px 20px; }
}
</style>
</head>
<body>
<!-- Password confirmation form -->
<div class="auth-container">

    <h2>Confirm Password</h2>
    <p>Please confirm your password before continuing.</p>

    <!-- Submit password confirmation -->
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="form-group">
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input id="password" type="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    name="password" required autocomplete="current-password"
                    placeholder="Enter your password">
            </div>
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Confirm Password</button>

        @if (Route::has('password.request'))
            <a class="link-btn" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        @endif
    </form>
</div>
</body>
</html>
