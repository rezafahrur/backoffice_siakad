@extends('layouts.app')

@php
    $jenisAktivitas = [
        1 => 'Laporan akhir studi',
        2 => 'Tugas akhir/Skripsi',
        3 => 'Tesis',
        4 => 'Disertasi',
        5 => 'Kuliah kerja nyata',
        6 => 'Kerja praktek/PKL',
        7 => 'Bimbingan akademis',
        10 => 'Aktivitas kemahasiswaan',
        11 => 'Program kreativitas mahasiswa',
        12 => 'Kompetisi',
        13 => 'Magang/Praktik Kerja (Kampus Merdeka)',
        14 => 'Asistensi Mengajar di Satuan Pendidikan (Kampus Merdeka)',
        15 => 'Penelitian/Riset (Kampus Merdeka)',
        16 => 'Proyek Kemanusiaan (Kampus Merdeka)',
        17 => 'Kegiatan Wirausaha (Kampus Merdeka)',
        18 => 'Studi/Proyek Independen (Kampus Merdeka)',
        19 => 'Membangun Desa/Kuliah Kerja Nyata Tematik (Kampus Merdeka)',
        20 => 'Bela Negara (Kampus Merdeka)',
        21 => 'Pertukaran Pelajar (Kampus Merdeka)',
        22 => 'Skripsi',
        23 => 'Kegiatan Penelitian Reguler (Kampus Merdeka)',
    ];
    $jenisAnggota = [
        0 => 'Personal',
        1 => 'Kelompok',
    ];
@endphp

@section('title', 'Detail Aktivitas Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('aktivitas.index') }}">Aktivitas Mahasiswa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Aktivitas Mahasiswa</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Detail Aktivitas Mahasiswa</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Program Studi:</strong>
                </div>
                <div class="col-md-8">
                    <span
                        class="badge bg-secondary">{{ $aktivitas->programStudi->nama_program_studi ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Semester:</strong>
                </div>
                <div class="col-md-8">
                    <span class="badge bg-info">{{ $aktivitas->semester->nama_semester ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Kode Aktivitas:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $aktivitas->kode_aktivitas }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jenis Aktivitas:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $jenisAktivitas[$aktivitas->jenis_aktivitas] ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Jenis Anggota:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $jenisAnggota[$aktivitas->jenis_anggota] ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Judul:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $aktivitas->judul }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Lokasi:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $aktivitas->lokasi ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Keterangan Aktivitas:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $aktivitas->keterangan_aktivitas ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nomor SK Tugas:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $aktivitas->nomor_sk_tugas ?? '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Tanggal SK Tugas:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ $aktivitas->tanggal_sk_tugas ? date('d-m-Y', strtotime($aktivitas->tanggal_sk_tugas)) : '-' }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Tanggal Mulai:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ date('d-m-Y', strtotime($aktivitas->tanggal_mulai)) }}</span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Tanggal Selesai:</strong>
                </div>
                <div class="col-md-8">
                    <span>{{ date('d-m-Y', strtotime($aktivitas->tanggal_selesai)) }}</span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('aktivitas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
