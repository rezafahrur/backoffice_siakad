@extends('layouts.custom')

@section('title', 'Detail Ruang Kelas')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route($kelas_route['index']) }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route($kelas_route['index']) }}">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}
    <div class="card-header">
        <h4 class="card-title">Detail Ruang Kelas</h4>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Kode</label>
            <span class="form-control border-1 border-primary">{{ $kelas->kode_ruang_kelas }}</span>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <span class="form-control border-1 border-primary">{{ $kelas->nama_ruang_kelas }}</span>
        </div>
        <div class="mb-3">
            <label class="form-label">Kapasitas</label>
            <span class="form-control border-1 border-primary">{{ $kelas->kapasitas }}</span>
        </div>
    </div>
@endsection
