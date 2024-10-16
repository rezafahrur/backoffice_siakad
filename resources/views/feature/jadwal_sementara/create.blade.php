@extends('layouts.app')

@section('title', 'Tambah Jadwal Sementara')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Jadwal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Jadwal</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Jadwal</h4>

            <form action="{{ route('jadwal-sementara.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Kelas --}}
                <div class="mb-3">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id"
                        required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        @foreach ($kelas as $kls)
                            <option value="{{ $kls->id }}" {{ old('kelas_id') == $kls->id ? 'selected' : '' }}>
                                {{ $kls->programStudi->nama_singkat }} - {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- File --}}
                <div class="mb-3">
                    <label for="file" class="form-label">File Image</label>
                    <input class="form-control @error('file') is-invalid @enderror" id="fileInput" type="file"
                        id="file" name="file" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Preview Image --}}
                <div class="mb-3">
                    <label for="imagePreview" class="form-label">Preview File</label>
                    <img id="imagePreview" src="#" alt="Preview Image"
                        style="display: none; max-width: 100%; height: auto;">
                </div>

                <a href="{{ route('jadwal-sementara.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('fileInput').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                alert("Mohon pilih file gambar yang valid (JPEG, PNG, JPG).");
                document.getElementById('imagePreview').style.display = 'none';
            }
        });
    </script>
@endpush
