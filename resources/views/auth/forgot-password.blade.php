@extends('layouts.app')

@push('styles')
    <style>
        .form-container {
            min-width: 35%;
            margin: 0 auto;
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
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex flex-column flex-grow-1 position-relative" id="main-content">
        <div class="position-absolute top-0 start-0 m-4">
            <a class="text-decoration-none text-dark d-flex align-items-center" href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-2"></i> Back to login
            </a>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1">
            <div class="form-container">
                <h2 class="fw-bold">Forgot your password?</h2>
                <p class="text-muted">Don't worry, happens to all of us. Enter your email below to recover your password.</p>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="john.doe@gmail.com" required>
                    </div>
                    <div class="d-grid mb-3">
                        {{-- <button class="btn btn-success border-0 text-dark fw-medium" type="submit" style="background-color: #8dd3bb">Submit</button> --}}
                        <a class="btn btn-success border-0 text-dark fw-medium" type="submit" href="{{ route('verify.password') }}" style="background-color: #8dd3bb">Submit</a>
                    </div>
                    <p class="text-center">Remember your password? <a class="text-danger text-decoration-none" href="{{ route('login') }}">Back to login</a></p>
                    <div class="divider pb-3"><span>Or login with</span></div>
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
    </div>
@endsection
