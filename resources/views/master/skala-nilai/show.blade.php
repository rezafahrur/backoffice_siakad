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
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Detail Skala Nilai</h5>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="semester_id" class="form-label">Semester</label>
                    <input type="text" class="form-control" value="{{ $skalaNilai->semester->kode_semester }} - {{ $skalaNilai->semester->nama_semester }}" readonly>
                </div>

                <div class="col-md-6">
                    <label for="program_studi_id" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" value="{{ $skalaNilai->programStudi->kode_prodi }} - {{ $skalaNilai->programStudi->nama_program_studi }}" readonly>
                </div>

                <div class="col-md-6">
                    <label for="tgl_mulai_efektif" class="form-label">Tanggal Mulai Efektif</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($skalaNilai->tgl_mulai_efektif)->format('d-m-Y') }}" readonly>
                </div>

                <div class="col-md-6">
                    <label for="tgl_akhir_efektif" class="form-label">Tanggal Akhir Efektif</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($skalaNilai->tgl_akhir_efektif)->format('d-m-Y') }}" readonly>
                </div>
            </div>

            <!-- Tabel untuk Detail Skala Nilai -->
            <table class="table table-bordered mb-3">
                <thead>
                    <tr>
                        <th style="width: 160px;">Bobot Minimum</th>
                        <th style="width: 160px;">Bobot Maksimum</th>
                        <th>Nilai Huruf</th>
                        <th>Nilai Indeks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skalaNilai->details as $detail)
                        <tr>
                            <td>{{ $detail->bobot_minimum }}</td>
                            <td>{{ $detail->bobot_maksimum }}</td>
                            <td>{{ $detail->nilai_huruf }}</td>
                            <td>{{ $detail->nilai_indeks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('skala-nilai.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
