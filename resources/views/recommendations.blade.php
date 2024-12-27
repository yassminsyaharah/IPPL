@extends('layouts.app')

@section('content')
    <!-- Content -->
    <div class="container mt-5">
        <h2 class="fw-bold">Recomendations</h2>
        <div class="row g-4 mt-3">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <img class="card-img-top" src="https://placehold.co/300x200" alt="Tones No.6 interior with records">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Tones No.6</h5>
                        <p class="card-text">Jalan abc</p>
                        <a class="btn btn-success btn-sm" href="#">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <img class="card-img-top" src="https://placehold.co/300x200" alt="Entrance of Tahura with trees">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Tahura</h5>
                        <p class="card-text">Jalan Dago Pakar</p>
                        <a class="btn btn-success btn-sm" href="#">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <img class="card-img-top" src="https://placehold.co/300x200" alt="Statue of GWK with a scenic view">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">GWK</h5>
                        <p class="card-text">Jalan Raya Uluwatu, Bali</p>
                        <a class="btn btn-success btn-sm" href="#">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm">
                    <img class="card-img-top" src="https://placehold.co/300x200" alt="Ambrogio interior with bakery items">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Ambrogio</h5>
                        <p class="card-text">Jalan Banda, Bandung</p>
                        <a class="btn btn-success btn-sm" href="#">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
@endsection
