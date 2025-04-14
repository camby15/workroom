<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Shrinq" />
    <meta name="description" content="Company Signup Form" />
    <link rel="icon" href="{{ asset('images/logo 1.png') }}" />
    <link rel="stylesheet" href="{{ asset('style/auth-2.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/mediaQuery.css') }}" />

    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet" />

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Stak | Company</title>
</head>

<body id="company-body">
    <div class="picture-roll">
        <div class="slider"></div>
    </div>
    <div class="form-box">
        <form id="Signin" class="input-group" action="{{ route('register.company.store') }}" method="POST">
            @csrf
            <h2 id="intro">Company Account</h2>

            <div class="company-name">
                <input type="text" name="company_name" required />
                <label>Company Name</label>
            </div>

            <div class="company-email">
                <input type="email" name="company_email" required />
                <label>Company Email</label>
            </div>

            <div class="company-phone">
                <input type="text" name="company_phone" required />
                <label>Company Phone</label>
            </div>

            <div class="primary-email">
                <input type="email" name="primary_email" required />
                <label>Primary Email</label>
            </div>

            <div class="pincode">
                <input type="password" name="pin_code" required maxlength="4" minlength="4" pattern="\d{4}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);" />
                <label>Pin (4 digits)</label>
            </div>

            <div class="terms-checkbox">
                <input type="checkbox" id="terms" name="terms" required />
                <label for="terms">
                    I agree to the
                    <a href="#">Terms and Conditions</a>
                </label>
            </div>

            <button type="submit" class="submit">Sign up</button>

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
