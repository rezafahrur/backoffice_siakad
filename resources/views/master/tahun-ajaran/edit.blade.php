@extends('layouts.custom')

@section('title', 'Edit Tahun Ajaran')

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
        <h4 class="card-title">Form Tahun Ajaran</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('tahun-ajaran.update', $tahunAjaran) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran"
                    name="tahun_ajaran" placeholder="e.g. 2021/2022"
                    value="{{ old('tahun_ajaran', $tahunAjaran->tahun_ajaran) }}">
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
