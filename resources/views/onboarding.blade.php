@extends('layouts.app')

@push('styles')
    <style>
        .hero-section {
            background-image: url('{{ asset('storage/onboarding.png') }}');
            background-size: cover;
            background-position: center;
            min-height: 60vh;
        }

        .search-container {
            max-width: 500px;
        }
    </style>

    <style>
        .custom-input-wrapper {
            border: 1px solid #a0d2c6;
            border-radius: 20px;
            padding: 8px;
            display: flex;
            align-items: center;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 16px;
        }

        .custom-input:focus {
            box-shadow: none;
        }

        .custom-button {
            background-color: #a0d2c6;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            display: flex;
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

    <style>
        .custom-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            /* Semi-transparent black */
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
    <!-- Hero Section -->
    <div class="hero-section d-flex align-items-center text-white" style="z-index: -1">
        <div class="container text-center py-5">
            <h2 class="fw-bold mb-4">Helping Others</h2>
            <h1 class="display-4 fw-bold mb-4">LIVE & TRAVEL</h1>
            <p class="lead mb-4">Temukan destinasi lebih mudah</p>

            <div class="container mt-5">
                <div class="custom-input-wrapper py-2 px-3">
                    <input class="custom-input" type="text" placeholder="Search...">
                    <button class="custom-button">
                        <i class="fas fa-paper-plane pe-2"></i> Cari Tempat
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Search Results -->
    <div class="container py-5" style="z-index: 1">
        <h3 class="mb-4">Hasil Pencarian</h3>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="custom-card">
                    <img src="{{ asset('/storage/Tahura.png') }}" alt="Entrance to Tahura forest, surrounded by tall trees">
                    <div class="custom-card-overlay">
                        <h5 class="custom-card-title">Tahura</h5>
                        <p class="custom-card-subtitle">Jalan Dago Pakar</p>
                        <button class="custom-button text-dark">
                            <i class="fas fa-paper-plane pe-2"></i> Lihat
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="custom-card">
                    <img src="{{ asset('/storage/Tahura.png') }}" alt="Entrance to Tahura forest, surrounded by tall trees">
                    <div class="custom-card-overlay">
                        <h5 class="custom-card-title">Tahura</h5>
                        <p class="custom-card-subtitle">Jalan Dago Pakar</p>
                        <button class="custom-button text-dark">
                            <i class="fas fa-paper-plane pe-2"></i> Lihat
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recommendations -->
    <div class="container py-5" style="z-index: 1">
        <h3 class="mb-4">Rekomendasi</h3>
        <div class="row g-4">
            @foreach ([['title' => 'Tones No.6', 'address' => 'Jalan abc', 'image' => 'tonesno6.png'], ['title' => 'Tahura', 'address' => 'Jalan Dago Pakar', 'image' => 'Tahura.png']] as $place)
                <div class="col-md-6 d-flex justify-content-center">
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

    <!-- Bookmarks -->
    <div class="container py-5" style="z-index: 1">
        <h3 class="mb-4">Bookmark</h3>
        <div class="row g-4">
            @foreach ([['title' => 'GWK', 'address' => 'Jalan Raya Uluwatu, Bali', 'image' => 'gwk.png'], ['title' => 'Ambrogio', 'address' => 'Jalan Banda, Bandung', 'image' => 'ambrogio.png']] as $place)
                <div class="col-md-6 d-flex justify-content-center">
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

    <!-- Footer Section -->
    @include('components.footer')
@endsection
