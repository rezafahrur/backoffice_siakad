@extends('layouts.custom')

@section('title', 'Edit Mahasiswa')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href=""><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
        @csrf
        @if (isset($mahasiswa))
            @method('PUT')
            <input type="hidden" name="id" value="{{ $mahasiswa->id }}">
        @endif

        <div class="container">

            {{-- Form Mahasiswa --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- NIM --}}
                        <div class="col-md-6 mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                name="nim" placeholder="NIM" value="{{ old('nim') ?? $mahasiswa->nim }}" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" placeholder="NAMA" value="{{ old('nama') ?? $mahasiswa->nama }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Program Studi --}}
                        <div class="col-md-4 mb-3">
                            <label for="program_studi" class="form-label">Program Studi</label>
                            <select class="form-select @error('program_studi') is-invalid @enderror" id="program_studi"
                                name="program_studi">
                                <option value="" disabled selected>Pilih Program Studi</option>
                                @foreach ($prodi as $ps)
                                    <option value="{{ $ps->id }}"
                                        {{ old('program_studi', $mahasiswa->program_studi_id) == $ps->id ? 'selected' : '' }}>
                                        {{ $ps->nama_program_studi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_studi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Registrasi Tanggal --}}
                        <div class="col-md-4 mb-3">
                            <label for="registrasi_tanggal" class="form-label">Registrasi Tanggal</label>
                            <input type="date" class="form-control @error('registrasi_tanggal') is-invalid @enderror"
                                id="registrasi_tanggal" name="registrasi_tanggal"
                                value="{{ old('registrasi_tanggal') ?? $mahasiswa->registrasi_tanggal }}">
                            @error('registrasi_tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Status Mahasiswa --}}
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status Mahasiswa</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Aktif"
                                    {{ old('status', $mahasiswa->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non Aktif"
                                    {{ old('status', $mahasiswa->status) == 'Non Aktif' ? 'selected' : '' }}>Non Aktif
                                </option>
                                <option value="Cuti" {{ old('status', $mahasiswa->status) == 'Cuti' ? 'selected' : '' }}>
                                    Cuti</option>
                                <option value="Lulus"
                                    {{ old('status', $mahasiswa->status) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- No Hp --}}
                        <div class="col-md-4 mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                name="no_hp" placeholder="No HP"
                                value="{{ old('no_hp') ?? $mahasiswa->mahasiswaDetail->hp }}" maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                            @error('no_hp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Domisili --}}
                        <div class="col-md-4 mb-3">
                            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                            <textarea class="form-control @error('alamat_domisili') is-invalid @enderror" id="alamat_domisili"
                                name="alamat_domisili" placeholder="Alamat Domisili" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_domisili') ?? $mahasiswa->mahasiswaDetail->alamat_domisili }}</textarea>
                            @error('alamat_domisili')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <hr>
                </div>
            </div>

            {{-- Form KTP  Mahasiswa --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form KTP Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- NIK --}}
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" placeholder="NIK" value="{{ old('nik') ?? $mahasiswa->ktp->nik }}"
                                maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="col-md-6 mb-3">
                            <label for="alamat_jalan" class="form-label">Alamat Jalan</label>
                            <textarea class="form-control @error('alamat_jalan') is-invalid @enderror" id="alamat_jalan" name="alamat_jalan"
                                placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_jalan') ?? $mahasiswa->ktp->alamat_jalan }}</textarea>
                            @error('alamat_jalan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- RT RW --}}
                        <div class="col-md-6 mb-3">
                            <label for="alamat_rt" class="form-label">RT</label>
                            <input type="text" class="form-control @error('alamat_rt') is-invalid @enderror"
                                id="alamat_rt" name="alamat_rt" placeholder="000"
                                value="{{ old('alamat_rt') ?? $mahasiswa->ktp->alamat_rt }}" maxlength="3"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                            @error('alamat_rt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_rw" class="form-label">RW</label>
                            <input type="text" class="form-control @error('alamat_rw') is-invalid @enderror"
                                id="alamat_rw" name="alamat_rw" placeholder="000"
                                value="{{ old('alamat_rw') ?? $mahasiswa->ktp->alamat_rw }}" maxlength="3"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                            @error('alamat_rw')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Provinsi --}}
                        <div class="col-md-3 mb-3">
                            <label for="alamat_prov_code" class="form-label">Provinsi</label>
                            <select class="form-select @error('alamat_prov_code') is-invalid @enderror"
                                id="alamat_prov_code" name="alamat_prov_code">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}"
                                        {{ old('alamat_prov_code', $mahasiswa->ktp->alamat_prov_code) == $province->code ? 'selected' : '' }}>
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('alamat_prov_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Kota/Kabupaten --}}
                        <div class="col-md-3 mb-3">
                            <label for="alamat_kotakab_code" class="form-label">Kota/Kabupaten</label>
                            <select class="form-select @error('alamat_kotakab_code') is-invalid @enderror"
                                id="alamat_kotakab_code" name="alamat_kotakab_code">
                                <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                {{-- Populated dynamically based on selected province --}}
                            </select>
                            @error('alamat_kotakab_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Kecamatan --}}
                        <div class="col-md-3 mb-3">
                            <label for="alamat_kec_code" class="form-label">Kecamatan</label>
                            <select class="form-select @error('alamat_kec_code') is-invalid @enderror"
                                id="alamat_kec_code" name="alamat_kec_code">
                                <option value="" disabled selected>Pilih Kecamatan</option>
                                {{-- Populated dynamically based on selected city --}}
                            </select>
                            @error('alamat_kec_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Kelurahan/Desa --}}
                        <div class="col-md-3 mb-3">
                            <label for="alamat_kel_code" class="form-label">Kelurahan/Desa</label>
                            <select class="form-select @error('alamat_kel_code') is-invalid @enderror"
                                id="alamat_kel_code" name="alamat_kel_code">
                                <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                                {{-- Populated dynamically based on selected district --}}
                            </select>
                            @error('alamat_kel_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="col-md-4 mb-3">
                            <label for="lahir_tempat" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control @error('lahir_tempat') is-invalid @enderror"
                                id="lahir_tempat" name="lahir_tempat" placeholder="Tempat Lahir"
                                value="{{ old('lahir_tempat') ?? $mahasiswa->ktp->lahir_tempat }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('lahir_tempat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="col-md-4 mb-3">
                            <label for="lahir_tgl" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('lahir_tgl') is-invalid @enderror"
                                id="lahir_tgl" name="lahir_tgl"
                                value="{{ old('lahir_tgl') ?? $mahasiswa->ktp->lahir_tgl }}">
                            @error('lahir_tgl')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-4 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin">
                                <option value="L"
                                    {{ old('jenis_kelamin', $mahasiswa->ktp->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $mahasiswa->ktp->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Agama --}}
                        <div class="col-md-4 mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" class="form-control @error('agama') is-invalid @enderror"
                                id="agama" name="agama" placeholder="Agama"
                                value="{{ old('agama') ?? $mahasiswa->ktp->agama }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('agama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Golongan Darah --}}
                        <div class="col-md-4 mb-3">
                            <label for="golongan_darah" class="form-label">Golongan Darah</label>
                            <select class="form-select @error('golongan_darah') is-invalid @enderror" id="golongan_darah"
                                name="golongan_darah">
                                <option value="" disabled selected>Pilih Golongan Darah</option>
                                <option value="A"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'A' ? 'selected' : '' }}>A
                                </option>
                                <option value="A+"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'A+' ? 'selected' : '' }}>
                                    A+</option>
                                <option value="A-"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'A-' ? 'selected' : '' }}>
                                    A-</option>
                                <option value="B"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'B' ? 'selected' : '' }}>B
                                </option>
                                <option value="B+"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'B+' ? 'selected' : '' }}>
                                    B+</option>
                                <option value="B-"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'B-' ? 'selected' : '' }}>
                                    B-</option>
                                <option value="AB"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'AB' ? 'selected' : '' }}>
                                    AB</option>
                                <option value="AB+"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'AB+' ? 'selected' : '' }}>
                                    AB+</option>
                                <option value="AB-"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'AB-' ? 'selected' : '' }}>
                                    AB-</option>
                                <option value="O"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'O' ? 'selected' : '' }}>O
                                </option>
                                <option value="O+"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'O+' ? 'selected' : '' }}>
                                    O+</option>
                                <option value="O-"
                                    {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'O-' ? 'selected' : '' }}>
                                    O-</option>
                            </select>
                            @error('golongan_darah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Kewarganegaraan --}}
                        <div class="col-md-4 mb-3">
                            <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                            <input type="text" class="form-control @error('kewarganegaraan') is-invalid @enderror"
                                id="kewarganegaraan" name="kewarganegaraan" placeholder="Kewarganegaraan"
                                value="{{ old('kewarganegaraan') ?? $mahasiswa->ktp->kewarganegaraan }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('kewarganegaraan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <hr>
                </div>
            </div>

            {{-- Form Wali Mahasiswa --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Wali Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Nama Wali --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_nama" class="form-label">Nama Wali</label>
                            <input type="text" class="form-control @error('wali_nama') is-invalid @enderror"
                                id="wali_nama" name="wali_nama" placeholder="Nama Wali"
                                value="{{ old('wali_nama') ?? $wali->nama }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('wali_nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Hubungan --}}
                        <div class="col-md-6 mb-3">
                            <label for="status_kewalian" class="form-label">Hubungan</label>
                            <select class="form-select @error('status_kewalian') is-invalid @enderror"
                                id="status_kewalian" name="status_kewalian">
                                <option value="">Pilih Hubungan</option>
                                <option value="Ayah"
                                    {{ old('status_kewalian', $wali->status_kewalian) == 'Ayah' ? 'selected' : '' }}>Ayah
                                </option>
                                <option value="Ibu"
                                    {{ old('status_kewalian', $wali->status_kewalian) == 'Ibu' ? 'selected' : '' }}>Ibu
                                </option>
                                <option value="Wali"
                                    {{ old('status_kewalian', $wali->status_kewalian) == 'Wali' ? 'selected' : '' }}>Wali
                                </option>
                            </select>
                            @error('status_kewalian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- No HP Wali --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_no_hp" class="form-label">No HP Wali</label>
                            <input type="text" class="form-control @error('wali_no_hp') is-invalid @enderror"
                                id="wali_no_hp" name="wali_no_hp" placeholder="No HP Wali"
                                value="{{ old('wali_no_hp') ?? $wali->mahasiswaWaliDetail->hp }}" maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                            @error('wali_no_hp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Domisili Wali --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_alamat_domisili" class="form-label">Alamat Domisili Wali</label>
                            <textarea class="form-control @error('wali_alamat_domisili') is-invalid @enderror" id="wali_alamat_domisili"
                                name="wali_alamat_domisili" placeholder="Alamat Wali" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_domisili', $wali->mahasiswaWaliDetail->alamat_domisili) }}</textarea>
                            @error('wali_alamat_domisili')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Pekerjaan --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_pekerjaan" class="form-label">Pekerjaan Wali</label>
                            <input type="text" class="form-control @error('wali_pekerjaan') is-invalid @enderror"
                                id="wali_pekerjaan" name="wali_pekerjaan" placeholder="Pekerjaan Wali"
                                value="{{ old('wali_pekerjaan') ?? $wali->mahasiswaWaliDetail->pekerjaan }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('wali_pekerjaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Penghasilan --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_penghasilan" class="form-label">Penghasilan Wali</label>
                            <select class="form-select @error('wali_penghasilan') is-invalid @enderror"
                                id="wali_penghasilan" name="wali_penghasilan">
                                <option value="">Pilih Penghasilan</option>
                                <option value="< Rp. 500.000"
                                    {{ old('wali_penghasilan', $wali->mahasiswaWaliDetail->penghasilan) == '< Rp. 500.000' ? 'selected' : '' }}>
                                    < Rp. 500.000</option>
                                <option value="Rp. 500.000 - Rp. 1.000.000"
                                    {{ old('wali_penghasilan', $wali->mahasiswaWaliDetail->penghasilan) == 'Rp. 500.000 - Rp. 1.000.000' ? 'selected' : '' }}>
                                    Rp. 500.000 - Rp. 1.000.000
                                </option>
                                <option value="Rp. 1.000.000 - Rp. 1.500.000"
                                    {{ old('wali_penghasilan', $wali->mahasiswaWaliDetail->penghasilan) == 'Rp. 1.000.000 - Rp. 1.500.000' ? 'selected' : '' }}>
                                    Rp. 1.000.000 - Rp. 1.500.000
                                </option>
                                <option value="Rp. 1.500.000 - Rp. 2.000.000"
                                    {{ old('wali_penghasilan', $wali->mahasiswaWaliDetail->penghasilan) == 'Rp. 1.500.000 - Rp. 2.000.000' ? 'selected' : '' }}>
                                    Rp. 1.500.000 - Rp. 2.000.000
                                </option>
                                <option value="> Rp. 2.000.000"
                                    {{ old('wali_penghasilan', $wali->mahasiswaWaliDetail->penghasilan) == '> Rp. 2.000.000' ? 'selected' : '' }}>
                                    > Rp. 2.000.000
                                </option>
                                {{-- Add more options here --}}
                            </select>
                            @error('wali_penghasilan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Pendidikan Terakhir --}}
                        <div class="col-md-4 mb-3">
                            <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                            <select class="form-select @error('pendidikan_terakhir') is-invalid @enderror"
                                id="pendidikan_terakhir" name="pendidikan_terakhir">
                                <option value="">Pilih Pendidikan Terakhir</option>
                                <option value="SD"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'SD' ? 'selected' : '' }}>
                                    SD
                                </option>
                                <option value="SMP"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'SMP' ? 'selected' : '' }}>
                                    SMP
                                </option>
                                <option value="SMA"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'SMA' ? 'selected' : '' }}>
                                    SMA
                                </option>
                                <option value="SMK"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'SMK' ? 'selected' : '' }}>
                                    SMK
                                </option>
                                <option value="D1"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'D1' ? 'selected' : '' }}>
                                    D1
                                </option>
                                <option value="D2"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'D2' ? 'selected' : '' }}>
                                    D2
                                </option>
                                <option value="D3"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'D3' ? 'selected' : '' }}>
                                    D3
                                </option>
                                <option value="D4"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'D4' ? 'selected' : '' }}>
                                    D4
                                </option>
                                <option value="S1"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'S1' ? 'selected' : '' }}>
                                    S1
                                </option>
                                <option value="S2"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'S2' ? 'selected' : '' }}>
                                    S2
                                </option>
                                <option value="S3"
                                    {{ old('pendidikan_terakhir', $wali->mahasiswaWaliDetail->pendidikan) == 'S3' ? 'selected' : '' }}>
                                    S3
                                </option>
                            </select>
                            @error('pendidikan_terakhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <hr>
                </div>
            </div>

            {{-- Form KTP Wali --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form KTP Wali</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- NIK --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_nik" class="form-label">NIK</label>
                            <input type="text" class="form-control @error('wali_nik') is-invalid @enderror"
                                id="wali_nik" name="wali_nik" placeholder="NIK"
                                value="{{ old('wali_nik') ?? $wali->ktp->nik }}" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                            @error('wali_nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_alamat_jalan" class="form-label">Alamat Jalan</label>
                            <textarea class="form-control @error('wali_alamat_jalan') is-invalid @enderror" id="wali_alamat_jalan"
                                name="wali_alamat_jalan" placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_jalan', $wali->ktp->alamat_jalan) }}</textarea>
                            @error('wali_alamat_jalan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- RT --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_alamat_rt" class="form-label">RT</label>
                            <input type="text" class="form-control @error('wali_alamat_rt') is-invalid @enderror"
                                id="wali_alamat_rt" name="wali_alamat_rt" placeholder="000"
                                value="{{ old('wali_alamat_rt') ?? $wali->ktp->alamat_rt }}" maxlength="3"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                            @error('wali_alamat_rt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- RW --}}
                        <div class="col-md-6 mb-3">
                            <label for="wali_alamat_rw" class="form-label">RW</label>
                            <input type="text" class="form-control @error('wali_alamat_rw') is-invalid @enderror"
                                id="wali_alamat_rw" name="wali_alamat_rw" placeholder="000"
                                value="{{ old('wali_alamat_rw') ?? $wali->ktp->alamat_rw }}" maxlength="3"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                            @error('wali_alamat_rw')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Provinsi --}}
                        <div class="col-md-3 mb-3">
                            <label for="wali_alamat_prov_code" class="form-label">Provinsi</label>
                            <select class="form-select @error('wali_alamat_prov_code') is-invalid @enderror"
                                id="wali_alamat_prov_code" name="wali_alamat_prov_code">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}"
                                        {{ old('wali_alamat_prov_code', $wali->ktp->alamat_prov_code) == $province->code ? 'selected' : '' }}>
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('wali_alamat_prov_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Kota/Kabupaten --}}
                        <div class="col-md-3 mb-3">
                            <label for="wali_alamat_kotakab_code" class="form-label">Kota/Kabupaten</label>
                            <select class="form-select @error('wali_alamat_kotakab_code') is-invalid @enderror"
                                id="wali_alamat_kotakab_code" name="wali_alamat_kotakab_code">
                                <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                {{-- Populated dynamically based on selected province --}}
                            </select>
                            @error('wali_alamat_kotakab_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Kecamatan --}}
                        <div class="col-md-3 mb-3">
                            <label for="wali_alamat_kec_code" class="form-label">Kecamatan</label>
                            <select class="form-select @error('wali_alamat_kec_code') is-invalid @enderror"
                                id="wali_alamat_kec_code" name="wali_alamat_kec_code">
                                <option value="" disabled selected>Pilih Kecamatan</option>
                                {{-- Populated dynamically based on selected city --}}
                            </select>
                            @error('wali_alamat_kec_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Kelurahan/Desa --}}
                        <div class="col-md-3 mb-3">
                            <label for="wali_alamat_kel_code" class="form-label">Kelurahan/Desa</label>
                            <select class="form-select @error('wali_alamat_kel_code') is-invalid @enderror"
                                id="wali_alamat_kel_code" name="wali_alamat_kel_code">
                                <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                                {{-- Populated dynamically based on selected district --}}
                            </select>
                            @error('wali_alamat_kel_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_lahir_tempat" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control @error('wali_lahir_tempat') is-invalid @enderror"
                                id="wali_lahir_tempat" name="wali_lahir_tempat" placeholder="Tempat Lahir"
                                value="{{ old('wali_lahir_tempat') ?? $wali->ktp->lahir_tempat }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('wali_lahir_tempat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_lahir_tgl" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('wali_lahir_tgl') is-invalid @enderror"
                                id="wali_lahir_tgl" name="wali_lahir_tgl"
                                value="{{ old('wali_lahir_tgl') ?? $wali->ktp->lahir_tgl }}">
                            @error('wali_lahir_tgl')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select @error('wali_jenis_kelamin') is-invalid @enderror"
                                id="wali_jenis_kelamin" name="wali_jenis_kelamin">
                                <option value="L"
                                    {{ old('wali_jenis_kelamin', $wali->ktp->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P"
                                    {{ old('wali_jenis_kelamin', $wali->ktp->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('wali_jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Agama --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_agama" class="form-label">Agama</label>
                            <input type="text" class="form-control @error('wali_agama') is-invalid @enderror"
                                id="wali_agama" name="wali_agama" placeholder="Agama"
                                value="{{ old('wali_agama') ?? $wali->ktp->agama }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('wali_agama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Golongan Darah --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_golongan_darah" class="form-label">Golongan Darah</label>
                            <select class="form-select @error('wali_golongan_darah') is-invalid @enderror"
                                id="wali_golongan_darah" name="wali_golongan_darah">
                                <option value="" disabled selected>Pilih Golongan Darah</option>
                                <option value="A"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'A' ? 'selected' : '' }}>
                                    A
                                </option>
                                <option value="A+"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'A+' ? 'selected' : '' }}>
                                    A+
                                </option>
                                <option value="A-"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'A-' ? 'selected' : '' }}>
                                    A-
                                </option>
                                <option value="B"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'B' ? 'selected' : '' }}>
                                    B
                                </option>
                                <option value="B+"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'B+' ? 'selected' : '' }}>
                                    B+
                                </option>
                                <option value="B-"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'B-' ? 'selected' : '' }}>
                                    B-
                                </option>
                                <option value="AB"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'AB' ? 'selected' : '' }}>
                                    AB
                                </option>
                                <option value="AB+"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'AB+' ? 'selected' : '' }}>
                                    AB+
                                </option>
                                <option value="AB-"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'AB-' ? 'selected' : '' }}>
                                    AB-
                                </option>
                                <option value="O"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'O' ? 'selected' : '' }}>
                                    O
                                </option>
                                <option value="O+"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'O+' ? 'selected' : '' }}>
                                    O+
                                </option>
                                <option value="O-"
                                    {{ old('wali_golongan_darah', $wali->ktp->golongan_darah) == 'O-' ? 'selected' : '' }}>
                                    O-
                                </option>
                            </select>
                            @error('wali_golongan_darah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Kewarganegaraan --}}
                        <div class="col-md-4 mb-3">
                            <label for="wali_kewarganegaraan" class="form-label">Kewarganegaraan</label>
                            <input type="text"
                                class="form-control @error('wali_kewarganegaraan') is-invalid @enderror"
                                id="wali_kewarganegaraan" name="wali_kewarganegaraan" placeholder="Kewarganegaraan"
                                value="{{ old('wali_kewarganegaraan') ?? $wali->ktp->kewarganegaraan }}"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('wali_kewarganegaraan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Button Submit --}}
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            const populateSelect = (url, selectElement, placeholder) => {
                return $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        selectElement.empty().append(`<option value="">${placeholder}</option>`);
                        $.each(data, function(key, value) {
                            selectElement.append(
                                `<option value="${value.code}">${value.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data, silakan coba lagi.');
                    }
                });
            };

            // Functionality for Mahasiswa Address
            $('#alamat_prov_code').on('change', function() {
                const provinceCode = $(this).val();
                if (provinceCode) {
                    populateSelect('/mahasiswa/cities/' + provinceCode, $('#alamat_kotakab_code'),
                        'Pilih Kota/Kabupaten').done(function() {
                        $('#alamat_kec_code').empty().append(
                            '<option value="">Pilih Kecamatan</option>');
                        $('#alamat_kel_code').empty().append(
                            '<option value="">Pilih Kelurahan/Desa</option>');
                    });
                } else {
                    $('#alamat_kotakab_code').empty().append(
                        '<option value="">Pilih Kota/Kabupaten</option>');
                    $('#alamat_kec_code').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#alamat_kel_code').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
                }
            });

            $('#alamat_kotakab_code').on('change', function() {
                const cityCode = $(this).val();
                if (cityCode) {
                    populateSelect('/mahasiswa/districts/' + cityCode, $('#alamat_kec_code'),
                        'Pilih Kecamatan').done(function() {
                        $('#alamat_kel_code').empty().append(
                            '<option value="">Pilih Kelurahan/Desa</option>');
                    });
                } else {
                    $('#alamat_kec_code').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#alamat_kel_code').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
                }
            });

            $('#alamat_kec_code').on('change', function() {
                const districtCode = $(this).val();
                if (districtCode) {
                    populateSelect('/mahasiswa/villages/' + districtCode, $('#alamat_kel_code'),
                        'Pilih Kelurahan/Desa');
                } else {
                    $('#alamat_kel_code').empty().append('<option value="">Pilih Kelurahan/Desa</option>');
                }
            });

            // Functionality for Guardian (Wali)
            $('#wali_alamat_prov_code').on('change', function() {
                const provinceCode = $(this).val();
                if (provinceCode) {
                    populateSelect('/mahasiswa/cities/' + provinceCode, $('#wali_alamat_kotakab_code'),
                        'Pilih Kota/Kabupaten').done(function() {
                        $('#wali_alamat_kec_code').empty().append(
                            '<option value="">Pilih Kecamatan</option>');
                        $('#wali_alamat_kel_code').empty().append(
                            '<option value="">Pilih Kelurahan/Desa</option>');
                    });
                } else {
                    $('#wali_alamat_kotakab_code').empty().append(
                        '<option value="">Pilih Kota/Kabupaten</option>');
                    $('#wali_alamat_kec_code').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#wali_alamat_kel_code').empty().append(
                        '<option value="">Pilih Kelurahan/Desa</option>');
                }
            });

            $('#wali_alamat_kotakab_code').on('change', function() {
                const cityCode = $(this).val();
                if (cityCode) {
                    populateSelect('/mahasiswa/districts/' + cityCode, $('#wali_alamat_kec_code'),
                        'Pilih Kecamatan').done(function() {
                        $('#wali_alamat_kel_code').empty().append(
                            '<option value="">Pilih Kelurahan/Desa</option>');
                    });
                } else {
                    $('#wali_alamat_kec_code').empty().append('<option value="">Pilih Kecamatan</option>');
                    $('#wali_alamat_kel_code').empty().append(
                        '<option value="">Pilih Kelurahan/Desa</option>');
                }
            });

            $('#wali_alamat_kec_code').on('change', function() {
                const districtCode = $(this).val();
                if (districtCode) {
                    populateSelect('/mahasiswa/villages/' + districtCode, $('#wali_alamat_kel_code'),
                        'Pilih Kelurahan/Desa');
                } else {
                    $('#wali_alamat_kel_code').empty().append(
                        '<option value="">Pilih Kelurahan/Desa</option>');
                }
            });

            // Pre-select values for Mahasiswa Address if they exist
            const selectedProvinceCode = "{{ old('alamat_prov_code', $mahasiswa->ktp->alamat_prov_code) }}";
            const selectedCityCode = "{{ old('alamat_kotakab_code', $mahasiswa->ktp->alamat_kotakab_code) }}";
            const selectedDistrictCode = "{{ old('alamat_kec_code', $mahasiswa->ktp->alamat_kec_code) }}";
            const selectedVillageCode = "{{ old('alamat_kel_code', $mahasiswa->ktp->alamat_kel_code) }}";

            if (selectedProvinceCode) {
                populateSelect('/mahasiswa/cities/' + selectedProvinceCode, $('#alamat_kotakab_code'),
                    'Pilih Kota/Kabupaten').done(function() {
                    $('#alamat_kotakab_code').val(selectedCityCode);

                    if (selectedCityCode) {
                        populateSelect('/mahasiswa/districts/' + selectedCityCode, $('#alamat_kec_code'),
                            'Pilih Kecamatan').done(function() {
                            $('#alamat_kec_code').val(selectedDistrictCode);

                            if (selectedDistrictCode) {
                                populateSelect('/mahasiswa/villages/' + selectedDistrictCode, $(
                                    '#alamat_kel_code'), 'Pilih Kelurahan/Desa').done(
                                    function() {
                                        $('#alamat_kel_code').val(selectedVillageCode);
                                    });
                            }
                        });
                    }
                });
            }

            // Pre-select values for Guardian Address if they exist
            const selectedWaliProvinceCode = "{{ old('wali_alamat_prov_code', $wali->ktp->alamat_prov_code) }}";
            const selectedWaliCityCode = "{{ old('wali_alamat_kotakab_code', $wali->ktp->alamat_kotakab_code) }}";
            const selectedWaliDistrictCode = "{{ old('wali_alamat_kec_code', $wali->ktp->alamat_kec_code) }}";
            const selectedWaliVillageCode = "{{ old('wali_alamat_kel_code', $wali->ktp->alamat_kel_code) }}";

            if (selectedWaliProvinceCode) {
                populateSelect('/mahasiswa/cities/' + selectedWaliProvinceCode, $('#wali_alamat_kotakab_code'),
                    'Pilih Kota/Kabupaten').done(function() {
                    $('#wali_alamat_kotakab_code').val(selectedWaliCityCode);

                    if (selectedWaliCityCode) {
                        populateSelect('/mahasiswa/districts/' + selectedWaliCityCode, $(
                                '#wali_alamat_kec_code'),
                            'Pilih Kecamatan').done(function() {
                            $('#wali_alamat_kec_code').val(selectedWaliDistrictCode);

                            if (selectedWaliDistrictCode) {
                                populateSelect('/mahasiswa/villages/' + selectedWaliDistrictCode, $(
                                    '#wali_alamat_kel_code'), 'Pilih Kelurahan/Desa').done(
                                    function() {
                                        $('#wali_alamat_kel_code').val(selectedWaliVillageCode);
                                    });
                            }
                        });
                    }
                });
            }
        });
    </script>

@endsection
