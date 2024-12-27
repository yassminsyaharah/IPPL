@extends('layouts.app')

@push('styles')
    <style>
        .custom-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .custom-card img {
            width: 100%;
            height: auto;
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
        <h3 class="mb-4 fw-bold">Recommendations</h3>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ([['title' => 'Tones No.6', 'address' => 'Jalan abc', 'image' => 'tonesno6.png'], ['title' => 'Tahura', 'address' => 'Jalan Dago Pakar', 'image' => 'Tahura.png'], ['title' => 'GWK', 'address' => 'Jalan Raya Uluwatu, Bali', 'image' => 'gwk.png'], ['title' => 'Ambrogio', 'address' => 'Jalan Banda, Bandung', 'image' => 'ambrogio.png']] as $place)
                <div class="col d-flex justify-content-center">
                    <div class="custom-card">
                        <img src="{{ asset('storage/' . $place['image']) }}" alt="{{ $place['title'] }}">
                        <div class="custom-card-overlay">
                            <h5 class="custom-card-title">{{ $place['title'] }}</h5>
                            <p class="custom-card-subtitle">{{ $place['address'] }}</p>
                            <button class="custom-button text-dark">
                                <i class="fas fa-paper-plane pe-2"></i> Lihat
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('components.footer')
@endsection
