@extends('layouts.custom')

@section('title', 'Form KTP')

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

    <div class="card-header">
        <h4 class="card-title">Form Edit Biodata SDM</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('hr.update', $hr->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    {{-- NIK --}}
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                            name="nik" placeholder="NIK" value="{{ old('nik', $hr->ktp->nik) }}" maxlength="16"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- nip --}}
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                            name="nip" placeholder="NIP" value="{{ old('nip', $hr->nip) }}" maxlength="18"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 18)">
                        @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" placeholder="NAMA LENGKAP"
                            value="{{ old('nama', $hr->ktp->nama) ? strtoupper(old('nama', $hr->ktp->nama)) : '' }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- gelar_depan --}}
                    <div class="mb-3">
                        <label for="gelar_depan" class="form-label>">Gelar Depan</label>
                        <input type="text" class="form-control @error('gelar_depan') is-invalid @enderror"
                            id="gelar_depan" name="gelar_depan" placeholder="Gelar Depan"
                            value="{{ old('gelar_depan', $hr->gelar_depan) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('gelar_depan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- gelar_belakang --}}
                    <div class="mb-3">
                        <label for="gelar_belakang" class="form-label>">Gelar Belakang</label>
                        <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror"
                            id="gelar_belakang" name="gelar_belakang" placeholder="Gelar Belakang"
                            value="{{ old('gelar_belakang', $hr->gelar_belakang) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('gelar_belakang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- hp --}}
                    <div class="mb-3">
                        <label for="hp" class="form-label>">No. HP</label>
                        <input type="text" class="form-control @error('hp') is-invalid @enderror" id="hp"
                            name="hp" placeholder="No. HP" value="{{ old('hp', $hr->hrDetail->hp) }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        @error('hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label>">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" value="{{ old('email', $hr->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label for="alamat_jalan" class="form-label">Alamat Jalan</label>
                        <textarea class="form-control @error('alamat_jalan') is-invalid @enderror" id="alamat_jalan" name="alamat_jalan"
                            placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_jalan', $hr->ktp->alamat_jalan) }}</textarea>
                        @error('alamat_jalan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="alamat_rt" class="form-label">RT</label>
                            <input type="text" class="form-control @error('alamat_rt') is-invalid @enderror"
                                id="alamat_rt" name="alamat_rt" placeholder="000"
                                value="{{ old('alamat_rt', $hr->ktp->alamat_rt) }}" maxlength="3"
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
                                value="{{ old('alamat_rw', $hr->ktp->alamat_rw) }}" maxlength="3"
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
                                    {{ old('alamat_prov_code', $hr->ktp->alamat_prov_code) == $province->code ? 'selected' : '' }}>
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
                        <select class="form-select @error('alamat_kotakab_code') is-invalid @enderror"
                            id="alamat_kotakab_code" name="alamat_kotakab_code">
                            <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->code }}"
                                    {{ old('alamat_kotakab_code', $hr->ktp->alamat_kotakab_code) == $city->code ? 'selected' : '' }}>
                                    {{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('alamat_kotakab_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                </div>

                <div class="col-md-6">

                    {{-- Alamat Kecamatan --}}
                    <div class="mb-3">
                        <label for="alamat_kec_code" class="form-label">Kecamatan</label>
                        <select class="form-select @error('alamat_kec_code') is-invalid @enderror" id="alamat_kec_code"
                            name="alamat_kec_code">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->code }}"
                                    {{ old('alamat_kec_code', $hr->ktp->alamat_kec_code) == $district->code ? 'selected' : '' }}>
                                    {{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('alamat_kec_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Alamat Kelurahan --}}
                    <div class="mb-3">
                        <label for="alamat_kel_code" class="form-label">Kelurahan/Desa</label>
                        <select class="form-select @error('alamat_kel_code') is-invalid @enderror" id="alamat_kel_code"
                            name="alamat_kel_code">
                            <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->code }}"
                                    {{ old('alamat_kel_code', $hr->ktp->alamat_kel_code) == $village->code ? 'selected' : '' }}>
                                    {{ $village->name }}</option>
                            @endforeach
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
                        <input type="text" class="form-control @error('lahir_tempat') is-invalid @enderror"
                            id="lahir_tempat" name="lahir_tempat" placeholder="Tempat Lahir"
                            value="{{ old('lahir_tempat', $hr->ktp->lahir_tempat) ? strtoupper(old('lahir_tempat', $hr->ktp->lahir_tempat)) : '' }}"
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
                        <input type="date" class="form-control @error('lahir_tgl') is-invalid @enderror"
                            id="lahir_tgl" name="lahir_tgl" value="{{ old('lahir_tgl', $hr->ktp->lahir_tgl) }}">
                        @error('lahir_tgl')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
                                id="laki_laki" name="jenis_kelamin" value="L"
                                {{ old('jenis_kelamin', $hr->ktp->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                            <label class="form-check-label" for="laki_laki">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio"
                                id="perempuan" name="jenis_kelamin" value="P"
                                {{ old('jenis_kelamin', $hr->ktp->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                            <label class="form-check-label" for="perempuan">
                                Perempuan
                            </label>
                        </div>
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
                            name="agama" placeholder="Agama"
                            value="{{ old('agama', $hr->ktp->agama) ? strtoupper(old('agama', $hr->ktp->agama)) : '' }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('agama')
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
                            value="{{ old('kewarganegaraan', $hr->ktp->kewarganegaraan) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('kewarganegaraan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Foto Profil --}}
                    <div class="mb-3">
                        <label for="photo_profile" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control @error('photo_profile') is-invalid @enderror"
                            id="photo_profile" name="photo_profile">
                        @if ($hr->photo_profile)
                            <img src="{{ asset('storage/' . $hr->photo_profile) }}" alt="Foto Profil"
                                class="img-thumbnail mt-2" width="150">
                        @endif
                        @error('photo_profile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
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
