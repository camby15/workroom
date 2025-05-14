<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="author" content="Scolarman" />
        <meta name="description" content="Individual Signup Form" />
        <link rel="icon" href="{{ asset('images/WRLogo.jpg') }}" />
        <link rel="stylesheet" href="{{ asset('style/auth-2.css') }}" />
        <link rel="stylesheet" href="{{ asset('style/mediaQuery.css') }}" />

        <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet" />

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <title>WorkRoom | Individual</title>
    </head>
    <body id="company-body">
        <div class="picture-roll">
            <div class="slider"></div>
        </div>
        <div class="form-box">
            <form id="Signin" class="input-group" action="{{ url('/register/individual') }}" method="POST">
                @csrf

                <!-- creating an introduction text -->
                <h2 id="intro">Individual Account</h2>

                <div class="company-name">
                    <input type="text" name="fullname" required />
                    <label>Fullname</label>
                </div>

                <div class="company-email">
                    <input type="email" name="personal_email" required />
                    <label>Personal Email</label>
                </div>

                <div class="company-phone">
                    <input type="text" name="phone_number" required />
                    <label>Phone Number</label>
                </div>

                <div class="pincode">
                    <input type="password" name="pin_code" required maxlength="4" minlength="4" pattern="\d{4}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />
                    <label>Pin (4 digits)</label>
                </div>

                <!-- Terms and conditions checkbox -->
                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required />
                    <label for="terms">
                        I agree to the
                        <a href="#" id="terms-link">Terms and Conditions</a>
                    </label>
                </div>

                <!-- Creating a sign-up button -->
                <button type="submit" class="submit" name="submit">Sign up</button>

                <!-- Login link -->
                <div class="login-link">
                    <p>
                        Already have an account?
                        <a href="{{ route('auth.login') }}">Login here</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- SweetAlert for Success and Error Messages -->

        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            </script>
        @elseif (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                });
            </script>
        @endif

        <!-- Validation Error SweetAlert -->
        @if ($errors->any())
            <script>
                Swal.fire({
                    title: 'Validation Error!',
                    text: '{{ implode(' ', $errors->all()) }}',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                });
            </script>
        @endif
    </body>
</html>
