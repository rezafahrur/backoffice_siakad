@extends('layouts.app')
@section('title', 'Detail Aktivitas Peserta')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('aktivitas-peserta.index') }}">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Aktivitas Mahasiswa Peserta</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Detail Aktivitas Mahasiswa Peserta</h6>
                    <div class="mb-4">
                        <strong>Kode Aktivitas:</strong> {{ $peserta->aktivitasMahasiswa->kode_aktivitas }}<br>
                        <strong>Nama Mahasiswa:</strong> {{ $peserta->mahasiswa->nama }}<br>
                        <strong>Nama Prodi:</strong> {{ $peserta->programStudi->nama_program_studi }}<br>
                        <strong>Kode Matakuliah:</strong> {{ $peserta->matakuliah->kode_matakuliah }}<br>
                        <strong>Nama Matakuliah:</strong> {{ $peserta->matakuliah->nama_matakuliah }}<br>
                        <strong>SKS:</strong> {{ $peserta->sks }}<br>
                        <strong>Jenis Peran:</strong> {{ $peserta->jenis_peran }}<br>
                        <strong>Nilai Huruf:</strong> {{ $peserta->nilai_huruf }}<br>
                        <strong>Nilai Indeks:</strong> {{ $peserta->nilai_indeks }}<br>
                        <strong>Nilai Angka:</strong> {{ $peserta->nilai_angka }}<br>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('aktivitas-peserta.index') }}" class="btn btn-secondary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i>
                            Kembali
                        </a>
                        <a href="{{ route('aktivitas-peserta.edit', $peserta->id) }}" class="btn btn-primary btn-icon-text ml-2">
                            <i class="btn-icon-prepend" data-feather="edit"></i>
                            Edit
                        </a>
                        <form action="{{ route('aktivitas-peserta.destroy', $peserta->id) }}" method="post" class="d-inline ml-2">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-icon-text" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection