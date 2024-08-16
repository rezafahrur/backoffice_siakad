@extends('layouts.custom')

@section('title', 'Form Program Studi')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('prodi.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('prodi.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Program Studi</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('prodi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="kode_program_studi" class="form-label">Kode Program Studi</label>
                <input type="text" class="form-control @error('kode_program_studi') is-invalid @enderror"
                    id="kode_program_studi" name="kode_program_studi" placeholder="Kode Program Studi"
                    value="{{ old('kode_program_studi') }}">
                @error('kode_program_studi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_program_studi" class="form-label">Nama Program Studi</label>
                <input type="text" name="nama_program_studi"
                    class="form-control @error('nama_program_studi') is-invalid @enderror" id="nama_program_studi"
                    value="{{ old('nama_program_studi') }}">
                @error('nama_program_studi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
