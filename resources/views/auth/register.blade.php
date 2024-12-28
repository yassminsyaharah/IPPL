@extends('layouts.app')

@push('styles')
    <style>
        .form-container {
            min-width: 35%;
            margin: 0 auto;
            /* padding: 2rem; */
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-social {
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        .btn-social:hover {
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
        <div class="form-container">
            <h2 class="fw-bold">Sign up</h2>
            <p class="text-muted">Let’s get you all set up so you can access your personal account.</p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input class="form-control" id="name" name="name" type="text" placeholder="John Doe" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="impal@gmail.com" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input class="form-control" id="phone" name="phone" type="text" placeholder="0810101010" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input class="form-control" id="password" name="password" type="password" placeholder="••••••••••••" required>
                        <button class="btn btn-outline-secondary" id="toggle-password" type="button" style="min-width: 3dvw">
                            <i class="fas fa-eye" id="toggle-password-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <div class="input-group">
                        <input class="form-control" id="confirm_password" name="password_confirmation" type="password" placeholder="••••••••••••" required>
                        <button class="btn btn-outline-secondary" id="toggle-confirm-password" type="button" style="min-width: 3dvw">
                            <i class="fas fa-eye" id="toggle-confirm-password-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" id="terms" name="terms" type="checkbox" required>
                    <label class="form-check-label" for="terms">
                        I agree to all the <a class="text-decoration-none text-danger" href="#">Terms</a> and <a class="text-decoration-none text-danger" href="#">Privacy Policies</a>
                    </label>
                </div>
                <div class="d-grid mb-3">
                    <button class="btn btn-success border-0 text-dark fw-medium" type="submit" style="background-color: #8dd3bb">Create account</button>
                </div>
                <p class="text-center">Already have an account? <a class="text-decoration-none text-danger" href="{{ route('login') }}">Login</a></p>
                <div class="divider"><span>Or Sign up with</span></div>
                <div class="d-flex gap-2">
                    <button class="btn btn-social w-50" type="button" style="border-color: #8dd3bb;">
                        <i class="fab fa-google me-2"></i> Google
                    </button>
                    <button class="btn btn-social w-50" type="button" style="border-color: #8dd3bb;">
                        <i class="fab fa-apple me-2"></i> Apple
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#toggle-password, #toggle-confirm-password').on('click', function() {
                const inputId = $(this).attr('id') === 'toggle-password' ? 'password' : 'confirm_password';
                const iconId = $(this).attr('id') === 'toggle-password' ? 'toggle-password-icon' : 'toggle-confirm-password-icon';

                const passwordField = $(`#${inputId}`);
                const passwordIcon = $(`#${iconId}`);

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endpush
