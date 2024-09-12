@extends('layouts.app')

@section('title', 'Form Edit Berita')

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
            <h4 class="card-title">Form Edit Berita</h4>
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
                    <label for="path_photo" class="form-label">Upload Photo</label>
                    <input type="file" class="form-control" id="path_photo" name="path_photo">
                    @if ($berita->path_photo)
                        <img src="{{ asset('storage/' . $berita->path_photo) }}" alt="photo"
                            style="width: 100px; margin-top: 10px;">
                    @endif
                </div>

                <div class="mb-3">
                    <label for="isi_berita" class="form-label">Isi Berita</label>
                    {{-- Quill.js Editor Container --}}
                    <div id="editor" style="height: 300px;">
                        {!! $berita->isi_berita !!}
                    </div>
                    <textarea id="isi_berita" name="isi_berita" style="display:none;">{{ $berita->isi_berita }}</textarea>
                </div>

                <a href="{{ route('berita.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    {{-- Include SweetAlert2 Script --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    {{-- Include Quill.js and Quill.css --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>

    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link', 'image'],
                    [{
                        'align': []
                    }, {
                        'color': []
                    }, {
                        'background': []
                    }],
                    ['clean']
                ]
            }
        });

        // Handle form submission
        document.querySelector('#beritaForm').addEventListener('submit', function(e) {
            // Prevent default form submission
            e.preventDefault();

            // Get the HTML content from Quill and set it to the hidden textarea
            document.querySelector('#isi_berita').value = quill.root.innerHTML;

            // Example SweetAlert usage
            Swal.fire({
                title: 'Success!',
                text: 'Your post has been updated successfully.',
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
