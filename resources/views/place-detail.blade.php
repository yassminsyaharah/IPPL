@extends('layouts.app')

@section('title', 'Tahura')

@section('content')
    <div class="flex-grow-1 p-0 m-0 pt-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center">
            <i class="bi bi-arrow-left fs-4"></i>
            <h1 class="h3 fw-bold text-center flex-grow-1">Tahura</h1>
            <i class="bi bi-bookmark fs-4"></i>
        </div>

        <!-- Horizontal line -->
        <hr class="mt-2" style="border: 2px solid #000000;">

        <div class="px-5 py-2">

            <!-- Content -->
            <div class="mt-4">
                <p class="text-justify">
                    Taman Hutan Raya Ir. H. Djuanda merupakan kawasan konservasi yang terpadu antara alam sekunder dengan hutan tanaman dengan jenis Pinus yang terletak di Sub-Daerah Aliran Sungai Cikapundung dan DAS Citarum yang membentang mulai dari Curug Dago, Dago Pakar sampai Curug Maribaya yang merupakan bagian dari kelompok hutan Gunung Pulosari.
                </p>
                <p>
                    <strong>Alamat:</strong> Kompleks Tahura, Jl. Ir. H. Juanda No.99, Ciburial, Kec. Cimenyan, Kabupaten Bandung, Jawa Barat 40198<br>
                    <strong>Provinsi:</strong> Jawa Barat<br>
                    <strong>Jam Operasional:</strong> 08.00 - 16.00
                </p>
            </div>

            <!-- Images -->
            <div class="p-0 m-0 w-100 row mt-4">
                <div class="col-md-6">
                    <img class="img-fluid rounded" src="https://placehold.co/500x300" alt="Image of a gateway entrance surrounded by pine trees">
                </div>
                <div class="col-md-6">
                    <img class="img-fluid rounded" src="https://placehold.co/500x300" alt="Image of a suspension bridge in a forest">
                </div>
            </div>
        </div>

    </div>
@endsection
