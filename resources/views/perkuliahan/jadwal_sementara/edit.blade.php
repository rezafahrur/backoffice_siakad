@extends('layouts.app')

@section('title', 'Edit Jadwal Sementara')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('jadwal-sementara.index') }}">Jadwal</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Jadwal</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Jadwal</h4>

            <form action="{{ route('jadwal-sementara.update', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Kelas --}}
                <div class="mb-3">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id"
                        required>
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}" {{ $jadwal->kelas_id == $kls->id ? 'selected' : '' }}>
                                {{ $kls->programStudi->nama_singkat }} - {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Hidden File Input --}}
                <input class="form-control @error('file') is-invalid @enderror" id="fileInput" type="file" name="file"
                    style="display: none;">
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                {{-- Current Image with Overlay for Upload --}}
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="image-upload-container" id="imageUploadContainer">
                        <img id="imagePreview" src="{{ asset('upload/jadwal-images/' . $jadwal->file) }}" alt="Image"
                            style="max-width: 100%; height: auto;">
                        <div class="overlay">
                            <div class="text">Upload Foto</div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('jadwal-sementara.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .image-upload-container {
            position: relative;
            width: 100%;
            max-width: 300px;
            cursor: pointer;
        }

        .image-upload-container img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .image-upload-container .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-upload-container:hover .overlay {
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('imageUploadContainer').addEventListener('click', function() {
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    document.querySelector('.overlay').style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                alert("Mohon pilih file gambar yang valid (JPEG, PNG, JPG).");
            }
        });
    </script>
@endpush
