@extends('layouts.app')

@push('styles')
    <style>
        /* Header */
        .header-title {
            font-size: 24px;
            font-weight: bold;
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
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 0;
            height: 100%;
            /* Ensure card takes full height */
        }

        .card .row {
            flex: 1;
            /* Ensure row takes full height */
        }

        .card .card-image,
        .card .card-body {
            height: 100%;
            /* Ensure both image and body take full height */
        }

        .card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            /* Ensure content does not overflow */
            max-height: 250px;
            /* Match the max-height of the card */
        }

        /* Card Image Section */
        .card-image {
            position: relative;
            flex: 1;
        }

        .card-image img {
            width: 100%;
            height: 100%;
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
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
        }

        .card-text {
            font-size: 14px;
            color: #555;
            margin: 0px;
        }

        /* Rating Section */
        .rating {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin: 0px;
        }

        .card-text+.rating {
            margin: 0px;
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
    <div class="container-fluid w-100 py-5" style="padding-left: 5%; padding-right: 5%;">
        <h3 class="pb-4 fw-bold text-center">Bookmarks</h3>
        @if (Auth::check())
            <div class="card-container">
                {{-- Local Bookmarks --}}
                @forelse ($bookmarks as $bookmark)
                    @php
                        $place = $bookmark->destination;
                        $rating = floatval($place->ratings);
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                        $imagePath = Storage::disk('public')->files($place->image_folder_path)[0] ?? null;
                    @endphp
                    <div class="card mb-4 shadow-sm">
                        {{-- ...existing local bookmark card structure... --}}
                        <div class="row g-0 w-100">
                            <div class="col-md-3 p-0">
                                <div class="card-image">
                                    @if ($imagePath)
                                        <img class="img-fluid rounded-start" src="{{ asset('storage/' . $imagePath) }}" alt="{{ $place->name }}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9 px-2">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $place->name }}</h5>
                                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $place->address }}</p>
                                    {{-- ...existing rating display... --}}
                                    <div class="d-flex w-100 gap-2">
                                        <form action="{{ route('bookmarks.destroy', ['bookmark' => $bookmark->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                        </form>
                                        <a class="btn flex-grow-1" href="{{ route('place.detail', ['id' => $place->id]) }}" style="background-color: #8dd3bb">
                                            View Place
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    @if (empty($placesBookmarks))
                        <div class="alert alert-info">No bookmarks yet!</div>
                    @endif
                @endforelse

                {{-- Google Places Bookmarks --}}
                @foreach ($placesBookmarks as $place)
                    <div class="card mb-4 shadow-sm">
                        <div class="row g-0 w-100">
                            <div class="col-md-3 p-0">
                                <div class="card-image">
                                    @if ($place['photo_url'])
                                        <img class="img-fluid rounded-start" src="{{ $place['photo_url'] }}" alt="{{ $place['name'] }}" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9 px-2">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $place['name'] }}</h5>
                                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $place['address'] }}</p>
                                    <div class="rating">
                                        @php
                                            $rating = floatval($place['rating']);
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars >= 0.5;
                                        @endphp
                                        <p class="stars p-0 m-0 pb-1" style="color: #ff8682">
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if ($halfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </p>
                                        <div class="score-reviews">
                                            <p class="score">{{ number_format($place['rating'], 1) }}</p>
                                            <p class="reviews">
                                                <strong>{{ $place['review_count'] }} reviews</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex w-100 gap-2">
                                        <form action="{{ route('bookmarks.destroyV2', ['bookmark' => $place['id']]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                        </form>
                                        <a class="btn flex-grow-1" href="{{ route('place.detail_v2', ['placeId' => $place['place_id']]) }}" style="background-color: #8dd3bb">
                                            View Place
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center">
                Please <a href="{{ route('login') }}">login</a> to view your bookmarks.
            </div>
        @endif
    </div>

    @include('components.footer')
@endsection
