@extends('layouts.custom')

@section('title', 'Detail User')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('prodi.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('prodi.index') }}">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}
    <div class="card-header">
        <h4 class="card-title">Detail Program Studi</h4>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Kode Program Studi</label>
            <span class="form-control border-1 border-primary">{{ $program_studi->kode_program_studi }}</span>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Program Studi</label>
            <span class="form-control border-1 border-primary">{{ $program_studi->nama_program_studi }}</span>
        </div>
        
    </div>
@endsection
