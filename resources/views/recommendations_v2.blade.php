@extends('layouts.app')

@push('styles')
    <style>
        .custom-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            background: #fff;
            width: 100%;
            height: 400px;
            /* Set a fixed height for the card */
        }

        .custom-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Ensure the image covers the card area */
            display: block;
        }

        .custom-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.4);
            color: #ffffff;
            padding: 16px;
            text-align: center;
        }

        .custom-card-title {
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 4px;
        }

        .custom-card-subtitle {
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .custom-button {
            background-color: #8dd3bb;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            /* Ensure the link looks like a button */
        }

        .custom-button:hover {
            background-color: #92c4b8;
        }

        .custom-button i {
            margin-right: 5px;
        }
    </style>
@endpush

@section('content')
    <!-- Recommendations Section -->
    <div class="container py-5">
        <h3 class="mb-4 fw-bold">{{ isset($subtitle) ? $subtitle . ' ' : '' }}Recommendations</h3>
        <div class="row row-cols-1 row-cols-md-2 g-5"> <!-- Increase gap between cards -->
            @foreach ($places as $place)
                <div class="col d-flex justify-content-center">
                    <div class="custom-card">
                        @if ($place['photo_url'])
                            <img src="{{ $place['photo_url'] }}" alt="{{ $place['name'] }}">
                        @else
                            <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder Image">
                        @endif
                        <div class="custom-card-overlay">
                            <h5 class="custom-card-title">{{ $place['name'] }}</h5>
                            <p class="custom-card-subtitle">{{ $place['address'] }}</p>
                            <a class="custom-button text-dark" href="{{ route('place.detail_v2', ['placeId' => $place['id']]) }}">
                                <i class="fas fa-paper-plane pe-2"></i> Lihat
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('components.footer')
@endsection
