@extends('layouts.app')
@section('title', 'Detail Aktivitas Mahasiswa Peserta')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('aktivitas-peserta.index') }}">Aktivitas Mahasiswa Peserta</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Aktivitas Mahasiswa Peserta</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Detail Aktivitas Mahasiswa Peserta</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Program Studi:</strong>
                </div>
                <div class="col-md-8">
                    <span class="badge bg-secondary">{{ $peserta->programStudi->nama_program_studi ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Kode Aktivitas:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->aktivitasMahasiswa->kode_aktivitas }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nama Mahasiswa:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->mahasiswa->nama }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Kode Matakuliah:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->matakuliah->kode_matakuliah }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nama Matakuliah:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->matakuliah->nama_matakuliah }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>SKS:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->sks }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jenis Peran:</strong>
                </div>
                <div class="col-md-8">
                    <span>
                        @if($peserta->jenis_peran == '1')
                            Ketua
                        @elseif($peserta->jenis_peran == '2')
                            Anggota
                        @elseif($peserta->jenis_peran == '3')
                            Personal
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nilai Huruf:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->nilai_huruf }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nilai Indeks:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->nilai_indeks }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nilai Angka:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $peserta->nilai_angka }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('aktivitas-peserta.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection