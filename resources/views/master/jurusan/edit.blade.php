@extends('layouts.custom')

@section('title', 'Edit Ruang Kelas')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('jurusan.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('jurusan.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Jurusan</h4>
    </div>
    <div class="card-body">
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

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
