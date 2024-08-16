@extends('layouts.custom')

@section('title', 'Form Ruang Kelas')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('tahun-ajaran.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('tahun-ajaran.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Ruang Kelas</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('tahun-ajaran.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Kode Ruang Kelas</label>
                <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran"
                    name="tahun_ajaran" placeholder="e.g. 2021/2022" value="{{ old('tahun_ajaran') }}">
                @error('tahun_ajaran')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
