@extends('layouts.app')

@section('title', 'Create Berita')

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
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Berita</h4>

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="beritaForm" action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul_berita" class="form-label">Judul Berita</label>
                    <input type="text" class="form-control @error('judul_berita') is-invalid @enderror" id="judul_berita"
                        name="judul_berita" placeholder="Judul Berita" value="{{ old('judul_berita') }}" required>
                    @error('judul_berita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori_berita_id" class="form-label">Kategori Berita</label>
                    <select class="form-control @error('kategori_berita_id') is-invalid @enderror" id="kategori_berita_id"
                        name="kategori_berita_id" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategoriBerita as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_berita_id') == $kategori->id ? 'selected' : '' }}>
                                {{ strtoupper($kategori->kategori_berita) }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_berita_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="path_photo" class="form-label">Judul Photo</label>
                    <input type="file" class="form-control @error('path_photo') is-invalid @enderror" id="path_photo"
                        name="path_photo">
                    @error('path_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi_berita" class="form-label">Isi Berita</label>
                    <textarea id="summernote" name="isi_berita" class="form-control">{{ old('isi_berita') }}</textarea>
                    @error('isi_berita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('berita.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- Include Summernote JS -->
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
