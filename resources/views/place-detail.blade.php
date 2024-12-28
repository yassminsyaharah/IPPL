@extends('layouts.app')

@section('title', $place->name)

@section('content')
    <div class="flex-grow-1 p-0 m-0 pt-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center px-5">
            <a class="btn p-0 m-0" type="button" href="{{ route('recommendations') }}">
                <i class="fa-solid fa-arrow-left fs-4"></i>
            </a>
            <h1 class="h3 fw-bold text-center flex-grow-1">{{ $place->name }}</h1>
            @auth
                @php
                    $isBookmarked = Auth::user()
                        ->bookmarks()
                        ->where('destination_id', $place->id)
                        ->exists();
                @endphp
                <form action="{{ $isBookmarked? route('bookmarks.destroy', ['bookmark' => Auth::user()->bookmarks()->where('destination_id', $place->id)->first()->id]): route('bookmarks.store') }}" method="POST">
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

            <!-- Images -->
            <div class="p-0 m-0 w-100 row mt-4">
                @php
                    $photos = Storage::disk('public')->files($place->image_folder_path);
                @endphp

                @if (count($photos) > 0)
                    @foreach ($photos as $photo)
                        <div class="col-md-6">
                            <img class="img-fluid rounded" src="{{ Storage::disk('public')->url($photo) }}" alt="Image of {{ $place->name }}">
                        </div>
                    @endforeach
                @else
                    <div class="text-center p-4">
                        <p class="text-muted">Tidak ada gambar tersedia untuk destinasi ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
