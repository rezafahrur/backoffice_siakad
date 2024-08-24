@extends('layouts.custom')

@section('title', 'Detail Berita')

@section('content')
    <div class="container mt-4">
        <!-- Navbar -->
        <nav class="navbar navbar-light">
            <div class="container d-block">
                <a href="{{ route('berita.index') }}" class="btn"><i class="bi bi-chevron-left"></i></a>
                <a class="navbar-brand ms-4" href="{{ route('berita.index') }}">
                    <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
                </a>
            </div>
        </nav>

        {{-- Detail Berita --}}
        <div class="card shadow-sm border-light">
            <div class="card-header ">
                <h4 class="card-title">{{ $berita->judul_berita }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Kategori:</h6>
                    <p class="fw-bold text-uppercase">{{ $berita->kategoriBerita->kategori_berita }}</p>
                </div>
                

                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Foto:</h6>
                    <img src="{{ asset('storage/' . $berita->path_photo) }}" class="img-fluid rounded border" alt="Foto Berita" style="max-width: 300px; height: auto;">
                </div>
                
                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Isi Berita:</h6>
                    <div class="border p-3 rounded" style="background-color: #f8f9fa;">
                        {!! $berita->isi_berita !!}
                    </div>
                </div>

                <!-- Optional: Add action buttons or additional information here -->
                
            </div>
        </div>
    </div>
@endsection
