@extends('layouts.app')

@section('title', 'Jadwal Images')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jadwal</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Jadwal Image</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('jadwal-sementara.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                            <i class="btn-icon-prepend" data-feather="plus-square"></i>
                            Tambah Data
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kelas</th>
                                    <th>File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwal->kelas->programStudi->nama_singkat }} -
                                            {{ $jadwal->kelas->nama_kelas }}</td>
                                        <td>
                                            <img src="{{ asset('upload/jadwal-images/' . $jadwal->file) }}" alt="Image"
                                                width="100px" class="img-thumbnail img-preview"
                                                style="cursor: pointer; border-radius: 0;" data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img-url="{{ asset('upload/jadwal-images/' . $jadwal->file) }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('jadwal-sementara.edit', $jadwal->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="edit"></i>
                                            </a>
                                            <form action="{{ route('jadwal-sementara.destroy', $jadwal->id) }}"
                                                method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-delete btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="#" alt="Preview Image" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Handle the image click event to show modal with the correct image
        document.querySelectorAll('.img-preview').forEach(function(image) {
            image.addEventListener('click', function() {
                var imgUrl = this.getAttribute('data-img-url');
                var modalImage = document.getElementById('modalImage');
                modalImage.src = imgUrl;
            });
        });
    </script>
@endpush
