@forelse ($destinations as $place)
    <div class="col-md-6 d-flex justify-content-center">
        <div class="custom-card">
            @php
                $imagePath = Storage::disk('public')->files($place->image_folder_path)[0] ?? null;
            @endphp
            @if ($imagePath)
                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $place->name }}">
            @endif
            <div class="custom-card-overlay">
                <h5 class="custom-card-title">{{ $place->name }}</h5>
                <p class="custom-card-subtitle">{{ $place->address }}</p>
                <a class="custom-button text-dark" href="{{ route('place.detail', ['id' => $place->id]) }}">
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
