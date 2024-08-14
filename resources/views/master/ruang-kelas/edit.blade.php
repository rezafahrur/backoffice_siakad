@extends('layouts.custom')

@section('title', 'Edit Ruang Kelas')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('kelas.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('kelas.index') }}">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Ruang Kelas</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kelas.update', $kelas) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kode_ruang_kelas" class="form-label">Kode Ruang Kelas</label>
                <input type="text" class="form-control @error('kode_ruang_kelas') is-invalid @enderror"
                    id="kode_ruang_kelas" name="kode_ruang_kelas" placeholder="Kode Ruang Kelas"
                    value="{{ old('kode_ruang_kelas', $kelas->kode_ruang_kelas) }}">
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
                    value="{{ old('nama_ruang_kelas', $kelas->nama_ruang_kelas) }}">
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
                    id="kapasitas" value="{{ old('kapasitas', $kelas->kapasitas) }}">
                @error('kapasitas')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
