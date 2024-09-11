@extends('layouts.app')

@section('title', 'Form Program Studi')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('prodi.index') }}">Program Studi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Program Studi</h4>
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

                <a href="{{ route('prodi.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
