@extends('layouts.app')

@section('title', 'Detail Skala Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('skala-nilai.index') }}">Skala Nilai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Skala Nilai</h4>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="semester_id" class="form-label">Semester</label>
                    <p class="form-control-plaintext">{{ $skalaNilai->semester->kode_semester }} - {{ $skalaNilai->semester->nama_semester }}</p>
                </div>

                <div class="col-md-6">
                    <label for="program_studi_id" class="form-label">Program Studi</label>
                    <p class="form-control-plaintext">{{ $skalaNilai->programStudi->kode_prodi }} - {{ $skalaNilai->programStudi->nama_program_studi }}</p>
                </div>

                <div class="col-md-6">
                    <label for="nilai_huruf" class="form-label">Nilai Huruf</label>
                    <p class="form-control-plaintext">{{ $skalaNilai->nilai_huruf }}</p>
                </div>

                <div class="col-md-6">
                    <label for="nilai_indeks" class="form-label">Nilai Angka</label>
                    <p class="form-control-plaintext">{{ $skalaNilai->nilai_indeks }}</p>
                </div>

                <div class="col-md-6">
                    <label for="bobot_minimum" class="form-label">Bobot Minimum</label>
                    <p class="form-control-plaintext">{{ $skalaNilai->bobot_minimum }}</p>
                </div>

                <div class="col-md-6">
                    <label for="bobot_maksimum" class="form-label">Bobot Maksimum</label>
                    <p class="form-control-plaintext">{{ $skalaNilai->bobot_maksimum }}</p>
                </div>

                <div class="col-md-6">
                    <label for="tgl_mulai_efektif" class="form-label">Tanggal Mulai Efektif</label>
                    <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($skalaNilai->tgl_mulai_efektif)->format('d-m-Y') }}</p>
                </div>

                <div class="col-md-6">
                    <label for="tgl_akhir_efektif" class="form-label">Tanggal Akhir Efektif</label>
                    <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($skalaNilai->tgl_akhir_efektif)->format('d-m-Y') }}</p>
                </div>
            </div>

            <a href="{{ route('skala-nilai.index') }}" class="btn btn-secondary">Back</a>
            
        </div>
    </div>
@endsection
