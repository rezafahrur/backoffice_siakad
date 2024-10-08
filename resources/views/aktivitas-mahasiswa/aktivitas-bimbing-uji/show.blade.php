@extends('layouts.app')

@php
    $kategoriKegiatanList = [
        '110100' => '110100 - Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing, menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan',
        '110200' => '110200 - Membimbing seminar mahasiswa',
        '110300' => '110300 - Membimbing kuliah kerja nyata, praktik kerja nyata, atau praktik kerja lapangan',
        '110400' => '110400 - Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi, dan laporan akhir studi yang sesuai dengan bidang penugasannya',
        '110500' => '110500 - Bertugas sebagai penguji pada ujian akhir',
        '110600' => '110600 - Membina kegiatan mahasiswa di bidang akademik dan kemahasiswaan',
        '110700' => '110700 - Mengembangkan program kuliah yang mempunyai nilai kebaharuan metode atau substansi',
        '110800' => '110800 - Mengembangkan bahan pengajaran/bahan kuliah yang mempunyai nilai kebaharuan',
        '110900' => '110900 - Menyampaikan orasi ilmiah di tingkat perguruan tinggi',
        '111000' => '111000 - Menduduki jabatan pimpinan perguruan tinggi',
        '111100' => '111100 - Membimbing dosen yang mempunyai jabatan akademik lebih rendah',
        '111200' => '111200 - Melaksanakan kegiatan detasering dan pencangkokan di luar institusi tempat bekerja',
        '111300' => '111300 - Melakukan kegiatan pengembangan diri untuk meningkatkan kompetensi'
    ];
@endphp

@section('title', 'Detail Aktivitas Mahasiswa Bimbing Uji')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('bimbingUji.index') }}">Data</a></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Detail Aktivitas Mahasiswa Bimbing Uji</li>
    </ol>
</nav>

        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Detail Aktivitas Mahasiswa Bimbing Uji</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Kode Aktivitas:</strong>
                    </div>
                    <div class="col-md-8">
                        <span>{{ $bimbingUji->aktivitasMahasiswa->kode_aktivitas }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>NIDN Dosen:</strong>
                    </div>
                    <div class="col-md-8">
                        <span>{{ $bimbingUji->nidn_dosen }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Dosen:</strong>
                    </div>
                    <div class="col-md-8">
                        <span>{{ $bimbingUji->nama_dosen }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jenis Peran:</strong>
                    </div>
                    <div class="col-md-8">
                        <span>
                            @if($bimbingUji->jenis_peran == '1')
                                Pembimbing
                            @elseif($bimbingUji->jenis_peran == '2')
                                Penguji
                            @else
                                Tidak Diketahui
                            @endif
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Urutan Pembimbing:</strong>
                    </div>
                    <div class="col-md-8">
                        <span>{{ $bimbingUji->urutan_pembimbing }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Kategori Kegiatan:</strong>
                    </div>
                    <div class="col-md-8">
                        <span>{{ $kategoriKegiatanList[$bimbingUji->kategori_kegiatan] ?? 'Kategori tidak ditemukan' }}</span>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <a href="{{ route('bimbingUji.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

@endsection
