@extends('layouts.custom')

@section('title', 'Detail Mata Kuliah')

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
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Detail Mata Kuliah</h4>
    </div>

    <div class="card-body">
        <dl class="row">
            {{-- Nama Program Studi --}}
            <dt class="col-sm-3">Nama Program Studi</dt>
            <dd class="col-sm-9">{{ $matkul->nama_program_studi }}</dd>

            {{-- Nama Lengkap --}}
            <dt class="col-sm-3">Kode Mata Kuliah</dt>
            <dd class="col-sm-9">{{ $matkul->kode_matakuliah }}</dd>

            {{-- Alamat Jalan --}}
            <dt class="col-sm-3">Nama Mata Kuliah</dt>
            <dd class="col-sm-9">{{ $matkul->nama_matakuliah }}</dd>

            {{-- RT/RW --}}
            <dt class="col-sm-3">SKS</dt>
            <dd class="col-sm-9">{{ $matkul->sks }}</dd>

        </dl>
    </div>

    {{-- <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama Program Studi</label>
            <span class="form-control border-1 border-primary">{{ $matkul->nama_program_studi }}</span>
        </div>
        <div class="mb-3">
            <label class="form-label">Kode Mata Kuliah</label>
            <span class="form-control border-1 border-primary">{{ $matkul->kode_matakuliah }}</span>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Mata Kuliah</label>
            <span class="form-control border-1 border-primary">{{ $matkul->nama_matakuliah }}</span>
        </div>
        <div class="mb-3">
            <label class="form-label">SKS</label>
            <span class="form-control border-1 border-primary">{{ $matkul->sks }}</span>
        </div>

    </div>

    </div> --}}
@endsection
