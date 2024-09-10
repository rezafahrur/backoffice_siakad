@extends('layouts.app')

@section('title', 'Form Create Jurusan')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Jurusan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Create Jurusan</h4>
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
                    <input type="text" name="nama_jurusan"
                        class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan"
                        value="{{ old('nama_jurusan') }}">
                    @error('nama_jurusan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <a href="{{ route('jurusan.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
