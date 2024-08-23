@extends('layouts.custom')

@section('title', 'Form Paket MataKuliah')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('berita.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('paket-matakuliah.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    <div class="card-header">
        <h4 class="card-title">Form Tambah Berita</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul_berita" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="judul_berita" name="judul_berita" required>
            </div>

            <div class="mb-3">
                <label for="kategori_berita_id" class="form-label">Kategori Berita</label>
                <select class="form-control" id="kategori_berita_id" name="kategori_berita_id" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($kategoriBerita as $kategori)
                        <option value="{{ $kategori->id }}">{{ strtoupper($kategori->kategori_berita) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="path_photo" class="form-label">Upload Photo</label>
                <input type="file" class="form-control" id="path_photo" name="path_photo" required>
            </div>

            <div class="mb-3">
                <label for="isi_berita" class="form-label">Isi Berita</label>
                <textarea class="form-control" id="isi_berita" name="isi_berita" rows="10" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    {{-- CKEditor Script --}}
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('isi_berita');
    </script>
@endsection
