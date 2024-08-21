@extends('layouts.custom')

@section('title', 'Detail Mahasiswa')

@section('content')
    <div class="container">
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
        <div class="card">
            <div class="card-body">
                <!-- Wizard Navigation -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-mahasiswa-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-mahasiswa" type="button" role="tab" aria-controls="pills-mahasiswa"
                            aria-selected="true">Mahasiswa</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-wali-tab" data-bs-toggle="pill" data-bs-target="#pills-wali"
                            type="button" role="tab" aria-controls="pills-wali" aria-selected="false">Wali</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-kontak-darurat-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-kontak-darurat" type="button" role="tab"
                            aria-controls="pills-kontak-darurat" aria-selected="false">Kontak Darurat</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <!-- Mahasiswa Details -->
                    <div class="tab-pane fade show active" id="pills-mahasiswa" role="tabpanel"
                        aria-labelledby="pills-mahasiswa-tab">
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

                                    {{-- NISN --}}
                                    <dt class="col-sm-4">NISN</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->nisn }}</dd>

                                    {{-- Registrasi Tanggal --}}
                                    <dt class="col-sm-4">Registrasi Tanggal</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($mahasiswa->registrasi_tgl)->format('d-m-Y') }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">

                                <dl class="row">
                                    {{-- Jurusan --}}
                                    <dt class="col-sm-4">Jurusan</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->jurusan->nama_jurusan }}</dd>

                                    {{-- Program Studi --}}
                                    <dt class="col-sm-4">Program Studi</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->programStudi->nama_program_studi }}</dd>

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
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($mahasiswa->ktp->lahir_tgl)->format('d-m-Y') }}</dd>

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
                    </div>

                    <!-- Wali Details -->
                    <div class="tab-pane fade" id="pills-wali" role="tabpanel" aria-labelledby="pills-wali-tab">
                        <!-- Kolom Data Wali 1 Mahasiswa (2 baris) -->
                        <div class="row">
                            <h4 class="card-title">Wali Mahasiswa</h4>
                            <div class="col-md-6">

                                <dl class="row">

                                    {{-- Nama --}}
                                    <dt class="col-sm-4">Nama</dt>
                                    <dd class="col-sm-8">{{ $wali1->nama }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">

                                <dl class="row">
                                    {{-- Status Kewalian --}}
                                    <dt class="col-sm-4">Status kewalian</dt>
                                    <dd class="col-sm-8">{{ $wali1->status_kewalian }}</dd>
                                </dl>
                            </div>
                        </div>

                        <hr>

                        <!-- Kolom Data KTP Wali 1 Mahasiswa (2 baris) -->
                        <div class="row mt-4">
                            <h4 class="card-title">KTP Wali Mahasiswa</h4>

                            <div class="col-md-6">
                                <dl class="row">
                                    {{-- NIK --}}
                                    <dt class="col-sm-4">NIK</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->nik }}</dd>

                                    {{-- Alamat --}}
                                    <dt class="col-sm-4">Alamat</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->alamat_jalan }}</dd>

                                    {{-- Provinsi --}}
                                    <dt class="col-sm-4">Provinsi</dt>
                                    <dd class="col-sm-8">{{ $wali1province ? $wali1province->name : 'Tidak Diketahui' }}
                                    </dd>

                                    {{-- Kota/Kabupaten --}}
                                    <dt class="col-sm-4">Kota/Kabupaten</dt>
                                    <dd class="col-sm-8">{{ $wali1city ? $wali1city->name : 'Tidak Diketahui' }}</dd>

                                    {{-- Kecamatan --}}
                                    <dt class="col-sm-4">Kecamatan</dt>
                                    <dd class="col-sm-8">{{ $wali1district ? $wali1district->name : 'Tidak Diketahui' }}
                                    </dd>

                                    {{-- Kelurahan/Desa --}}
                                    <dt class="col-sm-4">Kelurahan/Desa</dt>
                                    <dd class="col-sm-8">{{ $wali1village ? $wali1village->name : 'Tidak Diketahui' }}
                                    </dd>
                                </dl>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    {{-- Tempat Lahir --}}
                                    <dt class="col-sm-4">Tempat Lahir</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->lahir_tempat }}</dd>

                                    {{-- Tanggal Lahir --}}
                                    <dt class="col-sm-4">Tanggal Lahir</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($wali1->ktp->lahir_tgl)->format('d-m-Y') }}</dd>

                                    {{-- Jenis Kelamin --}}
                                    <dt class="col-sm-4">Jenis Kelamin</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->jenis_kelamin }}</dd>

                                    {{-- Agama --}}
                                    <dt class="col-sm-4">Agama</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->agama }}</dd>

                                    {{-- Golongan Darah --}}
                                    <dt class="col-sm-4">Golongan Darah</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->golongan_darah }}</dd>

                                    {{-- Kewarganegaraan --}}
                                    <dt class="col-sm-4">Kewarganegaraan</dt>
                                    <dd class="col-sm-8">{{ $wali1->ktp->kewarganegaraan }}</dd>
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
                                    <dd class="col-sm-8">{{ $wali2->nama }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">

                                <dl class="row">
                                    {{-- Status Kewalian --}}
                                    <dt class="col-sm-4">Status kewalian</dt>
                                    <dd class="col-sm-8">{{ $wali2->status_kewalian }}</dd>
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
                                    <dd class="col-sm-8">{{ $wali2->ktp->nik }}</dd>

                                    {{-- Alamat --}}
                                    <dt class="col-sm-4">Alamat</dt>
                                    <dd class="col-sm-8">{{ $wali2->ktp->alamat_jalan }}</dd>

                                    {{-- Provinsi --}}
                                    <dt class="col-sm-4">Provinsi</dt>
                                    <dd class="col-sm-8">{{ $wali2province ? $wali2province->name : 'Tidak Diketahui' }}
                                    </dd>

                                    {{-- Kota/Kabupaten --}}
                                    <dt class="col-sm-4">Kota/Kabupaten</dt>
                                    <dd class="col-sm-8">{{ $wali2city ? $wali2city->name : 'Tidak Diketahui' }}</dd>

                                    {{-- Kecamatan --}}
                                    <dt class="col-sm-4">Kecamatan</dt>
                                    <dd class="col-sm-8">{{ $wali2district ? $wali2district->name : 'Tidak Diketahui' }}
                                    </dd>

                                    {{-- Kelurahan/Desa --}}
                                    <dt class="col-sm-4">Kelurahan/Desa</dt>
                                    <dd class="col-sm-8">{{ $wali2village ? $wali2village->name : 'Tidak Diketahui' }}
                                    </dd>
                                </dl>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    {{-- Tempat Lahir --}}
                                    <dt class="col-sm-4">Tempat Lahir</dt>
                                    <dd class="col-sm-8">{{ $wali2->ktp->lahir_tempat }}</dd>

                                    {{-- Tanggal Lahir --}}
                                    <dt class="col-sm-4">Tanggal Lahir</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($wali2->ktp->lahir_tgl)->format('d-m-Y') }}</dd>

                                    {{-- Jenis Kelamin --}}
                                    <dt class="col-sm-4">Jenis Kelamin</dt>
                                    <dd class="col-sm-8">{{ $wali2->ktp->jenis_kelamin }}</dd>

                                    {{-- Agama --}}
                                    <dt class="col-sm-4">Agama</dt>
                                    <dd class="col-sm-8">{{ $wali2->ktp->agama }}</dd>

                                    {{-- Golongan Darah --}}
                                    <dt class="col-sm-4">Golongan Darah</dt>
                                    <dd class="col-sm-8">{{ $wali2->ktp->golongan_darah }}</dd>

                                    {{-- Kewarganegaraan --}}
                                    <dt class="col-sm-4">Kewarganegaraan</dt>
                                    <dd class="col-sm-8">{{ $wali2->ktp->kewarganegaraan }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Darurat -->
                    <div class="tab-pane fade" id="pills-kontak-darurat" role="tabpanel"
                        aria-labelledby="pills-kontak-darurat-tab">
                        <!-- Kolom Kontak Darurat -->
                        <div class="row">
                            <h4 class="card-title">Kontak Darurat</h4>
                            <div class="col-md-6">
                                <dl class="row">
                                    {{-- Nama --}}
                                    <dt class="col-sm-4">Nama</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->nama_kontak_darurat }}</dd>

                                    {{-- Hubungan --}}
                                    <dt class="col-sm-4">Hubungan</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->hubungan_kontak_darurat }}</dd>

                                    {{-- Nomor Telepon --}}
                                    <dt class="col-sm-4">Nomor Telepon</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->hp_kontak_darurat }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
