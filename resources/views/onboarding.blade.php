@extends('layouts.app')

@push('styles')
    <style>
        .hero-section {
            background-image: url('{{ asset('storage/onboarding.png') }}');
            background-size: cover;
            background-position: center;
            min-height: 60vh;
            top: -5%;
            position: relative;
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

        .category-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(141, 211, 187, 0.9);
            padding: 6px 12px;
            border-radius: 20px;
            color: #fff;
            text-transform: capitalize;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero-section d-flex align-items-center text-white" style="z-index: 1">
        <div class="container text-center py-5">
            <h2 class="fw-bold mb-4">Helping Others</h2>
            <h1 class="display-4 fw-bold mb-4">LIVE & TRAVEL</h1>
            <p class="lead mb-4">Temukan destinasi lebih mudah</p>

            <div class="container mt-5">
                <form class="custom-input-wrapper py-2 px-3" id="searchForm">
                    <input class="custom-input" id="searchInput" name="query" type="text" placeholder="Search..." autocomplete="off">
                    <button class="custom-button" type="submit">
                        <i class="fas fa-paper-plane pe-2"></i> Cari Tempat
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Search Results -->
    <div class="container py-5" style="z-index: 1">
        <h3 class="mb-4">Hasil Pencarian</h3>
        <div class="row g-4" id="searchResults">
            <!-- Search results will be loaded here -->
            <div class="m-0 py-3 px-2">
                <div class="alert alert-info text-center shadow-sm" role="alert">
                    Gunakan kotak pencarian di atas untuk menemukan tempat yang kamu inginkan.
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="container py-5" style="z-index: 1">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Rekomendasi</h3>
            <a class="btn btn-transparent border border-1 text-dark" href="{{ route('recommendations') }}">
                <i class="fas fa-list pe-2"></i> Lihat Banyak Tempat
            </a>
        </div>
        <div class="row g-4">
            @foreach ($places as $place)
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="custom-card">
                        @if ($place['photo_url'])
                            <img src="{{ $place['photo_url'] }}" alt="{{ $place['name'] }}">
                        @else
                            <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder Image">
                        @endif
                        <div class="category-badge">
                            {{ $place['category'] }}
                        </div>
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

    <!-- Bookmarks -->
    @auth
        <div class="container py-5" style="z-index: 1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="m-0">Bookmark</h3>
                <a class="btn btn-transparent border border-1 text-dark" href="{{ route('bookmarks') }}">
                    <i class="fas fa-list pe-2"></i> Lihat Semua
                </a>
            </div>
            <div class="row g-4">
                @php $hasBookmarks = false; @endphp

                @foreach ($placesBookmarks as $place)
                    @php $hasBookmarks = true; @endphp
                    <div class="col-md-6 d-flex justify-content-center">
                        <div class="custom-card">
                            @if ($place['photo_url'])
                                <img src="{{ $place['photo_url'] }}" alt="{{ $place['name'] }}">
                            @else
                                <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder Image">
                            @endif
                            <div class="custom-card-overlay">
                                <h5 class="custom-card-title">{{ $place['name'] }}</h5>
                                <p class="custom-card-subtitle">{{ $place['address'] }}</p>
                                <a class="custom-button text-dark" href="{{ route('place.detail_v2', ['placeId' => $place['place_id']]) }}">
                                    <i class="fas fa-paper-plane pe-2"></i> Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if (!$hasBookmarks)
                    <div class="m-0 py-3 px-2">
                        <div class="alert alert-warning text-center shadow-sm" role="alert">
                            Belum ada tempat yang di-bookmark. Silahkan lihat <a class="alert-link" href="{{ route('recommendations') }}">Rekomendasi</a> untuk menambahkan tempat favoritmu.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endauth

    <!-- Footer Section -->
    @include('components.footer')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();

                let query = $('#searchInput').val();

                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: {
                        query: query
                    },
                    success: function(response) {
                        console.log(response);

                        $('#searchResults').html(response.html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
