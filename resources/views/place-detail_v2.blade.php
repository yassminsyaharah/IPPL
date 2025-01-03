@extends('layouts.app')

@section('title', $place->name)

@push('styles')
    <style>
        .rating .stars {
            font-size: 18px;
            color: #ff8682;
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

        .carousel-inner {
            max-height: 100%;
            background-color: #f8f9fa;
        }

        .carousel-item {
            height: 100%;
            text-align: center;
        }

        .carousel-item img {
            max-height: 100%;
            max-width: 100%;
            width: auto;
            height: auto;
            margin: auto;
        }
    </style>
@endpush

@section('content')
    <div class="flex-grow-1 p-0 m-0 pt-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center px-5">
            <a class="btn p-0 m-0" type="button" href="{{ route('recommendations') }}">
                <i class="fa-solid fa-arrow-left fs-4"></i>
            </a>
            <div class="text-center flex-grow-1">
                <h1 class="h3 fw-bold mb-0">{{ $place->name }}</h1>
                @php
                    $rating = floatval($place->rating);
                    $fullStars = floor($rating);
                    $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                @endphp
                <div class="rating mt-2">
                    <p class="stars p-0 m-0">
                        <span class="score me-2">{{ number_format($place->rating, 1) }}</span>
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        @if ($halfStar)
                            <i class="fas fa-star-half-alt"></i>
                        @endif
                        @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                            <i class="far fa-star"></i>
                        @endfor
                        <span class="ms-2 reviews">
                            @php
                                $ratingText = match (true) {
                                    $place->rating == 5.0 => 'Excellent',
                                    $place->rating >= 4.0 => 'Good',
                                    $place->rating >= 3.0 => 'Fair',
                                    $place->rating >= 2.0 => 'Poor',
                                    $place->rating >= 1.0 => 'Very Poor',
                                    default => 'Terrible',
                                };
                            @endphp
                            <strong>{{ $ratingText }}</strong> - <strong>({{ $place->review_count }} reviews)</strong>
                        </span>
                    </p>
                </div>
            </div>
            @auth
                <form action="{{ $isBookmarked ? route('bookmarks.destroyV2', ['bookmark' => $bookmarkId]) : route('bookmarks.storeV2') }}" method="POST">
                    @csrf
                    @if ($isBookmarked)
                        @method('DELETE')
                    @endif
                    <input name="place_id" type="hidden" value="{{ $place->id }}">
                    <button class="btn btn-link p-0 m-0" type="submit">
                        @if ($isBookmarked)
                            <i class="fa-solid fa-bookmark fs-4"></i>
                        @else
                            <i class="fa-regular fa-bookmark fs-4"></i>
                        @endif
                    </button>
                </form>
            @endauth
        </div>

        <!-- Horizontal line -->
        <hr class="mt-2" style="border: 2px solid #000000;">

        <div class="px-5 py-2">
            <!-- Content -->
            <div class="mt-4">
                <p>
                    <strong>Alamat:</strong> {{ $place->address }}
                    <a class="ps-1" href="{{ $place->maps_link }}" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </p>
                <h4>Reviews</h4>
                @if (count($place->reviews) > 0)
                    @foreach ($place->reviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>{{ $review['authorAttribution']['displayName'] ?? 'Anonymous' }}</strong>
                                    <div class="rating">
                                        @for ($i = 0; $i < $review['rating']; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                        @for ($i = $review['rating']; $i < 5; $i++)
                                            <i class="far fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="card-text">{{ $review['text']['text'] ?? 'No review text' }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No reviews available for this place.</p>
                @endif
            </div>

            <!-- Images Carousel -->
            <div class="mt-4">
                @if (count($place->photos) > 0)
                    <div class="carousel slide" id="placeImageCarousel" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($place->photos as $index => $photo)
                                <button class="{{ $index === 0 ? 'active' : '' }}" data-bs-target="#placeImageCarousel" data-bs-slide-to="{{ $index }}" type="button" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
                        <div class="carousel-inner rounded">
                            @foreach ($place->photos as $index => $photoUrl)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ $photoUrl }}" alt="Image {{ $index + 1 }} of {{ $place->name }}">
                                </div>
                            @endforeach
                        </div>
                        @if (count($place->photos) > 1)
                            <button class="carousel-control-prev" data-bs-target="#placeImageCarousel" data-bs-slide="prev" type="button">
                                <span class="carousel-control-prev-icon bg-secondary rounded-5 p-4" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" data-bs-target="#placeImageCarousel" data-bs-slide="next" type="button">
                                <span class="carousel-control-next-icon bg-secondary rounded-5 p-4" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="text-center p-4">
                        <p class="text-muted">Tidak ada gambar tersedia untuk destinasi ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
