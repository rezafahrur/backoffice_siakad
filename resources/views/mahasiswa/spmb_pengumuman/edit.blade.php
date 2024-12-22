@extends('layouts.app')

@section('title', 'Edit Pengumuman SPMB')

@section('content')
    <div class="page-heading">
        <h3>Edit Pengumuman</h3>
    </div>

    <form action="{{ route('spmb_pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul_pengumuman" class="form-label">Judul Pengumuman</label>
            <input type="text" class="form-control @error('judul_pengumuman') is-invalid @enderror" id="judul_pengumuman"
                name="judul_pengumuman" placeholder="Judul Pengumuman"
                value="{{ old('judul_pengumuman', $pengumuman->judul) }}">
            @error('judul_pengumuman')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gambar_pengumuman" class="form-label">Gambar</label>
            @if ($pengumuman->gambar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $pengumuman->gambar) }}" alt="Gambar Pengumuman" class="img-thumbnail"
                        width="200">
                </div>
            @endif
            <input type="file" class="form-control @error('gambar_pengumuman') is-invalid @enderror"
                id="gambar_pengumuman" name="gambar_pengumuman" placeholder="Gambar Pengumuman">
            @error('gambar_pengumuman')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="file_pengumuman">File Pengumuman (PDF)</label>
            @if ($pengumuman->file_pengumuman)
                <div class="mb-2">
                    <a href="{{ asset('storage/' . $pengumuman->file_pengumuman) }}" target="_blank">Lihat File</a>
                </div>
            @endif
            <input type="file" class="form-control @error('file_pengumuman') is-invalid @enderror" id="file_pengumuman"
                name="file_pengumuman" placeholder="File Pengumuman">
            @error('file_pengumuman')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi_pengumuman">Deskripsi</label>
            <textarea class="form-control @error('deskripsi_pengumuman') is-invalid @enderror" id="deskripsi_pengumuman"
                name="deskripsi_pengumuman" rows="5">{{ old('deskripsi_pengumuman', $pengumuman->deskripsi) }}</textarea>
            @error('deskripsi_pengumuman')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <a href="{{ route('spmb_pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
@endsection