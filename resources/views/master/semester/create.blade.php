@extends('layouts.custom')

@section('title', 'Form Semester')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('semester.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('tahun-ajaran.index') }}">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Semester'</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('semester.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nama_semester" class="form-label">Kode Semester</label>
                <select class="form-control @error('nama_semester') is-invalid @enderror" id="nama_semester"
                    name="nama_semester">
                    <option value="Ganjil" {{ old('nama_semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('nama_semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    <option value="Pendek" {{ old('nama_semester') == 'Pendek' ? 'selected' : '' }}>Pendek</option>
                </select>
                @error('nama_semester')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection