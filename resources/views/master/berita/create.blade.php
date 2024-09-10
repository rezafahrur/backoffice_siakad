@extends('layouts.app')

@section('title', 'Form Tambah Berita')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Berita</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Berita</h4>
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
                    <label for="path_photo" class="form-label">Upload Photo</label>
                    <input type="file" class="form-control @error('path_photo') is-invalid @enderror" id="path_photo"
                        name="path_photo">
                    @error('path_photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi_berita" class="form-label">Isi Berita</label>
                    <div id="editor-container"></div>
                    <input type="hidden" id="isi_berita" name="isi_berita" value="{{ old('isi_berita') }}">
                    @error('isi_berita')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('berita.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


    {{-- Quill.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

    <script>
        // Initialize Quill editor with full toolbar
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        header: [1, 2, 3, false]
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }], // custom dropdown
                    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                    [{
                        'color': []
                    }, {
                        'background': []
                    }], // dropdown with defaults from theme
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }], // superscript/subscript
                    [{
                        'header': 1
                    }, {
                        'header': 2
                    }], // custom button values
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }], // outdent/indent
                    [{
                        'direction': 'rtl'
                    }], // text direction
                    [{
                        'align': []
                    }],
                    ['link', 'image', 'video', 'blockquote', 'code-block'],
                    ['clean'] // remove formatting button
                ]
            }
        });

        // Ensure content is correctly captured before form submission
        document.querySelector('#beritaForm').addEventListener('submit', function(e) {
            document.querySelector('#isi_berita').value = quill.root.innerHTML;

            // Example SweetAlert usage
            e.preventDefault(); // Prevent the form from submitting for demo purposes
            Swal.fire({
                title: 'Success!',
                text: 'Your post has been saved successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Submit the form after confirmation
                }
            });
        });
    </script>
@endsection
