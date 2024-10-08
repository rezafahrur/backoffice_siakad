@php
    $pathPhoto = public_path('storage/' . $berita->path_photo);
@endphp

@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
    <div class="container mt-4">
        <!-- Navbar -->
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('berita.index') }}">Berita</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Detail
                </li>
            </ol>
        </nav>

        {{-- Detail Berita --}}
        <div class="card">
            <div class="card-header bg-secondary text-white">   
                <h5 class="card-title mb-0">Detail Berita</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Judul:</h6>
                    <p class="fw-bold">{{ $berita->judul_berita }}</p>
                </div>
                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Kategori:</h6>
                    <p class="fw-bold text-uppercase">{{ $berita->kategoriBerita->kategori_berita ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Judul Photo:</h6>
                    @if ($berita->path_photo && file_exists($pathPhoto))
                        <img src="{{ asset('storage/' . $berita->path_photo) }}" alt="photo" style="width: 100px;">
                    @else
                        <img src={{ asset('assets/images/others/default-avatar.jpg') }}>
                    @endif
                </div>

                <div class="mb-3">
                    <h6 class="mb-1 text-muted">Isi Berita:</h6>
                    <div>
                        {!! $berita->isi_berita !!}
                    </div>
                </div>
                <a href="{{ route('berita.index') }}" class="btn btn-secondary">Kembali</a>

            </div>
        </div>
    </div>
@endsection
