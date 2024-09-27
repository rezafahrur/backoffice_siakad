@extends('layouts.app')

@php
    $pathPhoto = public_path('storage/' . $berita->path_photo);
@endphp

@section('title', 'Edit Berita')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('berita.index') }}">Berita</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Berita</h4>

            {{-- Display Validation Errors --}}
            <form id="beritaForm" action="{{ route('berita.update', $berita->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul_berita" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control" id="judul_berita" name="judul_berita"
                        value="{{ $berita->judul_berita }}" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_berita_id" class="form-label">Kategori Berita</label>
                    <select class="form-control" id="kategori_berita_id" name="kategori_berita_id" required>
                        @foreach ($kategoriBerita as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ $berita->kategori_berita_id == $kategori->id ? 'selected' : '' }}>
                                {{ strtoupper($kategori->kategori_berita) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="path_photo" class="form-label">Judul Photo</label>
                    <input type="file" class="form-control" id="path_photo" name="path_photo">
                    @if ($berita->path_photo && file_exists($pathPhoto))
                        <img src="{{ asset('storage/' . $berita->path_photo) }}" alt="photo" style="width: 100px;">
                    @else
                        <img src={{ asset('assets/images/others/default-avatar.jpg') }}>
                    @endif
                    @error('photo_profile')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi_berita" class="form-label">Isi Berita</label>
                    <textarea id="summernote" name="isi_berita" required>{{ $berita->isi_berita }}</textarea>
                </div>

                <a href="{{ route('berita.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#summernote').summernote({
                    placeholder: 'Edit your content here...',
                    tabsize: 2,
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        </script>
    @endpush
@endsection
