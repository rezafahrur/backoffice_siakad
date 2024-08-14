@extends('layouts.custom')

@section('title', 'Edit Semester')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('semester.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('semester.index') }}">
                <img style="height: 50px" src="{{ asset('assets/img/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Semester'</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('semester.update', $semester) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_semester" class="form-label">Semester</label>
                <select class="form-control @error('nama_semester') is-invalid @enderror" id="nama_semester"
                    name="nama_semester">
                    <option value="Ganjil"
                        {{ old('nama_semester', $semester->nama_semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap"
                        {{ old('nama_semester', $semester->nama_semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                    <option value="Pendek"
                        {{ old('nama_semester', $semester->nama_semester) == 'Pendek' ? 'selected' : '' }}>Pendek</option>
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
