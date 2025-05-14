<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Login to WorkRoom" />
        <meta name="author" content="Scolarmann" />
        <link rel="icon" href="{{ asset('images/WRLogo.jpg') }}" />

        <!-- Fonts and Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            :root {
                --primary-color: #0884FF;
                --text-color: #151515;
                --border-color: #E5E5E5;
            }
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: 'Inter', sans-serif;
                background: #F5F6F7;
                color: var(--text-color);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            .login-box {
                display: flex;
                background: white;
                border-radius: 3px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
                width: 100%;
                max-width: 1000px;
                min-height: 600px;
                position: relative;
            }
            .login-form-section {
                flex: 1;
                padding: 80px;
                max-width: 520px;
            }
            .login-illustration-section {
                flex: 1.2;
                padding: 80px;
                background: #F8F9FA;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            .logo {
                height: 48px;
                margin-bottom: 40px;
            }
            .form-header {
                margin-bottom: 24px;
            }
            .form-header h1 {
                font-size: 20px;
                font-weight: 500;
                margin: 0 0 4px 0;
            }
            .form-header p {
                color: #666;
                font-size: 13px;
                margin: 0;
            }
            .input-group {
                margin-bottom: 16px;
            }
            .input-group input {
                width: 100%;
                padding: 8px 12px;
                border: 1px solid #E5E5E5;
                border-radius: 3px;
                font-size: 14px;
                background-color: #F7F9FC;
                transition: all 0.2s;
            }
            .input-group input:focus {
                outline: none;
                border-color: var(--primary-color);
                background-color: #fff;
            }
            .input-group .error {
                color: #dc3545;
                font-size: 12px;
                margin-top: 4px;
            }
            .submit-btn {
                width: 100%;
                padding: 8px 12px;
                background: #0884FF;
                color: white;
                border: none;
                border-radius: 3px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.2s;
                margin-top: 8px;
            }
            .submit-btn:hover {
                background: #0066CC;
            }
            .social-login {
                margin-top: 32px;
            }
            .social-login p {
                color: #666;
                font-size: 13px;
                margin-bottom: 12px;
            }
            .social-buttons {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                justify-content: center;
            }
            .social-btn {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 3px;
                transition: all 0.2s;
                text-decoration: none;
                color: white;
            }
            .social-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            .social-btn.apple {
                background: #000000;
            }
            .social-btn.google {
                background: #DB4437;
            }
            .social-btn.yahoo {
                background: #720E9E;
            }
            .social-btn.facebook {
                background: #1877F2;
            }
            .social-btn.linkedin {
                background: #0A66C2;
            }
            .social-btn.microsoft {
                background: #00A4EF;
            }
            .signup-link {
                margin-top: 32px;
                font-size: 13px;
            }
            .signup-link a {
                color: #0884FF;
                text-decoration: none;
                font-weight: 500;
            }
            .signup-link a:hover {
                text-decoration: underline;
            }
            .illustration-content {
                margin-top: 24px;
            }
            .illustration-content h2 {
                font-size: 20px;
                margin-bottom: 8px;
            }
            .illustration-content p {
                color: #666;
                font-size: 14px;
                margin-bottom: 16px;
            }
            .learn-more-btn {
                color: #0884FF;
                text-decoration: none;
                font-size: 14px;
                font-weight: 500;
            }
            .learn-more-btn:hover {
                text-decoration: underline;
            }
            @media (max-width: 768px) {
                .login-box {
                    flex-direction: column;
                    min-height: auto;
                }
                .login-form-section {
                    padding: 40px;
                    max-width: none;
                }
                .login-illustration-section {
                    display: none;
                }
            }
            .footer {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 16px;
                text-align: center;
                font-size: 14px;
                color: #666;
                background: rgba(255, 255, 255, 0.9);
                border-top: 1px solid var(--border-color);
            }
            .footer-links {
                display: flex;
                justify-content: center;
                gap: 16px;
                margin-bottom: 8px;
            }
            .footer-links a {
                color: #666;
                text-decoration: none;
                transition: color 0.2s;
                font-size: 14px;
            }
            .footer-links a:hover {
                color: var(--primary-color);
            }
            @media (max-width: 768px) {
                .footer {
                    position: relative;
                    margin-top: 32px;
                }
            }
        </style>

        <title>WorkRoom | Login</title>
    </head>
    <body>
        <div class="login-box">
            <div class="login-form-section">
                <img src="{{ asset('images/WRLogo.jpg') }}" alt="WorkyRoomie Logo" class="logo">
                
                <div class="form-header">
                    <h1>Sign in</h1>
                    <p>to access Accounts</p>
                </div>

                <form method="POST" action="{{ route('auth.otp.request') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="contact" value="{{ old('contact') }}" placeholder="Email address or mobile number" required />
                        @if ($errors->has('contact'))
                            <span class="error">{{ $errors->first('contact') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="submit-btn">Next</button>

                    <div class="social-login">
                        <p>Sign in using</p>
                        <div class="social-buttons">
                            <a href="#" class="social-btn apple" title="Sign in with Apple"><i class="fa-brands fa-apple"></i></a>
                            <a href="#" class="social-btn google" title="Sign in with Google"><i class="fa-brands fa-google"></i></a>
                            <a href="#" class="social-btn yahoo" title="Sign in with Yahoo"><i class="fa-brands fa-yahoo"></i></a>
                            <a href="#" class="social-btn facebook" title="Sign in with Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="social-btn linkedin" title="Sign in with LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="social-btn microsoft" title="Sign in with Microsoft"><i class="fa-brands fa-microsoft"></i></a>
                        </div>
                    </div>

                    <div class="signup-link">
                        <p>Don't have an account? <a href="{{ route('auth.auth') }}">Sign up now</a></p>
                    </div>
                </form>
            </div>

            <div class="login-illustration-section">
                <img src="{{ asset('images/otpkey.webp') }}" alt="Passwordless Login Illustration" style="max-width: 320px;">
                <div class="illustration-content">
                    <h2>Passwordless sign-in</h2>
                    <p>Move away from risky passwords and experience one-tap access to WorkRoom.</p>
                    <a href="#" class="learn-more-btn">Learn more</a>
                </div>
            </div>
        </div>

        <!-- SweetAlert for notifications -->
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Try Again'
                });
            @endif
        </script>

        <footer class="footer">
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Support</a>
            </div>
            <div class="copyright">
                © {{ date('Y') }} WorkRoom. All rights reserved.
            </div>
        </footer>
    </body>
</html>
