@extends('layouts.custom')

@section('title', 'Form Mahasiswa')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('mahasiswa.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <form action="{{ route('mahasiswa.store') }}" method="POST">
        @csrf
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
                                name="nim" placeholder="NIM" value="{{ old('nim') }}" maxlength="16"
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
                                name="nama" placeholder="NAMA" value="{{ old('nama') ? strtoupper(old('nama')) : '' }}"
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
                                        {{ old('program_studi') == $ps->id ? 'selected' : '' }}>
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
                                id="registrasi_tanggal" name="registrasi_tanggal" value="{{ old('registrasi_tanggal') }}">
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
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non Aktif" {{ old('status') == 'Non Aktif' ? 'selected' : '' }}>Non Aktif
                                </option>
                                <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="Lulus" {{ old('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Semester Berjalan --}}
                        <input type="hidden" name="semester_berjalan" id="semester_berjalan" value="1">

                        {{-- No Hp --}}
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                name="no_hp" placeholder="No HP" value="{{ old('no_hp') }}" maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                            @error('no_hp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Alamat Domisili --}}
                        <div class="col-md-6 mb-3">
                            <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                            <textarea class="form-control @error('alamat_domisili') is-invalid @enderror" id="alamat_domisili" name="alamat_domisili"
                                placeholder="Alamat Domisili" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_domisili') }}</textarea>
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

            {{-- Form KTP  Mahasiswa--}}
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
                                name="nik" placeholder="NIK" value="{{ old('nik') }}" maxlength="16"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
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
                                placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_jalan') }}</textarea>
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
                                id="alamat_rt" name="alamat_rt" placeholder="000" value="{{ old('alamat_rt') }}"
                                maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                            @error('alamat_rt')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_rw" class="form-label">RW</label>
                            <input type="text" class="form-control @error('alamat_rw') is-invalid @enderror"
                                id="alamat_rw" name="alamat_rw" placeholder="000" value="{{ old('alamat_rw') }}"
                                maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
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
                                        {{ old('alamat_prov_code') == $province->code ? 'selected' : '' }}>
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
                                value="{{ old('lahir_tempat') ? strtoupper(old('lahir_tempat')) : '' }}"
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
                                id="lahir_tgl" name="lahir_tgl" value="{{ old('lahir_tgl') }}">
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
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
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
                                value="{{ old('agama') ? strtoupper(old('agama')) : '' }}"
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
                                <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="A+" {{ old('golongan_darah') == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('golongan_darah') == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="B+" {{ old('golongan_darah') == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('golongan_darah') == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="AB+" {{ old('golongan_darah') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('golongan_darah') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                <option value="O+" {{ old('golongan_darah') == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('golongan_darah') == 'O-' ? 'selected' : '' }}>O-</option>
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
                                value="{{ old('kewarganegaraan') ? strtoupper(old('kewarganegaraan')) : '' }}"
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
            $('#alamat_prov_code').on('change', function() {
                var provinceCode = $(this).val();
                if (provinceCode) {
                    $.ajax({
                        url: '/ktp/cities/' + provinceCode,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#alamat_kotakab_code').empty().append(
                                '<option value="">Pilih Kota/Kabupaten</option>');
                            $.each(data, function(key, value) {
                                $('#alamat_kotakab_code').append('<option value="' +
                                    value
                                    .code + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#alamat_kotakab_code').empty().prop('disabled', true).append(
                        '<option value="">Pilih Kota</option>');
                }
            });

            $('#alamat_kotakab_code').on('change', function() {
                var cityCode = $(this).val();
                if (cityCode) {
                    $.ajax({
                        url: '/ktp/districts/' + cityCode,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#alamat_kec_code').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                            $.each(data, function(key, value) {
                                $('#alamat_kec_code').append('<option value="' +
                                    value.code + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#alamat_kec_code').empty().append('<option value="">Pilih Kecamatan</option>');
                }
            });

            $('#alamat_kec_code').on('change', function() {
                var districtCode = $(this).val();
                if (districtCode) {
                    $.ajax({
                        url: '/ktp/villages/' + districtCode,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#alamat_kel_code').empty().append(
                                '<option value="">Pilih Kelurahan/Desa</option>');
                            $.each(data, function(key, value) {
                                $('#alamat_kel_code').append('<option value="' +
                                    value.code + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#alamat_kel_code').empty().append(
                        '<option value="">Pilih Kelurahan/Desa</option>');
                }
            });
        });
    </script>

@endsection
