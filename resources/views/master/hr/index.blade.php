@extends('layouts.app')

@section('title', 'HR')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">HR</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data HR</h6>

                    <!-- Filter Form -->
                    <div class="d-flex justify-content-end mb-3">
                        <div class="me-2">
                            <button type="button" class="btn btn-success btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="btn-icon-prepend" data-feather="upload-cloud"></i>
                                Import Data
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('hr.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                        </div>
                        <div class="ms-2">
                            <a href="{{ route('hr.download-template') }}" class="btn btn-success btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="download"></i>
                                Download Template
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                    </div>


                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Foto Profil</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hr as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->position->posisi }}</td>
                                        @if ($item->photo_profile == null || !file_exists(public_path('storage/' . $item->photo_profile)))
                                            <td>
                                                <img src="{{ asset('assets/images/others/default-avatar.jpg') }}"
                                                    alt="photo_profile"
                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                    class="img-thumbnail">
                                            </td>
                                        @else
                                            <td>
                                                <img src="{{ asset('storage/' . $item->photo_profile) }}"
                                                    alt="photo_profile" class="img-fluid rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('hr.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('hr.show', $item->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('hr.destroy', $item->id) }}" method="post"
                                                class="d-inline">
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
                                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data HR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('hr.import') }}" method="POST" enctype="multipart/form-data"> <!-- Add enctype -->
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File Excel</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import</button> <!-- Moved submit button inside form -->
            </div>
                </form>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const importForm = document.querySelector('#importModal form');
        const importButton = document.querySelector('#importModal .btn-primary');

        // Listen for the import button click
        importButton.addEventListener('click', function (e) {
            const fileInput = document.querySelector('#file');

            // Check if a file is selected
            if (!fileInput.value) {
                e.preventDefault(); // Prevent form submission
                console.log('No file selected for import');
                alert('Please select a file to import!');
            } else {
                console.log('File selected:', fileInput.files[0].name);
            }
        });
    });
    </script>

@endsection
