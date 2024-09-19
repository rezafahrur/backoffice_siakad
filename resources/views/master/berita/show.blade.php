@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
    <div class="container mt-4">
        <!-- Navbar -->
        <nav class="navbar navbar-light">
            <div class="container d-flex align-items-center">
                <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-chevron-left"></i> Kembali
                </a>
                <a class="navbar-brand ms-4" href="{{ route('berita.index') }}">
                    <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo">
                </a>
            </div>
        </nav>

        {{-- Detail Berita --}}
        <div class="card shadow-sm border-light mt-3">
            <div class="card-header">
                <h4 class="card-title">{{ $berita->judul_berita }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Kategori:</h6>
                    <p class="fw-bold text-uppercase">{{ $berita->kategoriBerita->kategori_berita ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Foto:</h6>
                    @if($berita->path_photo)
                        <img src="{{ asset("storage/$berita->path_photo") }}" class="img-fluid rounded border mb-3" alt="Foto Berita" style="max-width: 100%; height: auto;">
                    @else
                        <p class="text-muted">Tidak ada foto tersedia.</p>
                    @endif
                </div>
                
                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Isi Berita:</h6>
                    <div class="border p-3 rounded" style="background-color: #f8f9fa;">
                        {!! $berita->isi_berita !!}
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection