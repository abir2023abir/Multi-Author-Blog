<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - Stories</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Background decorative elements */
        body::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: #e2e8f0;
            border-radius: 50%;
            opacity: 0.3;
            z-index: 1;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -150px;
            right: -150px;
            width: 400px;
            height: 400px;
            background: #fecaca;
            border-radius: 50%;
            opacity: 0.2;
            z-index: 1;
        }

        .signup-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            font-family: 'Inter', serif;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
            font-weight: 400;
        }

        .signup-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        /* Social Sign-up Buttons */
        .social-buttons {
            margin-bottom: 32px;
        }

        .social-button {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            color: #374151;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            text-decoration: none;
        }

        .social-button:hover {
            border-color: #d1d5db;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .social-button.google {
            border-color: #e5e7eb;
        }

        .social-button.facebook {
            background: #1877f2;
            border-color: #1877f2;
            color: white;
        }

        .social-button.facebook:hover {
            background: #166fe5;
            border-color: #166fe5;
        }

        .social-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .google-icon {
            background: #4285f4;
            color: white;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
        }

        .facebook-icon {
            background: white;
            color: #1877f2;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
        }

        /* Divider */
        .divider {
            text-align: center;
            margin: 32px 0;
            position: relative;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 16px;
            position: relative;
            z-index: 2;
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
        }

        /* Terms and Conditions */
        .terms-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .terms-checkbox {
            width: 16px;
            height: 16px;
            margin-right: 12px;
            margin-top: 2px;
            accent-color: #ef4444;
        }

        .terms-text {
            font-size: 0.875rem;
            color: #374151;
            line-height: 1.5;
        }

        .terms-link {
            color: #ef4444;
            text-decoration: none;
            font-weight: 500;
        }

        .terms-link:hover {
            text-decoration: underline;
        }

        /* Sign Up Button */
        .signup-button {
            width: 100%;
            padding: 14px;
            background: #1f2937;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }

        .signup-button:hover {
            background: #111827;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(31, 41, 55, 0.3);
        }

        /* Login Link */
        .login-link {
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .login-link a {
            color: #ef4444;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        /* Success Messages */
        .success-message {
            color: #10b981;
            background: #d1fae5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .signup-container {
                padding: 10px;
            }

            .signup-card {
                padding: 30px 20px;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .signup-card {
                padding: 20px 16px;
            }

            .page-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Create Your Account</h1>
            <p class="page-subtitle">Join Our Community of Writers</p>
        </div>

        <!-- Sign-up Card -->
        <div class="signup-card">
            <!-- Social Sign-up Buttons -->
            <div class="social-buttons">
                <button class="social-button google" onclick="signUpWithGoogle()">
                    <div class="social-icon google-icon">G</div>
                    Sign up with Google
                </button>
                <button class="social-button facebook" onclick="signUpWithFacebook()">
                    <div class="social-icon facebook-icon">f</div>
                    Sign up with Facebook
                </button>
            </div>

            <!-- Divider -->
            <div class="divider">
                <span>Or sign up with email</span>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" id="signupForm">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-input"
                        placeholder="Enter your full name"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input"
                        placeholder="Enter your email address"
                        required
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-container">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="Enter your password"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <span class="material-icons" id="passwordIcon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="password-container">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Confirm your password"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <span class="material-icons" id="passwordConfirmationIcon">visibility</span>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="terms-container">
                    <input id="terms" type="checkbox" name="terms" class="terms-checkbox" required>
                    <label for="terms" class="terms-text">
                        I agree to the <a href="#" class="terms-link">terms and conditions</a>
                    </label>
                </div>
                @error('terms')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <!-- Sign Up Button -->
                <button type="submit" class="signup-button">Sign Up</button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const iconId = fieldId === 'password' ? 'passwordIcon' : 'passwordConfirmationIcon';
            const passwordIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                passwordIcon.textContent = 'visibility';
            }
        }

        function signUpWithGoogle() {
            // Implement Google OAuth
            alert('Google sign-up coming soon!');
        }

        function signUpWithFacebook() {
            // Implement Facebook OAuth
            alert('Facebook sign-up coming soon!');
        }

        // Form validation
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;

            if (!name || !email || !password || !confirmPassword) {
                e.preventDefault();
                alert('Please fill in all fields');
                return false;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }

            if (!terms) {
                e.preventDefault();
                alert('Please agree to the terms and conditions');
                return false;
            }
        });

        // Add loading state to button
        document.getElementById('signupForm').addEventListener('submit', function() {
            const button = document.querySelector('.signup-button');
            button.textContent = 'Creating Account...';
            button.disabled = true;
        });

        // Password strength indicator (optional)
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strength = getPasswordStrength(password);
            // You could add a visual indicator here
        });

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }
    </script>
</body>
</html>
