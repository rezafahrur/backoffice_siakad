@extends('layouts.app')

@section('title', 'Buat Pengumuman SPMB')

@section('content')
    <div class="page-heading">
        <h3>Buat Pengumuman Baru</h3>
    </div>

    <form action="{{ route('spmb_pengumuman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul Pengumuman -->
        <div class="mb-3">
            <label for="judul" class="form-label">Judul Pengumuman</label>
            <input type="text" 
                class="form-control @error('judul') is-invalid @enderror" 
                id="judul" 
                name="judul" 
                placeholder="Judul Pengumuman" 
                value="{{ old('judul') }}">
            @error('judul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Gambar Pengumuman -->
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Pengumuman</label>
            <input type="file" 
                class="form-control @error('gambar') is-invalid @enderror" 
                id="gambar" 
                name="gambar">
            @error('gambar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- File Pengumuman -->
        <div class="mb-3">
            <label for="file_pengumuman" class="form-label">File Pengumuman (PDF)</label>
            <input type="file" 
                class="form-control @error('file_pengumuman') is-invalid @enderror" 
                id="file_pengumuman" 
                name="file_pengumuman">
            @error('file_pengumuman')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Deskripsi Pengumuman -->
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea 
                class="form-control @error('deskripsi') is-invalid @enderror" 
                id="deskripsi" 
                name="deskripsi" 
                rows="5" 
                placeholder="Deskripsi Pengumuman">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <a href="{{ route('spmb_pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
@endsection
