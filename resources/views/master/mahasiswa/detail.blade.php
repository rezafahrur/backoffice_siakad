@extends('layouts.custom')

@section('title', 'Detail KTP')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('ktp.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Detail KTP</h4>
    </div>
    <div class="card-body">
        <dl class="row">
            {{-- NIK --}}
            <dt class="col-sm-3">NIK</dt>
            <dd class="col-sm-9">{{ $ktp->nik }}</dd>

            {{-- Nama Lengkap --}}
            <dt class="col-sm-3">Nama Lengkap</dt>
            <dd class="col-sm-9">{{ $ktp->nama_lengkap }}</dd>

            {{-- Alamat Jalan --}}
            <dt class="col-sm-3">Alamat Jalan</dt>
            <dd class="col-sm-9">{{ $ktp->alamat_jalan }}</dd>

            {{-- RT/RW --}}
            <dt class="col-sm-3">RT/RW</dt>
            <dd class="col-sm-9">{{ $ktp->alamat_rt }}/{{ $ktp->alamat_rw }}</dd>

            {{-- Provinsi --}}
            <dt class="col-sm-3">Provinsi</dt>
            <dd class="col-sm-9">{{ $province ? $province->name : 'Tidak Diketahui' }}</dd>

            {{-- Kota/Kabupaten --}}
            <dt class="col-sm-3">Kota/Kabupaten</dt>
            <dd class="col-sm-9">{{ $city ? $city->name : 'Tidak Diketahui' }}</dd>

            {{-- Kecamatan --}}
            <dt class="col-sm-3">Kecamatan</dt>
            <dd class="col-sm-9">{{ $district ? $district->name : 'Tidak Diketahui' }}</dd>

            {{-- Kelurahan/Desa --}}
            <dt class="col-sm-3">Kelurahan/Desa</dt>
            <dd class="col-sm-9">{{ $village ? $village->name : 'Tidak Diketahui' }}</dd>

            {{-- Tempat Lahir --}}
            <dt class="col-sm-3">Tempat Lahir</dt>
            <dd class="col-sm-9">{{ $ktp->lahir_tempat }}</dd>

            {{-- Tanggal Lahir --}}
            <dt class="col-sm-3">Tanggal Lahir</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($ktp->lahir_tgl)->format('d-m-Y') }}</dd>

            {{-- Jenis Kelamin --}}
            <dt class="col-sm-3">Jenis Kelamin</dt>
            <dd class="col-sm-9">
                {{ $ktp->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
            </dd>

            {{-- Agama --}}
            <dt class="col-sm-3">Agama</dt>
            <dd class="col-sm-9">{{ $ktp->agama }}</dd>

            {{-- Golongan Darah --}}
            <dt class="col-sm-3">Golongan Darah</dt>
            <dd class="col-sm-9">{{ $ktp->golongan_darah }}</dd>

            {{-- Kewarganegaraan --}}
            <dt class="col-sm-3">Kewarganegaraan</dt>
            <dd class="col-sm-9">{{ $ktp->kewarganegaraan }}</dd>
        </dl>
    </div>
@endsection
