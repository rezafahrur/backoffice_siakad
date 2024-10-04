@extends('layouts.app')

@section('title', 'Edit Ruang Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('jurusan.index') }}">Jurusan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Jurusan</h4>
            <form action="{{ route('jurusan.update', $jurusan) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                    <input type="text" class="form-control @error('kode_jurusan') is-invalid @enderror" id="kode_jurusan"
                        name="kode_jurusan" placeholder="Kode Jurusan"
                        value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}">
                    @error('kode_jurusan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                    <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan"
                        name="nama_jurusan" placeholder="Nama Jurusan"
                        value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}">
                    @error('nama_jurusan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <a href="{{ route('jurusan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>


@endsection
