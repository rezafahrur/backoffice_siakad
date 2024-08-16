@extends('layouts.custom')

@section('title', 'Detail HR')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('hr.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 text-center">Detail Biodata SDM</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Photo Profile --}}
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="{{ asset('storage/' . $hr->photo_profile) }}" alt="Photo Profile"
                            class="img-thumbnail mt-2" width="250px" style="height: auto;">

                    </div>

                    {{-- Biodata --}}
                    <div class="col-md-8">
                        <div class="row">
                            {{-- Right Column --}}
                            <div class="col-md-6">
                                <dl class="row">
                                    {{-- NIK --}}
                                    <dt class="col-sm-6"><strong>NIK</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->nik }}</dd>

                                    {{-- nip --}}
                                    <dt class="col-sm-6"><strong>NIP</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->nip }}</dd>

                                    {{-- Posisi --}}
                                    <dt class="col-sm-6"><strong>Posisi</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->position->posisi }}</dd>

                                    {{-- hp --}}
                                    <dt class="col-sm-6"><strong>No. HP</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->hrDetail->hp }}</dd>

                                    {{-- Email --}}

                                    {{-- Nama Lengkap --}}
                                    <dt class="col-sm-6"><strong>Nama Lengkap</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->gelar_depan }} {{ ucwords(strtolower($hr->ktp->nama)) }}
                                        {{ $hr->gelar_belakang }} </dd>

                                    {{-- Alamat Jalan --}}
                                    <dt class="col-sm-6"><strong>Alamat Jalan</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_jalan }}</dd>

                                    {{-- alamat_rt --}}
                                    <dt class="col-sm-6"><strong>RT</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_rt }}</dd>

                                    {{-- alamat_rw --}}
                                    <dt class="col-sm-6"><strong>RW</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_rw }}</dd>




                                </dl>
                            </div>

                            {{-- Left Column --}}
                            <div class="col-md-6">
                                <dl class="row">

                                    {{-- Provinsi --}}
                                    <dt class="col-sm-6"><strong>Provinsi</strong></dt>
                                    <dd class="col-sm-6">{{ $province->name }}</dd>

                                    {{-- Kota/Kabupaten --}}
                                    <dt class="col-sm-6"><strong>Kota/Kabupaten</strong></dt>
                                    <dd class="col-sm-6">{{ $city->name }}</dd>

                                    {{-- Kecamatan --}}
                                    <dt class="col-sm-6"><strong>Kecamatan</strong></dt>
                                    <dd class="col-sm-6">{{ $district->name }}</dd>

                                    {{-- Tempat Lahir --}}
                                    <dt class="col-sm-6"><strong>Tempat Lahir</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->lahir_tempat }}</dd>

                                    {{-- Jenis Kelamin --}}
                                    <dt class="col-sm-6"><strong>Jenis Kelamin</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->jenis_kelamin }}</dd>

                                    {{-- Agama --}}
                                    <dt class="col-sm-6"><strong>Agama</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->agama }}</dd>

                                    {{-- Golongan Darah --}}
                                    <dt class="col-sm-6"><strong>Golongan Darah</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->golongan_darah }}</dd>

                                    {{-- Kewarganegaraan --}}
                                    <dt class="col-sm-6"><strong>Kewarganegaraan</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->kewarganegaraan }}</dd>


                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
