@extends('layouts.custom')

@section('title', 'Form Create Jurusan')

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
        <h4 class="card-title">Form Create Jurusan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('jurusan.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
                <input type="text" class="form-control @error('kode_jurusan') is-invalid @enderror" id="kode_jurusan"
                    name="kode_jurusan" placeholder="Kode Jurusan" value="{{ old('kode_jurusan') }}">
                @error('kode_jurusan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror"
                    id="nama_jurusan" value="{{ old('nama_jurusan') }}">
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
