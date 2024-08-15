@extends('layouts.custom')

@section('title', 'Form KTP')

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
        <h4 class="card-title">Form KTP HR</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('hr.store') }}" method="POST">
            @csrf
        
            <!-- KTP Fields -->
            <h3>KTP Information</h3>
            
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
                    placeholder="NIK" value="{{ old('nik') }}" maxlength="16"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                @error('nik')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                    name="nama" placeholder="NAMA LENGKAP"
                    value="{{ old('nama') ? strtoupper(old('nama')) : '' }}"
                    oninput="this.value = this.value.toUpperCase()">
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="alamat_jalan" class="form-label">Alamat Jalan</label>
                <textarea class="form-control @error('alamat_jalan') is-invalid @enderror" id="alamat_jalan" name="alamat_jalan"
                    placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_jalan') }}</textarea>
                @error('alamat_jalan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="alamat_rt" class="form-label">RT</label>
                    <input type="text" class="form-control @error('alamat_rt') is-invalid @enderror" id="alamat_rt"
                        name="alamat_rt" placeholder="000" value="{{ old('alamat_rt') }}" maxlength="3"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                    @error('alamat_rt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="alamat_rw" class="form-label">RW</label>
                    <input type="text" class="form-control @error('alamat_rw') is-invalid @enderror" id="alamat_rw"
                        name="alamat_rw" placeholder="000" value="{{ old('alamat_rw') }}" maxlength="3"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                    @error('alamat_rw')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        
         {{-- Alamat Provinsi --}}
         <div class="mb-3">
            <label for="alamat_prov_code" class="form-label">Provinsi</label>
            <select class="form-select @error('alamat_prov_code') is-invalid @enderror" id="alamat_prov_code"
                name="alamat_prov_code">
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
        <div class="mb-3">
            <label for="alamat_kotakab_code" class="form-label">Kota/Kabupaten</label>
            <select class="form-select @error('alamat_kotakab_code') is-invalid @enderror" id="alamat_kotakab_code"
                name="alamat_kotakab_code">
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
        <div class="mb-3">
            <label for="alamat_kec_code" class="form-label">Kecamatan</label>
            <select class="form-select @error('alamat_kec_code') is-invalid @enderror" id="alamat_kec_code"
                name="alamat_kec_code">
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
        <div class="mb-3">
            <label for="alamat_kel_code" class="form-label">Kelurahan/Desa</label>
            <select class="form-select @error('alamat_kel_code') is-invalid @enderror" id="alamat_kel_code"
                name="alamat_kel_code">
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
            <div class="mb-3">
                <label for="lahir_tempat" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control @error('lahir_tempat') is-invalid @enderror" id="lahir_tempat"
                    name="lahir_tempat" placeholder="Tempat Lahir"
                    value="{{ old('lahir_tempat') ? strtoupper(old('lahir_tempat')) : '' }}"
                    oninput="this.value = this.value.toUpperCase()">
                @error('lahir_tempat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="mb-3">
                <label for="lahir_tgl" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control @error('lahir_tgl') is-invalid @enderror" id="lahir_tgl"
                    name="lahir_tgl" value="{{ old('lahir_tgl') }}">
                @error('lahir_tgl')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                    name="jenis_kelamin">
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Agama --}}
            <div class="mb-3">
                <label for="agama" class="form-label">Agama</label>
                <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama"
                    name="agama" placeholder="Agama" value="{{ old('agama') ? strtoupper(old('agama')) : '' }}"
                    oninput="this.value = this.value.toUpperCase()">
                @error('agama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Golongan Darah --}}
            <div class="mb-3">
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
            <div class="mb-3">
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

            <div class="mb-3">
                <label for="position_id" class="form-label">Posisi</label>
                <select class="form-select @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                    <option value="" disabled selected>Pilih Posisi</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                            {{ $position->posisi }}
                        </option>
                    @endforeach
                </select>
            </div>

             {{-- NIP --}}
             <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
                    placeholder="NIP" value="{{ old('nip') }}" maxlength="18"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18)">
                @error('nip')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Gelar Depan --}}
            <div class="mb-3">
                <label for="gelar_depan" class="form-label">Gelar Depan</label>
                <input type="text" class="form-control @error('gelar_depan') is-invalid @enderror" id="gelar_depan"
                    name="gelar_depan" placeholder="Gelar Depan"
                    value="{{ old('gelar_depan') ? strtoupper(old('gelar_depan')) : '' }}"
                    oninput="this.value = this.value.toUpperCase()">
                @error('gelar_depan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

                {{-- Gelar Belakang --}}

                <div class="mb-3">
                    <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                    <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" id="gelar_belakang"
                        name="gelar_belakang" placeholder="Gelar Belakang"
                        value="{{ old('gelar_belakang') ? strtoupper(old('gelar_belakang')) : '' }}"
                        oninput="this.value = this.value.toUpperCase()">
                    @error('gelar_belakang')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        


        
    </div>

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
                                $('#alamat_kotakab_code').append('<option value="' + value
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
