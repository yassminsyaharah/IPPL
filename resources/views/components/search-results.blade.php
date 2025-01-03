@forelse ($places as $place)
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
                <a class="custom-button text-dark" href="{{ route('place.detail_v2', ['placeId' => $place['id']]) }}">
                    <i class="fas fa-paper-plane pe-2"></i> Lihat
                </a>
            </div>
        </div>
    </div>
@empty
    <div class="m-0 py-3 px-2">
        <div class="alert alert-warning text-center shadow-sm" role="alert">
            Tidak ada hasil yang ditemukan.
        </div>
    </div>
@endforelse
