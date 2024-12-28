@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Kelola Destinasi</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createDestinationModal" type="button">
                Tambah Destinasi Baru
            </button>
        </div>

        <div class="">
            <table class="table table-striped table-bordered" id="destinationsTable">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Provinsi</th>
                        <th class="text-center">Jam Operasional</th>
                        <th class="text-center">Ratings</th>
                        <th class="text-center">Review Count</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($destinations as $destination)
                        @php
                            $rating = floatval($destination->ratings);
                            $fullStars = floor($rating);
                            $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $destination->name }}</td>
                            <td class="text-center">{{ $destination->description }}</td>
                            <td class="text-center">{{ $destination->province }}</td>
                            <td class="text-center">{{ $destination->operating_hours }}</td>
                            <td class="text-center">
                                <p class="stars p-0 m-0" style="color: #ffcc00">
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if ($halfStar)
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                    @for ($i = $fullStars + $halfStar; $i < 5; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                </p>
                                <p class="m-0">{{ $destination->ratings }}</p>
                            </td>
                            <td class="text-center">{{ $destination->review_count }}</td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editDestinationModal{{ $destination->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#previewImagesModal{{ $destination->id }}">
                                        <i class="fas fa-images"></i>
                                    </button>
                                    <form class="d-inline" action="{{ route('admin.dashboard.destinations.destroy', $destination) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Apakah Anda yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Create Modal -->
        <div class="modal fade" id="createDestinationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.dashboard.destinations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Destinasi Baru</h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input class="form-control" name="name" type="text" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input class="form-control" name="address" type="text" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input class="form-control" name="province" type="text" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jam Operasional</label>
                                <input class="form-control" name="operating_hours" type="text" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ratings</label>
                                <input class="form-control" name="ratings" type="number" step="0.1" min="0" max="5" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Review Count</label>
                                <input class="form-control" name="review_count" type="number" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar</label>
                                <input class="form-control" name="images[]" type="file" accept="image/*" multiple>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
                            <button class="btn btn-success" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modals -->
        @foreach ($destinations as $destination)
            <div class="modal fade" id="editDestinationModal{{ $destination->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.dashboard.destinations.update', $destination) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Destinasi</h5>
                                <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input class="form-control" name="name" type="text" value="{{ $destination->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="description" rows="3" required>{{ $destination->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input class="form-control" name="address" type="text" value="{{ $destination->address }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <input class="form-control" name="province" type="text" value="{{ $destination->province }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jam Operasional</label>
                                    <input class="form-control" name="operating_hours" type="text" value="{{ $destination->operating_hours }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ratings</label>
                                    <input class="form-control" name="ratings" type="number" value="{{ $destination->ratings }}" step="0.1" min="0" max="5" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Review Count</label>
                                    <input class="form-control" name="review_count" type="number" value="{{ $destination->review_count }}" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar</label>
                                    <input class="form-control" name="images[]" type="file" accept="image/*" multiple>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Batal</button>
                                <button class="btn btn-primary" type="submit">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Images Modal -->
            <div class="modal fade" id="previewImagesModal{{ $destination->id }}" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $destination->name }} - Gambar</h5>
                            <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                        </div>
                        <div class="modal-body px-5 w-100 h-100">
                            @php
                                $photos = Storage::disk('public')->files($destination->image_folder_path);
                            @endphp

                            @if (count($photos) > 0)
                                <div class="carousel slide" id="carousel{{ $destination->id }}" data-bs-ride="carousel">
                                    {{-- <div class="carousel-indicators">
                                        @foreach ($photos as $index => $photo)
                                            <button class="{{ $index == 0 ? 'active' : '' }}" data-bs-target="#carousel{{ $destination->id }}" data-bs-slide-to="{{ $index }}" type="button" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}">
                                            </button>
                                        @endforeach
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-1 d-flex align-items-center justify-content-center">
                                            <button class="carousel-control-prev bg-secondary ms-2" data-bs-target="#carousel{{ $destination->id }}" data-bs-slide="prev" type="button">
                                                <span class="fa fa-chevron-left" aria-hidden="true"></span>
                                                <span class="visually-hidden">Sebelumnya</span>
                                            </button>
                                        </div>
                                        <div class="col-10 px-5">
                                            <div class="carousel-inner">
                                                @foreach ($photos as $index => $photo)
                                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                        <img class="d-block w-100" src="{{ Storage::disk('public')->url($photo) }}" alt="Gambar {{ $index + 1 }}" style="object-fit: contain; height: 100%;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-1 d-flex align-items-center justify-content-center">
                                            <button class="carousel-control-next bg-secondary me-2" data-bs-target="#carousel{{ $destination->id }}" data-bs-slide="next" type="button">
                                                <span class="fa fa-chevron-right" aria-hidden="true"></span>
                                                <span class="visually-hidden">Berikutnya</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-4">
                                    <p class="text-muted">Tidak ada gambar tersedia untuk destinasi ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <style>
        .custom-carousel-control {
            width: 5%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .carousel-control-prev {
            left: 0%;
            max-width: 3%;
        }

        .carousel-control-next {
            right: 0%;
            max-width: 3%;
        }

        .carousel-control-prev span,
        .carousel-control-next span {
            font-size: 2rem;
            color: white;
        }

        .modal-xl {
            min-width: 90%;
            max-width: 90%;
            margin: 2rem auto;
        }

        /* Additional styling for better appearance */
        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn {
            margin: 0 2px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#destinationsTable').DataTable({
                ordering: false,
                searching: false,
                paging: false,
                info: false,
                responsive: true,
            });
        });
    </script>
@endpush
