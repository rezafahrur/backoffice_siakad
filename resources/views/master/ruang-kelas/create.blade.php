@extends('layouts.custom')

@section('title', 'Form Ruang Kelas')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('kelas.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('kelas.index') }}">
                <img style="height: 50px" src="{{ asset('assets/img/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Ruang Kelas</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kelas.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="kode_ruang_kelas" class="form-label">Kode Ruang Kelas</label>
                <input type="text" class="form-control @error('kode_ruang_kelas') is-invalid @enderror"
                    id="kode_ruang_kelas" name="kode_ruang_kelas" placeholder="Kode Ruang Kelas"
                    value="{{ old('kode_ruang_kelas') }}">
                @error('kode_ruang_kelas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- email --}}
            <div class="mb-3">
                <label for="nama_ruang_kelas" class="form-label">Nama Ruang Kelas</label>
                <input type="text" name="nama_ruang_kelas"
                    class="form-control @error('nama_ruang_kelas') is-invalid @enderror" id="nama_ruang_kelas"
                    value="{{ old('nama_ruang_kelas') }}">
                @error('nama_ruang_kelas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- password --}}
            <div class="mb-3">
                <label for="kapasitas" class="form-label">Kapasitas</label>
                <input type="text" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                    id="kapasitas" value="{{ old('kapasitas') }}">
                @error('kapasitas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- <a href="{{ route($dormitory_route["index"]) }}" class="btn btn-secondary">Back</a> --}}
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
