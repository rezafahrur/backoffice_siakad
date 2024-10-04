@extends('layouts.app')

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
                        <span>{{ $bimbingUji->kategori_kegiatan }}</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('bimbingUji.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

@endsection
