@extends('layouts.app')

@push('styles')
    <style>
        /* Header */
        .header-title {
            font-size: 24px;
            font-weight: bold;
            /* margin-bottom: 20px; */
            text-align: center;
        }

        /* Card Container */
        .card-container {
            display: flex;
            flex-direction: column;
            gap: 35px;
        }

        /* Card */
        .card {
            display: flex;
            flex-direction: row;
            max-height: 250px;
            /* Ensure card-image is on the left */
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Card Image Section */
        .card-image {
            position: relative;
        }

        .card-image img {
            width: 440px;
            height: 280px;
            object-fit: cover;
        }

        .card-image .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
        }

        /* Card Details */
        .card-details {
            flex: 2;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-start;
            /* Ensure alignment with card-image */
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
        }

        .card-text {
            font-size: 14px;
            color: #555;
            margin: 0px;
            /* Kurangi margin bawah */
        }

        /* Rating Section */
        .rating {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin: 0px;
            /* Kurangi margin atas */
        }

        .card-text+.rating {
            margin: 0px;
            /* Atur jarak spesifik hanya untuk elemen setelah .card-text */
        }

        .rating .stars {
            font-size: 18px;
            color: #ffcc00;
        }

        .rating .score-reviews {
            display: flex;
            align-items: center;
        }

        .rating .score {
            background-color: #eaf5ea;
            color: #4caf50;
            font-size: 14px;
            padding: 5px 8px;
            border-radius: 4px;
            margin-right: 10px;
        }

        .rating .reviews {
            font-size: 12px;
            color: #888;
        }

        /* Button */
        .view-place-btn {
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .view-place-btn:hover {
            background-color: #45a049;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <div class="container-fluid w-100 py-5" style="padding-left: 5%; padding-right: 5%">
        <h3 class="pb-4 fw-bold text-center">Bookmarks</h3>
        @if (Auth::check())
            <div class="card-container">
                @foreach ([['title' => 'Garuda Wisnu Kencana (GWK)', 'address' => 'Jl. Raya Uluwatu, Ungasan, Kec. Kuta Sel., Kabupaten Badung, Bali', 'image' => 'GWK_2.png', 'rating' => '4.5', 'reviews' => 'Very Good 371 reviews'], ['title' => 'Ambrogio Patisserie', 'address' => 'Jl. Banda No.26, Citarum, Kec. Bandung Wetan, Kota Bandung', 'image' => 'Ambrogio_2.png', 'rating' => '4.0', 'reviews' => 'Very Good 54 reviews'], ['title' => 'Galeri Nasional Indonesia', 'address' => 'Jl. Medan Merdeka Tim., Gambir, Jakarta Pusat', 'image' => 'GaleriNasionalIndonesia.png', 'rating' => '3.9', 'reviews' => 'Very Good 123 reviews']] as $place)
                    @php
                        $rating = floatval($place['rating']);
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                    @endphp
                    <!-- Card -->
                    <div class="card mb-4 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="card-image">
                                    <img class="img-fluid rounded-start" src="{{ asset('/storage/' . $place['image']) }}" alt="{{ $place['title'] }}" />
                                    <p class="badge">9 images</p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $place['title'] }}</h5>
                                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $place['address'] }}</p>
                                    <div class="rating">
                                        <p class="stars p-0 m-0 pb-1" style="color: #ff8682">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star fs-6"></i>
                                            @endfor
                                            @if ($halfStar)
                                                <i class="fas fa-star-half-alt fs-6"></i>
                                            @endif
                                            @for ($i = $fullStars + $halfStar; $i < 5; $i++)
                                                <i class="far fa-star fs-6"></i>
                                            @endfor
                                        </p>
                                        <div class="score-reviews">
                                            <p class="score">{{ $place['rating'] }}</p>
                                            <p class="reviews"><strong>{{ explode(' ', $place['reviews'])[0] }} {{ explode(' ', $place['reviews'])[1] }}</strong> {{ implode(' ', array_slice(explode(' ', $place['reviews']), 2)) }}</p>
                                        </div>
                                    </div>
                                    <hr style="margin-top: 0px; border-top: 1px solid #000000; width: 100%;">
                                    <div class="d-flex w-100 gap-2">
                                        <a class="rounded-2 flex-grow-0 btn btn-outline-secondary" href="#" style="width: 44px; height: 44px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-bookmark text-dark"></i>
                                        </a>
                                        <a class="btn flex-grow-1 fw-semibold align-content-center" href="#" style="background-color: #8dd3bb">View Place</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center" role="alert">
                Please <a class="alert-link" href="{{ route('login') }}">Login</a> first to view your bookmarks.
            </div>
        @endif
    </div>

    @include('components.footer')
@endsection
