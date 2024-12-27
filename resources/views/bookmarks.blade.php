@extends('layouts.app')

@push('styles')
    <style>
        /* Container */
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            font-family: "Montserrat", serif;
        }

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
    <div class="container py-4 px-5">
        <h3 class="pb-4 fw-bold">Bookmarks</h3>
        <div class="card-container">
            @foreach ([['title' => 'Garuda Wisnu Kencana (GWK)', 'address' => 'Jl. Raya Uluwatu, Ungasan, Kec. Kuta Sel., Kabupaten Badung, Bali', 'image' => 'GWK_2.png', 'rating' => '4.2', 'reviews' => 'Very Good 371 reviews'], ['title' => 'Ambrogio Patisserie', 'address' => 'Jl. Banda No.26, Citarum, Kec. Bandung Wetan, Kota Bandung', 'image' => 'Ambrogio_2.png', 'rating' => '4.2', 'reviews' => 'Very Good 54 reviews'], ['title' => 'Galeri Nasional Indonesia', 'address' => 'Jl. Medan Merdeka Tim., Gambir, Jakarta Pusat', 'image' => 'GaleriNasionalIndonesia.png', 'rating' => '4.2', 'reviews' => 'Very Good 54 reviews']] as $place)
                <!-- Card -->
                <div class="card">
                    <div class="card-image">
                        <img src="{{ asset('/storage/' . $place['image']) }}" alt="Garuda Wisnu Kencana statue with scenic background" />
                        <p class="badge">9 images</p>
                    </div>
                    <div class="card-details">
                        <h5 class="card-title">{{ $place['title'] }}</h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $place['address'] }}</p>
                        <div class="rating">
                            <p class="stars p-0 m-0" style="color: #ff8682">★★★★★</p>
                            <div class="score-reviews">
                                <p class="score">4.5</p>
                                <p class="reviews">Excellent 100+ reviews</p>
                            </div>
                        </div>
                        <hr style="margin-top: 0px; border-top: 1px solid #000000; width: 100%;">
                        <div class="d-flex w-100 gap-2">
                            <a class="rounded-2 flex-grow-0" href="#" style="width: 44px; height: 44px; padding: 0; display: flex; align-items: center; justify-content: center; border: 1px solid #8dd3bb;">
                                <i class="fas fa-bookmark text-dark"></i>
                            </a>
                            <a class="btn flex-grow-1 fw-semibold align-content-center" href="#" style="background-color: #8dd3bb">View Place</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('components.footer')
@endsection
