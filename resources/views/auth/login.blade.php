@extends('layouts.app')

@push('styles')
    <style>
        .login-container {
            min-width: 35%;
            margin: 0 auto;
            /* padding: 2rem; */
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-google,
        .btn-apple {
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        .btn-google:hover,
        .btn-apple:hover {
            background-color: #f8f9fa;
        }

        .divider {
            text-align: center;
            /* margin: 1.5rem 0; */
        }

        .divider::before,
        .divider::after {
            content: '';
            display: inline-block;
            width: 25%;
            height: 1px;
            background: #dee2e6;
            vertical-align: middle;
        }

        .divider span {
            /* padding: 0 0.5rem; */
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1" id="main-content">
        <div class="mb-4">
            <img class="brand-logo img-fluid" src="{{ asset('storage/logo.png') }}" alt="Travelin Logo" style="max-width: 5dvw;">
        </div>
        <div class="login-container">
            <h2 class="fw-bold">Login</h2>
            <p class="text-muted">Login to access your Travelin account</p>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" placeholder="irabah@gmail.com" required>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input class="form-control" id="password" name="password" type="password" placeholder="****************" required>
                        <button class="btn btn-outline-secondary" id="toggle-password" type="button" style="min-width: 3dvw">
                            <i class="fa-solid fa-eye" id="toggle-password-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input id="remember" name="remember" type="checkbox">
                        <label class="form-label mb-0" for="remember">Remember me</label>
                    </div>
                    <a class="text-danger text-decoration-none" href="{{ route('forgot.password') }}">Forgot Password</a>
                </div>
                <div class="d-grid mb-3">
                    <button class="btn btn-success border-0 text-dark fw-medium" type="submit" style="background-color: #8dd3bb">Login</button>
                </div>
                <p class="text-center">Don't have an account? <a class="text-danger text-decoration-none" href="{{ route('register') }}">Sign up</a></p>
                <div class="divider pb-3"><span>Or login with</span></div>
                <div class="d-flex gap-2">
                    <button class="btn btn-google w-50" type="button" style="border-color: #8dd3bb;">
                        <i class="fab fa-google me-2"></i> Google
                    </button>
                    <button class="btn btn-apple w-50" type="button" style="border-color: #8dd3bb;">
                        <i class="fab fa-apple me-2"></i> Apple
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#toggle-password').on('click', function() {
            var passwordField = $('#password');
            var passwordIcon = $('#toggle-password-icon');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endpush
