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

    <style>
        .subscription-section {
            background-color: #b9e4d8;
            padding: 40px;
            border-radius: 0 0 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            min-width: 75%;
            margin: 0 auto;
            margin-bottom: -15%;
            /* Adjusted to overlap with footer */
            z-index: 1;
            position: relative;
        }

        .subscription-section h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subscription-section p {
            margin-bottom: 20px;
            color: #555;
        }

        .subscription-section .input-group {
            display: flex;
            margin-top: 10px;
        }

        .subscription-section input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            flex: 1;
        }

        .subscription-section button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .subscription-section button:hover {
            background-color: #555;
        }

        .subscription-section img {
            max-width: 200px;
        }

        footer {
            background-color: #8dd3bb;
            padding: 180px 20px 0px 0px;
            min-width: 100%;
            margin: 0 auto;
            position: relative;
            top: 5%;
            /* Adjusted to overlap with subscription section */
        }

        footer .social-icons {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        footer .social-icons a {
            color: #333;
            font-size: 20px;
            text-decoration: none;
        }

        footer .social-icons a:hover {
            color: #555;
        }

        footer .footer-columns {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        footer .footer-column {
            margin-bottom: 20px;
        }

        footer .footer-column h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        footer .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        footer .footer-column ul li {
            margin-bottom: 8px;
        }

        footer .footer-column ul li a {
            color: #333;
            text-decoration: none;
        }

        footer .footer-column ul li a:hover {
            text-decoration: underline;
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

    <!-- Subscription Section -->
    <div class="subscription-section rounded-5" style="z-index: 2">
        <div class="pe-5">
            <h1>The Travel</h1>
            <p>Get inspired! Receive travel discounts, tips and behind the scenes stories.</p>
            <div class="input-group">
                <input type="email" placeholder="Your email address">
                <button>Subscribe</button>
            </div>
        </div>
        <img src="{{ asset('/storage/mailbox.png') }}" alt="Illustration of a mailbox with a letter inside">
    </div>

    <!-- Footer Section -->
    <footer class="text-dark" style="background-color: #8dd3bb; z-index: 1;">
        <div class="container">
            <div class="row w-100">
                <!-- Social Media Icons -->
                <div class="col-md-2 mb-4">
                    <div class="d-flex">
                        <a class="text-dark me-3 fs-4" href="#"><i class="fab fa-facebook"></i></a>
                        <a class="text-dark me-3 fs-4" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="text-dark me-3 fs-4" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="text-dark fs-4" href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Footer Navigation Links -->
                <div class="col-md-2 mb-4">
                    <h5 class="fw-bold mb-4">Destinasi</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Borobudur</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Pandawa</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Tebing Keraton</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Monas</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="fw-bold mb-4">Aktivitas</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Selancar</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Trekking</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Multi-aktivitas</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Outbound</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="fw-bold mb-4">Travel Blogs</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Bali Travel Guide</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="fw-bold mb-4">Tentang Kita</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Our Story</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Work with us</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="fw-bold mb-4">Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Our Story</a></li>
                        <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Work with us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection
