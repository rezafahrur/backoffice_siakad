@extends('layouts.app')

@section('title', 'Detail Mata Kuliah')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Mata Kuliah
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h4 class="card-title mb-0">Detail Mata Kuliah</h4>
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

                {{-- sks tatap muka --}}
                <dt class="col-sm-3">SKS Tatap Muka</dt>
                <dd class="col-sm-9">{{ $matkul->sks_tatap_muka }}</dd>

                {{-- sks praktek --}}
                <dt class="col-sm-3">SKS Praktek</dt>
                <dd class="col-sm-9">{{ $matkul->sks_praktek }}</dd>

                {{-- sks lapangan --}}
                <dt class="col-sm-3">SKS Lapangan</dt>
                <dd class="col-sm-9">{{ $matkul->sks_praktek_lapangan }}</dd>

                {{-- sks simulasi --}}
                <dt class="col-sm-3">SKS Simulasi</dt>
                <dd class="col-sm-9">{{ $matkul->sks_simulasi }}</dd>

                {{-- metode belajar --}}
                <dt class="col-sm-3">Metode Belajar</dt>
                <dd class="col-sm-9">{{ $matkul->metode_belajar }}</dd>

                {{-- tanggal efektif = tgl_mulai_efektif - tgl_akhir_efektif --}}
                <dt class="col-sm-3">Tanggal Efektif</dt>
                <dd class="col-sm-9">{{ $matkul->tgl_mulai_efektif }} - {{ $matkul->tgl_akhir_efektif }}</dd>
            </dl>
            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
@endsection
