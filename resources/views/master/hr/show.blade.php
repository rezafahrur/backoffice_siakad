@extends('layouts.custom')

@section('title', 'Detail HR')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('hr.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img src="{{ asset('assets/img/logo-kos.svg') }}" alt="Logo">
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
                        <img src="{{ asset('storage/' . $hr->photo_profile) }}" alt="Photo Profile" class="img-thumbnail mt-2" width="250px">
                    </div>

                    {{-- Biodata --}}
                    <div class="col-md-8">
                        <div class="row">
                            {{-- Right Column --}}
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-6"><strong>NIK</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->nik }}</dd>
                                    <dt class="col-sm-6"><strong>NIP</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->nip }}</dd>
                                    <dt class="col-sm-6"><strong>Posisi</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->position->posisi }}</dd>
                                    <dt class="col-sm-6"><strong>No. HP</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->hrDetail->hp }}</dd>
                                    <dt class="col-sm-6"><strong>Nama Lengkap</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->gelar_depan }}  {{ ucwords(strtolower($hr->ktp->nama)) }} {{ $hr->gelar_belakang }}</dd>
                                    <dt class="col-sm-6"><strong>Alamat Jalan</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_jalan }}</dd>
                                    <dt class="col-sm-6"><strong>RT</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_rt }}</dd>
                                    <dt class="col-sm-6"><strong>RW</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->alamat_rw }}</dd>
                                </dl>
                            </div>

                            {{-- Left Column --}}
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-6"><strong>Provinsi</strong></dt>
                                    <dd class="col-sm-6">{{ $province->name }}</dd>
                                    <dt class="col-sm-6"><strong>Kota/Kabupaten</strong></dt>
                                    <dd class="col-sm-6">{{ $city->name }}</dd>
                                    <dt class="col-sm-6"><strong>Kecamatan</strong></dt>
                                    <dd class="col-sm-6">{{ $district->name }}</dd>
                                    <dt class="col-sm-6"><strong>Tempat Lahir</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->lahir_tempat }}</dd>
                                    <dt class="col-sm-6"><strong>Jenis Kelamin</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->jenis_kelamin }}</dd>
                                    <dt class="col-sm-6"><strong>Agama</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->agama }}</dd>
                                    <dt class="col-sm-6"><strong>Golongan Darah</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->golongan_darah }}</dd>
                                    <dt class="col-sm-6"><strong>Kewarganegaraan</strong></dt>
                                    <dd class="col-sm-6">{{ $hr->ktp->kewarganegaraan }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Pengenal Dosen Politeknik Batu --}}
            <div class="card-footer text-center">
                <div class="card bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-header">Politeknik Batu</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $hr->gelar_depan }} {{ ucwords(strtolower($hr->ktp->nama)) }} {{ $hr->gelar_belakang }}</h5>
                        <p class="card-text">{{ $hr->position->posisi }}</p>
                        <img src="{{ asset('storage/' . $hr->photo_profile) }}" alt="Photo Profile" class="img-thumbnail mt-2" width="100px">
                        <p class="card-text mt-3"><strong>NIP:</strong> {{ $hr->nip }}</p>
                        <p class="card-text"><strong>NIK:</strong> {{ $hr->ktp->nik }}</p>
                        <p class="card-text"><strong>No. HP:</strong> {{ $hr->hrDetail->hp }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
