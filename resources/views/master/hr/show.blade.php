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
                    {{-- Left Column --}}
                    <div class="col-md-4">
                        {{-- kartu pengenal --}}
                        <div class="card bg-light shadow border-0" style="width: 100%;">
                            <div class="card-header bg-primary text-white text-center py-3">
                                <!-- Header content if needed -->
                            </div>
                            <div class="card-body text-center">
                                <p class="card-title mb-0">Politeknik Batu</p>
                                <img src="{{ asset('storage/' . $hr->photo_profile) }}" alt="Photo Profile" class="rounded-circle mt-3" width="120px">
                                <h6 class="card-subtitle mt-3">{{ $hr->gelar_depan }} {{ ucwords(strtolower($hr->ktp->nama)) }} {{ $hr->gelar_belakang }}</h6>
                                <p class="text-muted mb-2">{{ $hr->position->posisi }}</p>
                            </div>
                            <div class="card-footer bg-primary text-white text-center py-2">
                                <small>{{ $hr->ktp->nik }}</small>
                            </div>
                        </div>
                    {{-- Photo Profile --}}
                    <div class="col-md-4 d-flex justify-content-center">
                        <img src="{{ asset('storage/' . $hr->photo_profile) }}" alt="Photo Profile"
                            class="img-thumbnail mt-2" width="250px" style="height: auto;">

                    </div>

                    {{-- Right Column --}}
                    <div class="col-md-8">
                        <div class="row">
                            {{-- Right Column --}}
                            <div class="col-md-12">
                                <dl class="row">
                                    {{-- NIK --}}
                                    <dt class="col-sm-4"><strong>NIK</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->nik }}</dd>

                                    {{-- nip --}}
                                    <dt class="col-sm-4"><strong>NIP</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->nip }}</dd>

                                    {{-- Posisi --}}
                                    <dt class="col-sm-4"><strong>Posisi</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->position->posisi }}</dd>   
                                    <dt class="col-sm-6"><strong>Posisi</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->position->posisi }}</dd>

                                    {{-- hp --}}
                                    <dt class="col-sm-4"><strong>No. HP</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->hrDetail->hp }}</dd>

                                    {{-- Nama Lengkap --}}
                                    <dt class="col-sm-4"><strong>Nama Lengkap</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->gelar_depan }}  {{ ucwords(strtolower($hr->ktp->nama)) }} {{ $hr->gelar_belakang }} </dd>
                                    <dt class="col-sm-6"><strong>Nama Lengkap</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->gelar_depan }} {{ ucwords(strtolower($hr->ktp->nama)) }}
                                        {{ $hr->gelar_belakang }} </dd>

                                    {{-- Alamat Jalan --}}
                                    <dt class="col-sm-4"><strong>Alamat Jalan</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->alamat_jalan }}</dd>

                                    {{-- alamat_rt --}}
                                    <dt class="col-sm-4"><strong>RT</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->alamat_rt }}</dd>

                                    {{-- alamat_rw --}}
                                    <dt class="col-sm-4"><strong>RW</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->alamat_rw }}</dd>
                                    <dt class="col-sm-6"><strong>RW</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_rw }}</dd>




                                </dl>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Left Column --}}
                            <div class="col-md-12">
                                <dl class="row">
                                    {{-- Provinsi --}}
                                    <dt class="col-sm-4"><strong>Provinsi</strong></dt>
                                    <dd class="col-sm-8">{{ $province->name }}</dd>
                                    
                                    <dt class="col-sm-6"><strong>Provinsi</strong></dt>
                                    <dd class="col-sm-6">{{ $province->name }}</dd>

                                    {{-- Kota/Kabupaten --}}
                                    <dt class="col-sm-4"><strong>Kota/Kabupaten</strong></dt>
                                    <dd class="col-sm-8">{{ $city->name }}</dd>

                                    {{-- Kecamatan --}}
                                    <dt class="col-sm-4"><strong>Kecamatan</strong></dt>
                                    <dd class="col-sm-8">{{ $district->name }}</dd>
                                    
                                    <dt class="col-sm-6"><strong>Kecamatan</strong></dt>
                                    <dd class="col-sm-6">{{ $district->name }}</dd>

                                    {{-- Tempat Lahir --}}
                                    <dt class="col-sm-4"><strong>Tempat Lahir</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->lahir_tempat }}</dd>

                                    {{-- Jenis Kelamin --}}
                                    <dt class="col-sm-4"><strong>Jenis Kelamin</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->jenis_kelamin }}</dd>

                                    {{-- Agama --}}
                                    <dt class="col-sm-4"><strong>Agama</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->agama }}</dd>

                                    {{-- Golongan Darah --}}
                                    <dt class="col-sm-4"><strong>Golongan Darah</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->golongan_darah }}</dd>

                                    {{-- Kewarganegaraan --}}
                                    <dt class="col-sm-4"><strong>Kewarganegaraan</strong></dt>
                                    <dd class="col-sm-8">{{ $hr->ktp->kewarganegaraan }}</dd>
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
