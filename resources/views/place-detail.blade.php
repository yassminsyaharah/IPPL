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

        /* Add these new styles */
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
                    $rating = floatval($place->ratings);
                    $fullStars = floor($rating);
                    $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                @endphp
                <div class="rating mt-2">
                    <p class="stars p-0 m-0">
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
                                    $place->ratings == 5.0 => 'Excellent',
                                    $place->ratings >= 4.0 => 'Good',
                                    $place->ratings >= 3.0 => 'Fair',
                                    $place->ratings >= 2.0 => 'Poor',
                                    $place->ratings >= 1.0 => 'Very Poor',
                                    default => 'Terrible',
                                };
                            @endphp
                            <strong>{{ $ratingText }}</strong> - <strong>({{ $place->review_count }} reviews)</strong>
                        </span>
                    </p>
                </div>
            </div>
            @auth
                <form action="{{ $isBookmarked ? route('bookmarks.destroy', ['bookmark' => $bookmarkId]) : route('bookmarks.store') }}" method="POST">
                    @csrf
                    @if ($isBookmarked)
                        @method('DELETE')
                    @endif
                    <input name="destination_id" type="hidden" value="{{ $place->id }}">
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
            <!-- Rating Details -->
            <div class="d-flex align-items-center mt-4 mb-3">
                <div class="rating d-flex align-items-center">
                    <p class="score mb-0">{{ number_format($place->ratings, 1) }}</p>
                    <div class="d-flex flex-column ms-3">
                        <p class="stars p-0 m-0">
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
                        <p class="reviews mb-0">
                            @php
                                $ratingText = match (true) {
                                    $place->ratings == 5.0 => 'Excellent',
                                    $place->ratings >= 4.0 => 'Good',
                                    $place->ratings >= 3.0 => 'Fair',
                                    $place->ratings >= 2.0 => 'Poor',
                                    $place->ratings >= 1.0 => 'Very Poor',
                                    default => 'Terrible',
                                };
                            @endphp
                            <strong>{{ $ratingText }}</strong> - Based on {{ $place->review_count }} reviews
                        </p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="mt-4">
                <p class="text-justify">
                    {{ $place->description }}
                </p>
                <p>
                    <strong>Alamat:</strong> {{ $place->address }}<br>
                    <strong>Provinsi:</strong> {{ $place->province }}<br>
                    <strong>Jam Operasional:</strong> {{ $place->operating_hours }}
                </p>
            </div>

            <!-- Images Carousel -->
            <div class="mt-4">
                @php
                    $photos = Storage::disk('public')->files($place->image_folder_path);
                @endphp

                @if (count($photos) > 0)
                    <div class="carousel slide" id="placeImageCarousel" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($photos as $index => $photo)
                                <button class="{{ $index === 0 ? 'active' : '' }}" data-bs-target="#placeImageCarousel" data-bs-slide-to="{{ $index }}" type="button" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
                        <div class="carousel-inner rounded">
                            @foreach ($photos as $index => $photo)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ Storage::disk('public')->url($photo) }}" alt="Image of {{ $place->name }}">
                                </div>
                            @endforeach
                        </div>
                        @if (count($photos) > 1)
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
