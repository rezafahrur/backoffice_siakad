@extends('layouts.app')

@section('title', 'Detail Periode Perkuliahan')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('periode-perkuliahan.index') }}">Periode Perkuliahan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Periode Perkuliahan</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Detail Periode Perkuliahan</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Semester:</strong>
                </div>
                <div class="col-md-8">
                    <span class="badge bg-secondary">{{ $periodePerkuliahan->semester->nama_semester ?? 'Tidak Diketahui' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Program Studi:</strong>
                </div>
                <div class="col-md-8">
                    <span class="badge bg-info">{{ $periodePerkuliahan->programStudi->nama_program_studi ?? 'Tidak Diketahui' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Tanggal Awal Perkuliahan:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->tanggal_awal_kuliah->format('d-m-Y') }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Tanggal Akhir Perkuliahan:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->tanggal_akhir_kuliah->format('d-m-Y') }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jumlah Target Mahasiswa Baru:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->jml_target_mhs_baru }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jumlah Pendaftar Ikut Seleksi:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->jml_pendaftar_ikut_seleksi }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jumlah Pendaftar Lulus Seleksi:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->jml_pendaftar_lulus_seleksi }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jumlah Daftar Ulang:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->jml_daftar_ulang }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jumlah Mengundurkan Diri:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->jml_mengundurkan_diri }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jumlah Minggu Pertemuan:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $periodePerkuliahan->jml_minggu_pertemuan }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('periode-perkuliahan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
