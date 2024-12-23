@extends('layouts.app')

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Welcome to Travelin') }}</div>

                    <div class="card-body">
                        <h5 class="card-title">{{ __('Get Started with Travelin') }}</h5>
                        <p class="card-text">{{ __('We are excited to have you on board. Let’s get you set up and ready to explore the world with Travelin.') }}</p>
                        <a class="btn btn-primary" href="{{ url('/home') }}">{{ __('Proceed to Dashboard') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
