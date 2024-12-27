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

        .input-group .btn:focus {
            box-shadow: none;
        }

        .btn-social {
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        .btn-social:hover {
            background-color: #f8f9fa;
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
                <h2 class="fw-bold">Verify code</h2>
                <p class="text-muted">An authentication code has been sent to your email.</p>
                <form method="POST" action="{{ route('verification.verify') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="code">Enter Code</label>
                        <div class="input-group">
                            <input class="form-control" id="code" name="code" type="text" placeholder="7789BM6X" required>
                            <button class="btn btn-outline-secondary" id="toggle-code" type="button" style="min-width: 3dvw">
                                <i class="fas fa-eye" id="toggle-code-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <span class="text-muted">Didn't receive a code?</span>
                        {{-- <a class="text-danger text-decoration-none" href="{{ route('verification.resend') }}">Resend</a> --}}
                        <a class="text-danger text-decoration-none" href="{{ url()->current() }}">Resend</a>
                    </div>
                    <div class="d-grid">
                        {{-- <button class="btn btn-success border-0 text-dark fw-medium" type="submit" style="background-color: #8dd3bb">Verify</button> --}}
                        <a class="btn btn-success border-0 text-dark fw-medium" type="submit" href="{{ route('login') }}" style="background-color: #8dd3bb">Verify</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#toggle-code').on('click', function() {
            var codeField = $('#code');
            var codeIcon = $('#toggle-code-icon');

            if (codeField.attr('type') === 'password') {
                codeField.attr('type', 'text');
                codeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                codeField.attr('type', 'password');
                codeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    </script>
@endpush
