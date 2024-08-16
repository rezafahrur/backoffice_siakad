@extends('layouts.custom')

@section('title', 'Form Mata Kuliah')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('mataKuliah.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('mataKuliah.index') }}">
                <img style="height: 50px" src="{{ asset('assets/img/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}


    <div class="card-header">
        <h4 class="card-title">Form Mata Kuliah</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('mataKuliah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <select name="program_studi_id" id="program_studi_id" class="form-select">
                    <option value="">Pilih Program Studi</option>
                    @foreach ($matkuls as $matkul)
                        <option value="{{ $matkul->id }}">{{ $matkul->nama_program_studi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="kode_matakuliah" class="form-label">Kode Mata Kuliah</label>
                <input type="text" class="form-control @error('kode_matakuliah') is-invalid @enderror"
                    id="kode_matakuliah" name="kode_matakuliah" placeholder="Masukan Kode Mata Kuliah"
                    value="{{ old('kode_matakuliah') }}">
                @error('kode_matakuliah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
                <input type="text" class="form-control @error('nama_matakuliah') is-invalid @enderror"
                    id="nama_matakuliah" name="nama_matakuliah" placeholder="Masukan Nama Mata Kuliah"
                    value="{{ old('nama_matakuliah') }}">
                @error('nama_matakuliah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="sks" class="form-label">SKS</label>
                <input type="text" class="form-control @error('sks') is-invalid @enderror" id="sks" name="sks"
                    placeholder="Masukan jumlah sks" value="{{ old('sks') }}">
                @error('sks')
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
