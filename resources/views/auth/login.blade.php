<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes, viewport-fit=cover">
    <title>Login - Multi Author Blog</title>

    <!-- Mobile Web App Meta Tags -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Multi Author Blog">
    <meta name="application-name" content="Multi Author Blog">
    <meta name="theme-color" content="#3b82f6">
    <meta name="msapplication-TileColor" content="#3b82f6">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            background: white;
            border-radius: 8px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
            padding: 48px;
            margin: 0 auto;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Back to Homepage */
        .back-to-home {
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .back-link:hover {
            color: #374151;
            background: #f3f4f6;
            border-color: #d1d5db;
            transform: translateX(-2px);
        }

        .back-link .material-symbols-outlined {
            font-size: 18px;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .logo-icon::before {
            content: "★";
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .app-name {
            font-size: 28px;
            font-weight: 800;
            color: #000;
            margin: 0;
        }

        .welcome-title {
            font-size: 24px;
            font-weight: 700;
            color: #000;
            margin: 10px 0 5px 0;
        }

        .welcome-subtitle {
            font-size: 16px;
            color: #6b7280;
            margin: 0;
        }

        /* Authentication Mode Selection */
        .auth-mode-selector {
            display: flex;
            background: #f3f4f6;
            border-radius: 6px;
            padding: 4px;
            margin-bottom: 30px;
        }

        .auth-mode-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background: transparent;
            color: #6b7280;
        }

        .auth-mode-btn.active {
            background: #3b82f6;
            color: white;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        }

        .auth-mode-btn:hover:not(.active) {
            color: #374151;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
            box-sizing: border-box;
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
            transform: translateY(-1px);
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 20px;
            cursor: pointer;
            z-index: 1;
        }

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            margin-right: 8px;
            cursor: pointer;
            position: relative;
        }

        .checkbox:checked {
            background: #3b82f6;
            border-color: #3b82f6;
        }

        .checkbox:checked::after {
            content: "✓";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-label {
            font-size: 14px;
            color: #374151;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 14px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* Login Button */
        .login-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            position: relative;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 16px;
            color: #9ca3af;
            font-size: 14px;
        }

        /* Social Login Buttons */
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-button {
            width: 100%;
            padding: 14px 16px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border: none;
            position: relative;
        }

        .social-button.apple {
            background: #000;
            color: white;
            font-weight: 600;
        }

        .social-button.apple:hover {
            background: #1a1a1a;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .social-button.google {
            background: white;
            color: #374151;
            border: 2px solid #e5e7eb;
            font-weight: 600;
        }

        .social-button.google:hover {
            border-color: #d1d5db;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Create Account Link */
        .create-account {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .create-account-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .create-account-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
        }

        .create-account-link:hover {
            text-decoration: underline;
        }

        /* Error Messages */
        .error-message {
            background: #fef2f2;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #fecaca;
        }

        .success-message {
            background: #f0fdf4;
            color: #16a34a;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #bbf7d0;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .welcome-title {
                font-size: 20px;
            }

            .app-name {
                font-size: 24px;
            }
        }

        /* Animation */
        .login-container {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Back to Homepage Button -->
        <div class="back-to-home">
            <a href="{{ route('home') }}" class="back-link">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Back to Homepage</span>
            </a>
        </div>

        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <div class="logo-icon"></div>
                <h1 class="app-name">Multi Author Blog</h1>
            </div>
            <h2 class="welcome-title">Welcome Back Creative!</h2>
            <p class="welcome-subtitle">We Are Happy To See You Again</p>
        </div>

        <!-- Authentication Mode Selection -->
        <div class="auth-mode-selector">
            <button class="auth-mode-btn active" onclick="setAuthMode('signin')">Sign in</button>
            <button class="auth-mode-btn" onclick="setAuthMode('signup')">Sign Up</button>
        </div>

        <!-- Error/Success Messages -->
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        @if (session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    <span class="material-symbols-outlined input-icon">mail</span>
                </div>
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input"
                        placeholder="Enter your password"
                        required
                    >
                    <span class="material-symbols-outlined input-icon" onclick="togglePassword()" style="cursor: pointer;">visibility</span>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember_me" name="remember" class="checkbox">
                    <label for="remember_me" class="checkbox-label">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="login-button">Login</button>
        </form>

        <!-- Divider -->
        <div class="divider">
            <span>OR</span>
        </div>

        <!-- Social Login Buttons -->
        <div class="social-buttons">
            <button class="social-button apple" onclick="loginWithApple()">
                Log in with Apple
            </button>
            <button class="social-button google" onclick="loginWithGoogle()">
                Log in with Google
            </button>
        </div>

        <!-- Create Account Link -->
        <div class="create-account">
            <p class="create-account-text">Don't have an account?</p>
            <a href="{{ route('register') }}" class="create-account-link">Create Account</a>
        </div>
    </div>

    <script>
        // Authentication mode switching
        function setAuthMode(mode) {
            const buttons = document.querySelectorAll('.auth-mode-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            if (mode === 'signup') {
                window.location.href = '{{ route("register") }}';
            }
        }

        // Password visibility toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = event.target;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        // Social login functions
        function loginWithApple() {
            // Implement Apple login
            alert('Apple login coming soon!');
        }

        function loginWithGoogle() {
            // Implement Google login
            alert('Google login coming soon!');
        }

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }
        });

        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>
