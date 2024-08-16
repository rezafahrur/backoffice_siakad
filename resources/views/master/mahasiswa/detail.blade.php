@extends('layouts.custom')

@section('title', 'Detail KTP')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('mahasiswa.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="card-body">
        <!-- Kolom Data Mahasiswa (2 baris) -->
        <div class="row">
            <h4 class="card-title">Mahasiswa</h4>
            <div class="col-md-6">

                <dl class="row">
                    {{-- NIM --}}
                    <dt class="col-sm-4">NIM</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->nim }}</dd>

                    {{-- Nama --}}
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->nama }}</dd>

                    {{-- Program Studi --}}
                    <dt class="col-sm-4">Program Studi</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->programStudi->nama_program_studi }}</dd>
                </dl>
            </div>
            <div class="col-md-6">

                <dl class="row">
                    {{-- Registrasi Tanggal --}}
                    <dt class="col-sm-4">Registrasi Tanggal</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($mahasiswa->registrasi_tgl)->format('d-m-Y') }}</dd>

                    {{-- Semester Berjalan --}}
                    <dt class="col-sm-4">Semester Berjalan</dt>
                    <dd class="col-sm-8">Semester {{ $mahasiswa->semester_berjalan }}</dd>

                    {{-- Status --}}
                    <dt class="col-sm-4">Status Mahasiswa</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->status }}</dd>
                </dl>
            </div>
        </div>

        <hr>

        <!-- Kolom Data KTP Mahasiswa (2 baris) -->
        <div class="row mt-4">
            <h4 class="card-title">KTP Mahasiswa</h4>

            <div class="col-md-6">
                <dl class="row">
                    {{-- NIK --}}
                    <dt class="col-sm-4">NIK</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->nik }}</dd>

                    {{-- Alamat --}}
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->alamat_jalan }}</dd>

                    {{-- Provinsi --}}
                    <dt class="col-sm-4">Provinsi</dt>
                    <dd class="col-sm-8">{{ $province ? $province->name : 'Tidak Diketahui' }}</dd>

                    {{-- Kota/Kabupaten --}}
                    <dt class="col-sm-4">Kota/Kabupaten</dt>
                    <dd class="col-sm-8">{{ $city ? $city->name : 'Tidak Diketahui' }}</dd>

                    {{-- Kecamatan --}}
                    <dt class="col-sm-4">Kecamatan</dt>
                    <dd class="col-sm-8">{{ $district ? $district->name : 'Tidak Diketahui' }}</dd>

                    {{-- Kelurahan/Desa --}}
                    <dt class="col-sm-4">Kelurahan/Desa</dt>
                    <dd class="col-sm-8">{{ $village ? $village->name : 'Tidak Diketahui' }}</dd>
                </dl>
            </div>

            <div class="col-md-6">
                <div class="row">
                    {{-- Tempat Lahir --}}
                    <dt class="col-sm-4">Tempat Lahir</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->lahir_tempat }}</dd>

                    {{-- Tanggal Lahir --}}
                    <dt class="col-sm-4">Tanggal Lahir</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($mahasiswa->ktp->lahir_tgl)->format('d-m-Y') }}</dd>

                    {{-- Jenis Kelamin --}}
                    <dt class="col-sm-4">Jenis Kelamin</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->jenis_kelamin }}</dd>

                    {{-- Agama --}}
                    <dt class="col-sm-4">Agama</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->agama }}</dd>

                    {{-- Golongan Darah --}}
                    <dt class="col-sm-4">Golongan Darah</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->golongan_darah }}</dd>

                    {{-- Kewarganegaraan --}}
                    <dt class="col-sm-4">Kewarganegaraan</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->ktp->kewarganegaraan }}</dd>
                </div>
            </div>
        </div>

        <hr>

        <!-- Kolom Data Wali Mahasiswa (2 baris) -->
        <div class="row">
            <h4 class="card-title">Wali Mahasiswa</h4>
            <div class="col-md-6">

                <dl class="row">

                    {{-- Nama --}}
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->mahasiswaWali->nama }}</dd>
                </dl>
            </div>
            <div class="col-md-6">

                <dl class="row">
                    {{-- Status Kewalian --}}
                    <dt class="col-sm-4">Status kewalian</dt>
                    <dd class="col-sm-8">{{ $mahasiswa->mahasiswaWali->status_kewalian }}</dd>
                </dl>
            </div>
        </div>

        <hr>

        <!-- Kolom Data KTP Wali Mahasiswa (2 baris) -->
        <div class="row mt-4">
            <h4 class="card-title">KTP Wali Mahasiswa</h4>

            <div class="col-md-6">
                <dl class="row">
                    {{-- NIK --}}
                    <dt class="col-sm-4">NIK</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->nik }}</dd>

                    {{-- Alamat --}}
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->alamat_jalan }}</dd>

                    {{-- Provinsi --}}
                    <dt class="col-sm-4">Provinsi</dt>
                    <dd class="col-sm-8">{{ $waliprovince ? $waliprovince->name : 'Tidak Diketahui' }}</dd>

                    {{-- Kota/Kabupaten --}}
                    <dt class="col-sm-4">Kota/Kabupaten</dt>
                    <dd class="col-sm-8">{{ $walicity ? $walicity->name : 'Tidak Diketahui' }}</dd>

                    {{-- Kecamatan --}}
                    <dt class="col-sm-4">Kecamatan</dt>
                    <dd class="col-sm-8">{{ $walidistrict ? $walidistrict->name : 'Tidak Diketahui' }}</dd>

                    {{-- Kelurahan/Desa --}}
                    <dt class="col-sm-4">Kelurahan/Desa</dt>
                    <dd class="col-sm-8">{{ $walivillage ? $walivillage->name : 'Tidak Diketahui' }}</dd>
                </dl>
            </div>

            <div class="col-md-6">
                <div class="row">
                    {{-- Tempat Lahir --}}
                    <dt class="col-sm-4">Tempat Lahir</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->lahir_tempat }}</dd>

                    {{-- Tanggal Lahir --}}
                    <dt class="col-sm-4">Tanggal Lahir</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($wali->ktp->lahir_tgl)->format('d-m-Y') }}</dd>

                    {{-- Jenis Kelamin --}}
                    <dt class="col-sm-4">Jenis Kelamin</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->jenis_kelamin }}</dd>

                    {{-- Agama --}}
                    <dt class="col-sm-4">Agama</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->agama }}</dd>

                    {{-- Golongan Darah --}}
                    <dt class="col-sm-4">Golongan Darah</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->golongan_darah }}</dd>

                    {{-- Kewarganegaraan --}}
                    <dt class="col-sm-4">Kewarganegaraan</dt>
                    <dd class="col-sm-8">{{ $wali->ktp->kewarganegaraan }}</dd>
                </div>
            </div>
        </div>
    </div>
@endsection
