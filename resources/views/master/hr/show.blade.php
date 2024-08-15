@extends('layouts.custom')

@section('title', 'Detail HR')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('hr.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Detail HR</h4>
    </div>
    <div class="card-body">
        <dl class="row">
            {{-- NIK --}}
            <dt class="col-sm-3">NIK</dt>
            <dd class="col-sm-9">{{ $hr->ktp->nik }}</dd>

            {{-- Nama Lengkap --}}
            <dt class="col-sm-3">Nama Lengkap</dt>
            <dd class="col-sm-9">{{ $hr->ktp->nama }}</dd>

            {{-- Alamat Jalan --}}
            <dt class="col-sm-3">Alamat Jalan</dt>
            <dd class="col-sm-9">{{ $hr->ktp->alamat_jalan }}</dd>

            {{-- alamat_rt --}}
            <dt class="col-sm-3">RT</dt>
            <dd class="col-sm-9">{{ $hr->ktp->alamat_rt }}</dd>

            {{-- alamat_rw --}}
            <dt class="col-sm-3">RW</dt>
            <dd class="col-sm-9">{{ $hr->ktp->alamat_rw }}</dd>

            {{-- Provinsi --}}
            <dt class="col-sm-3">Provinsi</dt>
            <dd class="col-sm-9">{{ $province->name }}</dd>
            
            {{-- Kota/Kabupaten --}}
            <dt class="col-sm-3">Kota/Kabupaten</dt>
            <dd class="col-sm-9">{{ $city->name }}</dd>

            {{-- Kecamatan --}}
            <dt class="col-sm-3">Kecamatan</dt>
            <dd class="col-sm-9">{{ $district->name }}</dd>

            {{-- Kelurahan/Desa --}}
            <dt class="col-sm-3">Kelurahan/Desa</dt>
            <dd class="col-sm-9">{{ $village->name }}</dd>

            {{-- Tempat Lahir --}}
            <dt class="col-sm-3">Tempat Lahir</dt>
            <dd class="col-sm-9">{{ $hr->ktp->lahir_tempat }}</dd>

            

            {{-- Jenis Kelamin --}}
            <dt class="col-sm-3">Jenis Kelamin</dt>
            <dd class="col-sm-9">{{ $hr->ktp->jenis_kelamin }}</dd>

            {{-- Agama --}}     
            <dt class="col-sm-3">Agama</dt>
            <dd class="col-sm-9">{{ $hr->ktp->agama }}</dd>

            {{-- Golongan Darah --}}
            <dt class="col-sm-3">Golongan Darah</dt>
            <dd class="col-sm-9">{{ $hr->ktp->golongan_darah }}</dd>

            {{-- Kewarganegaraan --}}
            <dt class="col-sm-3">Kewarganegaraan</dt>
            <dd class="col-sm-9">{{ $hr->ktp->kewarganegaraan }}</dd>

            {{-- nip --}}
            <dt class="col-sm-3">NIP</dt>
            <dd class="col-sm-9">{{ $hr->nip }}</dd>

            {{-- gelar depan --}}
            <dt class="col-sm-3">Gelar Depan</dt>
            <dd class="col-sm-9">{{ $hr->gelar_depan }}</dd>

            {{-- gelar belakang --}}
            <dt class="col-sm-3">Gelar Belakang</dt>
            <dd class="col-sm-9">{{ $hr->gelar_belakang }}</dd>

            {{-- jabatan --}}
        



        </dl>
    </div>
@endsection
