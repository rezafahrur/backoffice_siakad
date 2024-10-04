@extends('layouts.app')

@section('title', 'Form Mahasiswa')

@section('content')

    <div class="card-body">
        <!-- Progress Bar -->
        <div class="row text-center">
            <div class="col step active" id="step1">
                <div class="step-icon">1</div>
                <div class="step-title">Mahasiswa</div>
            </div>
            <div class="col step" id="step2">
                <div class="step-icon">2</div>
                <div class="step-title">Orang Tua</div>
            </div>
            <div class="col step" id="step3">
                <div class="step-icon">3</div>
                <div class="step-title">Kontak Darurat / Wali</div>
            </div>
            <div class="col step" id="step4">
                <div class="step-icon">4</div>
                <div class="step-title">Kebutuhan</div>
            </div>
        </div>

        {{-- Check for validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade mt-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Check for other error messages --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade mt-4">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="formWizard" class="mt-4" action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf

            <!-- Step 1 -->
            <div class="tab">
                {{-- Form Mahasiswa --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form Mahasiswa</h3>
                        <div class="row">

                            {{-- Nama --}}
                            <div class="col-md-4 mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" placeholder="NAMA"
                                    value="{{ old('nama') ? strtoupper(old('nama')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- NISN --}}
                            <div class="col-md-4 mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                    id="nisn" name="nisn" placeholder="NISN" value="{{ old('nisn') }}"
                                    maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                @error('nisn')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div class="col-md-4 mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan"
                                    name="jurusan" required>
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    @foreach ($jurusan as $js)
                                        <option value="{{ $js->id }}"
                                            {{ old('jurusan') == $js->id ? 'selected' : '' }}>
                                            {{ $js->nama_jurusan }}
                                        </option>
                                    @endforeach
                                    </option>
                                </select>
                                @error('jurusan')
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
                                    id="registrasi_tanggal" name="registrasi_tanggal"
                                    value="{{ old('registrasi_tanggal') }}">
                                @error('registrasi_tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Status Mahasiswa --}}
                            <input type="hidden" name="status" id="status" value="0">

                            {{-- Semester Berjalan --}}
                            <input type="hidden" name="semester_berjalan" id="semester_berjalan" value="1">

                            {{-- Is Filled --}}
                            <input type="hidden" name="is_filled" id="is_filled" value="1">

                            {{-- Telp Rumah --}}
                            <div class="col-md-4 mb-3">
                                <label for="telp_rumah" class="form-label">Telp Rumah</label>
                                <input type="text" class="form-control @error('telp_rumah') is-invalid @enderror"
                                    id="telp_rumah" name="telp_rumah" placeholder="Telp Rumah"
                                    value="{{ old('telp_rumah') }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('telp_rumah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- No Hp --}}
                            <div class="col-md-4 mb-3">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                    id="no_hp" name="no_hp" placeholder="No HP" value="{{ old('no_hp') }}"
                                    maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
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
                                    name="alamat_domisili" placeholder="Alamat Domisili" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_domisili') }}</textarea>
                                @error('alamat_domisili')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Kode Pos --}}
                            <div class="col-md-4 mb-3">
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                                    id="kode_pos" name="kode_pos" placeholder="Kode Pos" value="{{ old('kode_pos') }}"
                                    maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5)">
                                @error('kode_pos')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- NPWP --}}
                            <div class="col-md-4 mb-3">
                                <label for="npwp" class="form-label">NPWP</label>
                                <input type="text" class="form-control @error('npwp') is-invalid @enderror"
                                    id="npwp" name="npwp" placeholder="NPWP" value="{{ old('npwp') }}"
                                    maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                                @error('npwp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Jenis Tinggal --}}
                            <div class="col-md-4 mb-3">
                                <label for="jenis_tinggal" class="form-label">Jenis Tinggal</label>
                                <select class="form-select @error('jenis_tinggal') is-invalid @enderror"
                                    id="jenis_tinggal" name="jenis_tinggal">
                                    <option value="" disabled selected>Pilih Jenis Tinggal</option>
                                    <option value="1" {{ old('jenis_tinggal') == '1' ? 'selected' : '' }}>
                                        Bersama Orang Tua
                                    </option>
                                    <option value="2" {{ old('jenis_tinggal') == '2' ? 'selected' : '' }}>
                                        Wali
                                    </option>
                                    <option value="3" {{ old('jenis_tinggal') == '3' ? 'selected' : '' }}>
                                        Kost
                                    </option>
                                    <option value="4" {{ old('jenis_tinggal') == '4' ? 'selected' : '' }}>
                                        Panti Asuhan
                                    </option>
                                    <option value="5" {{ old('jenis_tinggal') == '5' ? 'selected' : '' }}>
                                        Rumah Sendiri
                                    </option>
                                    <option value="99" {{ old('jenis_tinggal') == '99' ? 'selected' : '' }}>
                                        LAINNYA
                                    </option>
                                </select>
                                @error('jenis_tinggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alat Transportasi --}}
                            <div class="col-md-4 mb-3">
                                <label for="alat_transportasi" class="form-label">Alat Transportasi</label>
                                <select class="form-select @error('alat_transportasi') is-invalid @enderror"
                                    id="alat_transportasi" name="alat_transportasi">
                                    <option value="" disabled selected>Pilih Alat Transportasi</option>
                                    <option value="1" {{ old('alat_transportasi') == '1' ? 'selected' : '' }}>
                                        Jalan Kaki
                                    </option>
                                    <option value="3" {{ old('alat_transportasi') == '3' ? 'selected' : '' }}>
                                        Angkutan umum/bus/pete-pete
                                    </option>
                                    <option value="4" {{ old('alat_transportasi') == '4' ? 'selected' : '' }}>
                                        Mobil/bus antar jemput
                                    </option>
                                    <option value="5" {{ old('alat_transportasi') == '5' ? 'selected' : '' }}>
                                        Kereta Api
                                    </option>
                                    <option value="6" {{ old('alat_transportasi') == '6' ? 'selected' : '' }}>
                                        Ojek
                                    </option>
                                    <option value="7" {{ old('alat_transportasi') == '7' ? 'selected' : '' }}>
                                        Andong/Bendi/Sado/Dokar/Delman/Becak
                                    </option>
                                    <option value="8" {{ old('alat_transportasi') == '8' ? 'selected' : '' }}>
                                        Perahu Penyeberangan/Rakit/Getek
                                    </option>
                                    <option value="11" {{ old('alat_transportasi') == '11' ? 'selected' : '' }}>
                                        Kuda
                                    </option>
                                    <option value="12" {{ old('alat_transportasi') == '12' ? 'selected' : '' }}>
                                        Sepeda
                                    </option>
                                    <option value="13" {{ old('alat_transportasi') == '13' ? 'selected' : '' }}>
                                        Sepeda Motor
                                    </option>
                                    <option value="14" {{ old('alat_transportasi') == '14' ? 'selected' : '' }}>
                                        Mobil Pribadi
                                    </option>
                                    <option value="99" {{ old('alat_transportasi') == '99' ? 'selected' : '' }}>
                                        LAINNYA
                                    </option>
                                </select>
                                @error('alat_transportasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Terima KPS --}}
                            <div class="col-md-4 mb-3">
                                <label for="is_terima_kps" class="form-label">Terima KPS</label>
                                <select class="form-select @error('terima_kps') is-invalid @enderror" id="terima_kps"
                                    name="terima_kps" onchange="toggleNoKPSInput()">
                                    <option value="" disabled selected>Pilih Terima KPS</option>
                                    <option value="1" {{ old('terima_kps') == '1' ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ old('terima_kps') == '0' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                @error('terima_kps')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- No KPS --}}
                            <div id="no_kps_wrapper" class="col-md-4 mb-3" style="display: none;">
                                <label for="no_kps" class="form-label">No KPS</label>
                                <input type="text" class="form-control @error('no_kps') is-invalid @enderror"
                                    id="no_kps" name="no_kps" placeholder="No KPS" value="{{ old('no_kps') }}"
                                    maxlength="20" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 20)">
                                @error('no_kps')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                {{-- Form KTP Mahasiswa --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form KTP Mahasiswa</h3>
                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                    id="nik" name="nik" placeholder="NIK" value="{{ old('nik') }}"
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
                                    placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_jalan') }}</textarea>
                                @error('alamat_jalan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- RT RW --}}
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat_rt" class="form-label">RT</label>
                                        <input type="text"
                                            class="form-control @error('alamat_rt') is-invalid @enderror" id="alamat_rt"
                                            name="alamat_rt" placeholder="000" value="{{ old('alamat_rt') }}"
                                            maxlength="3"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                        @error('alamat_rt')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alamat_rw" class="form-label">RW</label>
                                        <input type="text"
                                            class="form-control @error('alamat_rw') is-invalid @enderror" id="alamat_rw"
                                            name="alamat_rw" placeholder="000" value="{{ old('alamat_rw') }}"
                                            maxlength="3"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                        @error('alamat_rw')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat Provinsi --}}
                            <div class="col-md-6 mb-3">
                                <label for="alamat_prov_code" class="form-label">Provinsi</label>
                                <select class="form-select @error('alamat_prov_code') is-invalid @enderror"
                                    id="alamat_prov_code" name="alamat_prov_code">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('alamat_prov_code', $data['alamat_prov_code'] ?? '') == $province->code ? 'selected' : '' }}>
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
                            <div class="col-md-4 mb-3">
                                <label for="alamat_kotakab_code" class="form-label">Kota/Kabupaten</label>
                                <select class="form-select @error('alamat_kotakab_code') is-invalid @enderror"
                                    id="alamat_kotakab_code" name="alamat_kotakab_code">
                                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('alamat_kotakab_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat Kecamatan --}}
                            <div class="col-md-4 mb-3">
                                <label for="alamat_kec_code" class="form-label">Kecamatan</label>
                                <select class="form-select @error('alamat_kec_code') is-invalid @enderror"
                                    id="alamat_kec_code" name="alamat_kec_code">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('alamat_kec_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat Kelurahan/Desa --}}
                            <div class="col-md-4 mb-3">
                                <label for="alamat_kel_code" class="form-label">Kelurahan/Desa</label>
                                <select class="form-select @error('alamat_kel_code') is-invalid @enderror"
                                    id="alamat_kel_code" name="alamat_kel_code">
                                    <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                                    {{-- Populated dynamically --}}
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
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
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
                                <select class="form-select @error('agama') is-invalid @enderror" id="agama"
                                    name="agama">
                                    <option value="" disabled selected>Pilih Agama</option>
                                    <option value="1" {{ old('agama') == '1' ? 'selected' : '' }}>Islam</option>
                                    <option value="2" {{ old('agama') == '2' ? 'selected' : '' }}>Kristen</option>
                                    <option value="3" {{ old('agama') == '3' ? 'selected' : '' }}>Katholik</option>
                                    <option value="4" {{ old('agama') == '4' ? 'selected' : '' }}>Hindu</option>
                                    <option value="5" {{ old('agama') == '5' ? 'selected' : '' }}>Budha</option>
                                    <option value="6" {{ old('agama') == '6' ? 'selected' : '' }}>Konghuchu</option>
                                    <option value="99" {{ old('agama') == '99' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('agama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Golongan Darah --}}
                            <div class="col-md-4 mb-3">
                                <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                <select class="form-select @error('golongan_darah') is-invalid @enderror"
                                    id="golongan_darah" name="golongan_darah">
                                    <option value="" disabled selected>Pilih Golongan Darah</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="A+" {{ old('golongan_darah') == 'A+' ? 'selected' : '' }}>A+
                                    </option>
                                    <option value="A-" {{ old('golongan_darah') == 'A-' ? 'selected' : '' }}>A-
                                    </option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B
                                    </option>
                                    <option value="B+" {{ old('golongan_darah') == 'B+' ? 'selected' : '' }}>B+
                                    </option>
                                    <option value="B-" {{ old('golongan_darah') == 'B-' ? 'selected' : '' }}>B-
                                    </option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB
                                    </option>
                                    <option value="AB+" {{ old('golongan_darah') == 'AB+' ? 'selected' : '' }}>AB+
                                    </option>
                                    <option value="AB-" {{ old('golongan_darah') == 'AB-' ? 'selected' : '' }}>AB-
                                    </option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O
                                    </option>
                                    <option value="O+" {{ old('golongan_darah') == 'O+' ? 'selected' : '' }}>O+
                                    </option>
                                    <option value="O-" {{ old('golongan_darah') == 'O-' ? 'selected' : '' }}>O-
                                    </option>
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
                                <select class="form-select @error('kewarganegaraan') is-invalid @enderror"
                                    id="kewarganegaraan" name="kewarganegaraan">
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    <option value="ID" {{ old('kewarganegaraan') == 'ID' ? 'selected' : '' }}>
                                        Indonesia</option>
                                    <option value="AS" {{ old('kewarganegaraan') == 'AS' ? 'selected' : '' }}>Amerika
                                        Serikat</option>
                                    <option value="AU" {{ old('kewarganegaraan') == 'AU' ? 'selected' : '' }}>
                                        Australia</option>
                                    <option value="CA" {{ old('kewarganegaraan') == 'CA' ? 'selected' : '' }}>Canada
                                    </option>
                                    <option value="CN" {{ old('kewarganegaraan') == 'CN' ? 'selected' : '' }}>China
                                    </option>
                                    <option value="JP" {{ old('kewarganegaraan') == 'JP' ? 'selected' : '' }}>Jepang
                                    </option>
                                    <option value="MY" {{ old('kewarganegaraan') == 'MY' ? 'selected' : '' }}>
                                        Malaysia</option>
                                    <option value="SG" {{ old('kewarganegaraan') == 'SG' ? 'selected' : '' }}>
                                        Singapura</option>
                                </select>
                                @error('kewarganegaraan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="tab">
                {{-- Form Wali Mahasiswa Ayah --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form Wali Mahasiswa Ayah</h3>
                        <div class="row">
                            {{-- Nama Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nama_1" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('wali_nama_1') is-invalid @enderror"
                                    id="wali_nama_1" name="wali_nama_1" placeholder="Nama Wali"
                                    value="{{ old('wali_nama_1') ? strtoupper(old('wali_nama_1')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_nama_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Hubungan --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_kewalian_1" class="form-label">Hubungan</label>
                                <input type="text"
                                    class="form-control @error('status_kewalian_1') is-invalid @enderror"
                                    id="status_kewalian_1" name="status_kewalian_1" value="AYAH" disabled>
                                @error('status_kewalian_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- No HP Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_no_hp_1" class="form-label">No HP</label>
                                <input type="text" class="form-control @error('wali_no_hp_1') is-invalid @enderror"
                                    id="wali_no_hp_1" name="wali_no_hp_1" placeholder="No HP Wali"
                                    value="{{ old('wali_no_hp_1') }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('wali_no_hp_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat Domisili Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_domisili_1" class="form-label">Alamat Domisili</label>
                                <textarea class="form-control @error('wali_alamat_domisili_1') is-invalid @enderror" id="wali_alamat_domisili_1"
                                    name="wali_alamat_domisili_1" placeholder="Alamat Wali" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_domisili_1') }}</textarea>
                                @error('wali_alamat_domisili_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_pekerjaan_1" class="form-label">Pekerjaan</label>
                                <select class="form-select @error('wali_pekerjaan_1') is-invalid @enderror"
                                    id="wali_pekerjaan_1" name="wali_pekerjaan_1">
                                    <option value="" disabled selected>Pilih Pekerjaan</option>
                                    <option value="1" {{ old('wali_pekerjaan_1') == '1' ? 'selected' : '' }}>Tidak
                                        bekerja</option>
                                    <option value="2" {{ old('wali_pekerjaan_1') == '2' ? 'selected' : '' }}>Nelayan
                                    </option>
                                    <option value="3" {{ old('wali_pekerjaan_1') == '3' ? 'selected' : '' }}>Petani
                                    </option>
                                    <option value="4" {{ old('wali_pekerjaan_1') == '4' ? 'selected' : '' }}>
                                        Peternak</option>
                                    <option value="5" {{ old('wali_pekerjaan_1') == '5' ? 'selected' : '' }}>
                                        PNS/TNI/Polri</option>
                                    <option value="6" {{ old('wali_pekerjaan_1') == '6' ? 'selected' : '' }}>
                                        Karyawan Swasta</option>
                                    <option value="7" {{ old('wali_pekerjaan_1') == '7' ? 'selected' : '' }}>
                                        Pedagang Kecil</option>
                                    <option value="8" {{ old('wali_pekerjaan_1') == '8' ? 'selected' : '' }}>
                                        Pedagang Besar</option>
                                    <option value="9" {{ old('wali_pekerjaan_1') == '9' ? 'selected' : '' }}>
                                        Wiraswasta</option>
                                    <option value="10" {{ old('wali_pekerjaan_1') == '10' ? 'selected' : '' }}>
                                        Wirausaha</option>
                                    <option value="11" {{ old('wali_pekerjaan_1') == '11' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="12" {{ old('wali_pekerjaan_1') == '12' ? 'selected' : '' }}>
                                        Pensiunan</option>
                                    <option value="13" {{ old('wali_pekerjaan_1') == '13' ? 'selected' : '' }}>
                                        Peneliti</option>
                                    <option value="14" {{ old('wali_pekerjaan_1') == '14' ? 'selected' : '' }}>Tim
                                        Ahli / Konsultan</option>
                                    <option value="15" {{ old('wali_pekerjaan_1') == '15' ? 'selected' : '' }}>Magang
                                    </option>
                                    <option value="16" {{ old('wali_pekerjaan_1') == '16' ? 'selected' : '' }}>Tenaga
                                        Pengajar / Instruktur / Fasilitator</option>
                                    <option value="17" {{ old('wali_pekerjaan_1') == '17' ? 'selected' : '' }}>
                                        Pimpinan / Manajerial</option>
                                    <option value="98" {{ old('wali_pekerjaan_1') == '98' ? 'selected' : '' }}>Sudah
                                        Meninggal</option>
                                    <option value="99" {{ old('wali_pekerjaan_1') == '99' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('wali_pekerjaan_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Penghasilan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_penghasilan_1" class="form-label">Penghasilan</label>
                                <select class="form-select @error('wali_penghasilan_1') is-invalid @enderror"
                                    id="wali_penghasilan_1" name="wali_penghasilan_1">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="11" {{ old('wali_penghasilan_1') == '11' ? 'selected' : '' }}>
                                        Kurang dari Rp. 500,000</option>
                                    <option value="12" {{ old('wali_penghasilan_1') == '12' ? 'selected' : '' }}>
                                        Rp. 500,000 - Rp. 999,999
                                    </option>
                                    <option value="13" {{ old('wali_penghasilan_1') == '13' ? 'selected' : '' }}>
                                        Rp. 1,000,000 - Rp. 1,999,999
                                    </option>
                                    <option value="14" {{ old('wali_penghasilan_1') == '14' ? 'selected' : '' }}>
                                        Rp. 2,000,000 - Rp. 4,999,999
                                    </option>
                                    <option value="15" {{ old('wali_penghasilan_1') == '15' ? 'selected' : '' }}>
                                        Rp. 5,000,000 - Rp. 20,000,000
                                    </option>
                                    <option value="16" {{ old('wali_penghasilan_1') == '16' ? 'selected' : '' }}>
                                        Lebih dari Rp. 20,000,000
                                    </option>
                                </select>
                                @error('wali_penghasilan_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pendidikan Terakhir --}}
                            <div class="col-md-4 mb-3">
                                <label for="pendidikan_terakhir_1" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select @error('pendidikan_terakhir_1') is-invalid @enderror"
                                    id="pendidikan_terakhir_1" name="pendidikan_terakhir_1">
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    <option value="0" {{ old('pendidikan_terakhir_1') == '0' ? 'selected' : '' }}>
                                        Tidak sekolah</option>
                                    <option value="1" {{ old('pendidikan_terakhir_1') == '1' ? 'selected' : '' }}>
                                        PAUD</option>
                                    <option value="2" {{ old('pendidikan_terakhir_1') == '2' ? 'selected' : '' }}>
                                        TK/ sederajat</option>
                                    <option value="3" {{ old('pendidikan_terakhir_1') == '3' ? 'selected' : '' }}>
                                        Putus SD</option>
                                    <option value="4" {{ old('pendidikan_terakhir_1') == '4' ? 'selected' : '' }}>SD
                                        / sederajat</option>
                                    <option value="5" {{ old('pendidikan_terakhir_1') == '5' ? 'selected' : '' }}>
                                        SMP / sederajat</option>
                                    <option value="6" {{ old('pendidikan_terakhir_1') == '6' ? 'selected' : '' }}>
                                        SMA / sederajat</option>
                                    <option value="7" {{ old('pendidikan_terakhir_1') == '7' ? 'selected' : '' }}>
                                        Paket A</option>
                                    <option value="8" {{ old('pendidikan_terakhir_1') == '8' ? 'selected' : '' }}>
                                        Paket B</option>
                                    <option value="9" {{ old('pendidikan_terakhir_1') == '9' ? 'selected' : '' }}>
                                        Paket C</option>
                                    <option value="20" {{ old('pendidikan_terakhir_1') == '20' ? 'selected' : '' }}>
                                        D1</option>
                                    <option value="21" {{ old('pendidikan_terakhir_1') == '21' ? 'selected' : '' }}>
                                        D2</option>
                                    <option value="22" {{ old('pendidikan_terakhir_1') == '22' ? 'selected' : '' }}>
                                        D3</option>
                                    <option value="23" {{ old('pendidikan_terakhir_1') == '23' ? 'selected' : '' }}>
                                        D4</option>
                                    <option value="30" {{ old('pendidikan_terakhir_1') == '30' ? 'selected' : '' }}>
                                        S1</option>
                                    <option value="31" {{ old('pendidikan_terakhir_1') == '31' ? 'selected' : '' }}>
                                        Profesi</option>
                                    <option value="32" {{ old('pendidikan_terakhir_1') == '32' ? 'selected' : '' }}>
                                        Sp-1</option>
                                    <option value="35" {{ old('pendidikan_terakhir_1') == '35' ? 'selected' : '' }}>
                                        S2</option>
                                    <option value="36" {{ old('pendidikan_terakhir_1') == '36' ? 'selected' : '' }}>
                                        S2 Terapan</option>
                                    <option value="37" {{ old('pendidikan_terakhir_1') == '37' ? 'selected' : '' }}>
                                        Sp-2</option>
                                    <option value="40" {{ old('pendidikan_terakhir_1') == '40' ? 'selected' : '' }}>
                                        S3</option>
                                    <option value="41" {{ old('pendidikan_terakhir_1') == '41' ? 'selected' : '' }}>
                                        S3 Terapan</option>
                                    <option value="90" {{ old('pendidikan_terakhir_1') == '90' ? 'selected' : '' }}>
                                        Non formal</option>
                                    <option value="91" {{ old('pendidikan_terakhir_1') == '91' ? 'selected' : '' }}>
                                        Informal</option>
                                    <option value="99" {{ old('pendidikan_terakhir_1') == '99' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('pendidikan_terakhir_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                {{-- Form KTP Wali Ayah --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form KTP Wali Ayah</h3>
                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nik_1" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('wali_nik_1') is-invalid @enderror"
                                    id="wali_nik_1" name="wali_nik_1" placeholder="NIK"
                                    value="{{ old('wali_nik_1') }}" maxlength="16"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                                @error('wali_nik_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_jalan_1" class="form-label">Alamat Jalan</label>
                                <textarea class="form-control @error('wali_alamat_jalan_1') is-invalid @enderror" id="wali_alamat_jalan_1"
                                    name="wali_alamat_jalan_1" placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_jalan_1') }}</textarea>
                                @error('wali_alamat_jalan_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- RT --}}
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="wali_alamat_rt_1" class="form-label">RT</label>
                                        <input type="text"
                                            class="form-control @error('wali_alamat_rt_1') is-invalid @enderror"
                                            id="wali_alamat_rt_1" name="wali_alamat_rt_1" placeholder="000"
                                            value="{{ old('wali_alamat_rt_1') }}" maxlength="3"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                        @error('wali_alamat_rt_1')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- RW --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="wali_alamat_rw_1" class="form-label">RW</label>
                                        <input type="text"
                                            class="form-control @error('wali_alamat_rw_1') is-invalid @enderror"
                                            id="wali_alamat_rw_1" name="wali_alamat_rw_1" placeholder="000"
                                            value="{{ old('wali_alamat_rw_1') }}" maxlength="3"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                        @error('wali_alamat_rw_1')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Wali 1 Alamat Provinsi --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_prov_code_1" class="form-label">Provinsi (Wali 1)</label>
                                <select class="form-select @error('wali_alamat_prov_code_1') is-invalid @enderror"
                                    id="wali_alamat_prov_code_1" name="wali_alamat_prov_code_1">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('wali_alamat_prov_code_1', $data['wali_alamat_prov_code_1'] ?? '') == $province->code ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('wali_alamat_prov_code_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 1 Alamat Kota/Kabupaten --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_alamat_kotakab_code_1" class="form-label">Kota/Kabupaten (Wali 1)</label>
                                <select class="form-select @error('wali_alamat_kotakab_code_1') is-invalid @enderror"
                                    id="wali_alamat_kotakab_code_1" name="wali_alamat_kotakab_code_1">
                                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('wali_alamat_kotakab_code_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 1 Alamat Kecamatan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_alamat_kec_code_1" class="form-label">Kecamatan (Wali 1)</label>
                                <select class="form-select @error('wali_alamat_kec_code_1') is-invalid @enderror"
                                    id="wali_alamat_kec_code_1" name="wali_alamat_kec_code_1">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('wali_alamat_kec_code_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 1 Alamat Kelurahan/Desa --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_alamat_kel_code_1" class="form-label">Kelurahan/Desa (Wali 1)</label>
                                <select class="form-select @error('wali_alamat_kel_code_1') is-invalid @enderror"
                                    id="wali_alamat_kel_code_1" name="wali_alamat_kel_code_1">
                                    <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('wali_alamat_kel_code_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_lahir_tempat_1" class="form-label">Tempat Lahir</label>
                                <input type="text"
                                    class="form-control @error('wali_lahir_tempat_1') is-invalid @enderror"
                                    id="wali_lahir_tempat_1" name="wali_lahir_tempat_1" placeholder="Tempat Lahir"
                                    value="{{ old('wali_lahir_tempat_1') ? strtoupper(old('wali_lahir_tempat_1')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_lahir_tempat_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_lahir_tgl_1" class="form-label">Tanggal Lahir</label>
                                <input type="date"
                                    class="form-control @error('wali_lahir_tgl_1') is-invalid @enderror"
                                    id="wali_lahir_tgl_1" name="wali_lahir_tgl_1"
                                    value="{{ old('wali_lahir_tgl_1') }}">
                                @error('wali_lahir_tgl_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_jenis_kelamin_1" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('wali_jenis_kelamin_1') is-invalid @enderror"
                                    id="wali_jenis_kelamin_1" name="wali_jenis_kelamin_1">
                                    <option value="L" {{ old('wali_jenis_kelamin_1') == 'L' ? 'selected' : '' }}
                                        selected>
                                        Laki-laki
                                    </option>
                                </select>
                                @error('wali_jenis_kelamin_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Agama --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_agama_1" class="form-label">Agama</label>
                                <select class="form-select @error('wali_agama_1') is-invalid @enderror" id="wali_agama_1"
                                    name="wali_agama_1">
                                    <option value="" disabled selected>Pilih Agama</option>
                                    <option value="1" {{ old('wali_agama_1') == '1' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="2" {{ old('wali_agama_1') == '2' ? 'selected' : '' }}>Kristen
                                    </option>
                                    <option value="3" {{ old('wali_agama_1') == '3' ? 'selected' : '' }}>Katholik
                                    </option>
                                    <option value="4" {{ old('wali_agama_1') == '4' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="5" {{ old('wali_agama_1') == '5' ? 'selected' : '' }}>Buddha
                                    </option>
                                    <option value="6" {{ old('wali_agama_1') == '6' ? 'selected' : '' }}>Konghuchu
                                    </option>
                                    <option value="99" {{ old('wali_agama_1') == '99' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('wali_agama_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Golongan Darah --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_golongan_darah_1" class="form-label">Golongan Darah</label>
                                <select class="form-select @error('wali_golongan_darah_1') is-invalid @enderror"
                                    id="wali_golongan_darah_1" name="wali_golongan_darah_1">
                                    <option value="" disabled selected>Pilih Golongan Darah</option>
                                    <option value="A" {{ old('wali_golongan_darah_1') == 'A' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="A+" {{ old('wali_golongan_darah_1') == 'A+' ? 'selected' : '' }}>
                                        A+
                                    </option>
                                    <option value="A-" {{ old('wali_golongan_darah_1') == 'A-' ? 'selected' : '' }}>
                                        A-
                                    </option>
                                    <option value="B" {{ old('wali_golongan_darah_1') == 'B' ? 'selected' : '' }}>B
                                    </option>
                                    <option value="B+" {{ old('wali_golongan_darah_1') == 'B+' ? 'selected' : '' }}>
                                        B+
                                    </option>
                                    <option value="B-" {{ old('wali_golongan_darah_1') == 'B-' ? 'selected' : '' }}>
                                        B-
                                    </option>
                                    <option value="AB" {{ old('wali_golongan_darah_1') == 'AB' ? 'selected' : '' }}>
                                        AB
                                    </option>
                                    <option value="AB+" {{ old('wali_golongan_darah_1') == 'AB+' ? 'selected' : '' }}>
                                        AB+
                                    </option>
                                    <option value="AB-" {{ old('wali_golongan_darah_1') == 'AB-' ? 'selected' : '' }}>
                                        AB-
                                    </option>
                                    <option value="O" {{ old('wali_golongan_darah_1') == 'O' ? 'selected' : '' }}>O
                                    </option>
                                    <option value="O+" {{ old('wali_golongan_darah_1') == 'O+' ? 'selected' : '' }}>
                                        O+
                                    </option>
                                    <option value="O-" {{ old('wali_golongan_darah_1') == 'O-' ? 'selected' : '' }}>
                                        O-
                                    </option>
                                </select>
                                @error('wali_golongan_darah_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Kewarganegaraan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_kewarganegaraan_1" class="form-label">Kewarganegaraan</label>
                                <select class="form-select @error('wali_kewarganegaraan_1') is-invalid @enderror"
                                    id="wali_kewarganegaraan_1" name="wali_kewarganegaraan_1">
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    <option value="ID" {{ old('wali_kewarganegaraan_1') == 'ID' ? 'selected' : '' }}>
                                        Indonesia</option>
                                    <option value="AS" {{ old('wali_kewarganegaraan_1') == 'AS' ? 'selected' : '' }}>
                                        Amerika
                                        Serikat</option>
                                    <option value="AU" {{ old('wali_kewarganegaraan_1') == 'AU' ? 'selected' : '' }}>
                                        Australia</option>
                                    <option value="CA" {{ old('wali_kewarganegaraan_1') == 'CA' ? 'selected' : '' }}>
                                        Canada
                                    </option>
                                    <option value="CN" {{ old('wali_kewarganegaraan_1') == 'CN' ? 'selected' : '' }}>
                                        China
                                    </option>
                                    <option value="JP" {{ old('wali_kewarganegaraan_1') == 'JP' ? 'selected' : '' }}>
                                        Jepang
                                    </option>
                                    <option value="MY" {{ old('wali_kewarganegaraan_1') == 'MY' ? 'selected' : '' }}>
                                        Malaysia</option>
                                    <option value="SG" {{ old('wali_kewarganegaraan_1') == 'SG' ? 'selected' : '' }}>
                                        Singapura</option>
                                </select>
                                @error('wali_kewarganegaraan_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                {{-- Form Wali Mahasiswa Ibu --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form Wali Mahasiswa Ibu</h3>
                        <div class="row">
                            {{-- Nama Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nama_2" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('wali_nama_2') is-invalid @enderror"
                                    id="wali_nama_2" name="wali_nama_2" placeholder="Nama Wali"
                                    value="{{ old('wali_nama_2') ? strtoupper(old('wali_nama_2')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_nama_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Hubungan --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_kewalian_2" class="form-label">Hubungan</label>
                                <input type="text"
                                    class="form-control @error('status_kewalian_2') is-invalid @enderror"
                                    id="status_kewalian_2" name="status_kewalian_2" value="IBU" disabled>
                                @error('status_kewalian_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- No HP Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_no_hp_2" class="form-label">No HP</label>
                                <input type="text" class="form-control @error('wali_no_hp_2') is-invalid @enderror"
                                    id="wali_no_hp_2" name="wali_no_hp_2" placeholder="No HP Wali"
                                    value="{{ old('wali_no_hp_2') }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('wali_no_hp_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat Domisili Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_domisili_2" class="form-label">Alamat Domisili</label>
                                <textarea class="form-control @error('wali_alamat_domisili_2') is-invalid @enderror" id="wali_alamat_domisili_2"
                                    name="wali_alamat_domisili_2" placeholder="Alamat Wali" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_domisili_2') }}</textarea>
                                @error('wali_alamat_domisili_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_pekerjaan_2" class="form-label">Pekerjaan</label>
                                <select class="form-select @error('wali_pekerjaan_2') is-invalid @enderror"
                                    id="wali_pekerjaan_2" name="wali_pekerjaan_2">
                                    <option value="" disabled selected>Pilih Pekerjaan</option>
                                    <option value="1" {{ old('wali_pekerjaan_2') == '1' ? 'selected' : '' }}>Tidak
                                        bekerja</option>
                                    <option value="2" {{ old('wali_pekerjaan_2') == '2' ? 'selected' : '' }}>Nelayan
                                    </option>
                                    <option value="3" {{ old('wali_pekerjaan_2') == '3' ? 'selected' : '' }}>Petani
                                    </option>
                                    <option value="4" {{ old('wali_pekerjaan_2') == '4' ? 'selected' : '' }}>
                                        Peternak</option>
                                    <option value="5" {{ old('wali_pekerjaan_2') == '5' ? 'selected' : '' }}>
                                        PNS/TNI/Polri</option>
                                    <option value="6" {{ old('wali_pekerjaan_2') == '6' ? 'selected' : '' }}>
                                        Karyawan Swasta</option>
                                    <option value="7" {{ old('wali_pekerjaan_2') == '7' ? 'selected' : '' }}>
                                        Pedagang Kecil</option>
                                    <option value="8" {{ old('wali_pekerjaan_2') == '8' ? 'selected' : '' }}>
                                        Pedagang Besar</option>
                                    <option value="9" {{ old('wali_pekerjaan_2') == '9' ? 'selected' : '' }}>
                                        Wiraswasta</option>
                                    <option value="10" {{ old('wali_pekerjaan_2') == '10' ? 'selected' : '' }}>
                                        Wirausaha</option>
                                    <option value="11" {{ old('wali_pekerjaan_2') == '11' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="12" {{ old('wali_pekerjaan_2') == '12' ? 'selected' : '' }}>
                                        Pensiunan</option>
                                    <option value="13" {{ old('wali_pekerjaan_2') == '13' ? 'selected' : '' }}>
                                        Peneliti</option>
                                    <option value="14" {{ old('wali_pekerjaan_2') == '14' ? 'selected' : '' }}>Tim
                                        Ahli / Konsultan</option>
                                    <option value="15" {{ old('wali_pekerjaan_2') == '15' ? 'selected' : '' }}>Magang
                                    </option>
                                    <option value="16" {{ old('wali_pekerjaan_2') == '16' ? 'selected' : '' }}>Tenaga
                                        Pengajar / Instruktur / Fasilitator</option>
                                    <option value="17" {{ old('wali_pekerjaan_2') == '17' ? 'selected' : '' }}>
                                        Pimpinan / Manajerial</option>
                                    <option value="98" {{ old('wali_pekerjaan_2') == '98' ? 'selected' : '' }}>Sudah
                                        Meninggal</option>
                                    <option value="99" {{ old('wali_pekerjaan_2') == '99' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('wali_pekerjaan_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Penghasilan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_penghasilan_2" class="form-label">Penghasilan</label>
                                <select class="form-select @error('wali_penghasilan_2') is-invalid @enderror"
                                    id="wali_penghasilan_2" name="wali_penghasilan_2">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="11" {{ old('wali_penghasilan_2') == '11' ? 'selected' : '' }}>
                                        Kurang dari Rp. 500,000</option>
                                    <option value="12" {{ old('wali_penghasilan_2') == '12' ? 'selected' : '' }}>
                                        Rp. 500,000 - Rp. 999,999
                                    </option>
                                    <option value="13" {{ old('wali_penghasilan_2') == '13' ? 'selected' : '' }}>
                                        Rp. 1,000,000 - Rp. 1,999,999
                                    </option>
                                    <option value="14" {{ old('wali_penghasilan_2') == '14' ? 'selected' : '' }}>
                                        Rp. 2,000,000 - Rp. 4,999,999
                                    </option>
                                    <option value="15" {{ old('wali_penghasilan_2') == '15' ? 'selected' : '' }}>
                                        Rp. 5,000,000 - Rp. 20,000,000
                                    </option>
                                    <option value="16" {{ old('wali_penghasilan_2') == '16' ? 'selected' : '' }}>
                                        Lebih dari Rp. 20,000,000
                                    </option>
                                </select>
                                @error('wali_penghasilan_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pendidikan Terakhir --}}
                            <div class="col-md-4 mb-3">
                                <label for="pendidikan_terakhir_2" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select @error('pendidikan_terakhir_2') is-invalid @enderror"
                                    id="pendidikan_terakhir_2" name="pendidikan_terakhir_2">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="0" {{ old('pendidikan_terakhir_2') == '0' ? 'selected' : '' }}>
                                        Tidak sekolah</option>
                                    <option value="1" {{ old('pendidikan_terakhir_2') == '1' ? 'selected' : '' }}>
                                        PAUD</option>
                                    <option value="2" {{ old('pendidikan_terakhir_2') == '2' ? 'selected' : '' }}>
                                        TK/ sederajat</option>
                                    <option value="3" {{ old('pendidikan_terakhir_2') == '3' ? 'selected' : '' }}>
                                        Putus SD</option>
                                    <option value="4" {{ old('pendidikan_terakhir_2') == '4' ? 'selected' : '' }}>SD
                                        / sederajat</option>
                                    <option value="5" {{ old('pendidikan_terakhir_2') == '5' ? 'selected' : '' }}>
                                        SMP / sederajat</option>
                                    <option value="6" {{ old('pendidikan_terakhir_2') == '6' ? 'selected' : '' }}>
                                        SMA / sederajat</option>
                                    <option value="7" {{ old('pendidikan_terakhir_2') == '7' ? 'selected' : '' }}>
                                        Paket A</option>
                                    <option value="8" {{ old('pendidikan_terakhir_2') == '8' ? 'selected' : '' }}>
                                        Paket B</option>
                                    <option value="9" {{ old('pendidikan_terakhir_2') == '9' ? 'selected' : '' }}>
                                        Paket C</option>
                                    <option value="20" {{ old('pendidikan_terakhir_2') == '20' ? 'selected' : '' }}>
                                        D1</option>
                                    <option value="21" {{ old('pendidikan_terakhir_2') == '21' ? 'selected' : '' }}>
                                        D2</option>
                                    <option value="22" {{ old('pendidikan_terakhir_2') == '22' ? 'selected' : '' }}>
                                        D3</option>
                                    <option value="23" {{ old('pendidikan_terakhir_2') == '23' ? 'selected' : '' }}>
                                        D4</option>
                                    <option value="30" {{ old('pendidikan_terakhir_2') == '30' ? 'selected' : '' }}>
                                        S1</option>
                                    <option value="31" {{ old('pendidikan_terakhir_2') == '31' ? 'selected' : '' }}>
                                        Profesi</option>
                                    <option value="32" {{ old('pendidikan_terakhir_2') == '32' ? 'selected' : '' }}>
                                        Sp-1</option>
                                    <option value="35" {{ old('pendidikan_terakhir_2') == '35' ? 'selected' : '' }}>
                                        S2</option>
                                    <option value="36" {{ old('pendidikan_terakhir_2') == '36' ? 'selected' : '' }}>
                                        S2 Terapan</option>
                                    <option value="37" {{ old('pendidikan_terakhir_2') == '37' ? 'selected' : '' }}>
                                        Sp-2</option>
                                    <option value="40" {{ old('pendidikan_terakhir_2') == '40' ? 'selected' : '' }}>
                                        S3</option>
                                    <option value="41" {{ old('pendidikan_terakhir_2') == '41' ? 'selected' : '' }}>
                                        S3 Terapan</option>
                                    <option value="90" {{ old('pendidikan_terakhir_2') == '90' ? 'selected' : '' }}>
                                        Non formal</option>
                                    <option value="91" {{ old('pendidikan_terakhir_2') == '91' ? 'selected' : '' }}>
                                        Informal</option>
                                    <option value="99" {{ old('pendidikan_terakhir_2') == '99' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('pendidikan_terakhir_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                {{-- Form KTP Wali Ibu --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form KTP Wali Ibu</h3>
                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nik_2" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('wali_nik_2') is-invalid @enderror"
                                    id="wali_nik_2" name="wali_nik_2" placeholder="NIK"
                                    value="{{ old('wali_nik_2') }}" maxlength="16"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                                @error('wali_nik_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_jalan_2" class="form-label">Alamat Jalan</label>
                                <textarea class="form-control @error('wali_alamat_jalan_2') is-invalid @enderror" id="wali_alamat_jalan_2"
                                    name="wali_alamat_jalan_2" placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_jalan_2') }}</textarea>
                                @error('wali_alamat_jalan_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- RT --}}
                            <div class="col-md-6 mb-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="wali_alamat_rt_2" class="form-label">RT</label>
                                        <input type="text"
                                            class="form-control @error('wali_alamat_rt_2') is-invalid @enderror"
                                            id="wali_alamat_rt_2" name="wali_alamat_rt_2" placeholder="000"
                                            value="{{ old('wali_alamat_rt_2') }}" maxlength="3"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                        @error('wali_alamat_rt_2')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- RW --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="wali_alamat_rw_2" class="form-label">RW</label>
                                        <input type="text"
                                            class="form-control @error('wali_alamat_rw_2') is-invalid @enderror"
                                            id="wali_alamat_rw_2" name="wali_alamat_rw_2" placeholder="000"
                                            value="{{ old('wali_alamat_rw_2') }}" maxlength="3"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                        @error('wali_alamat_rw_2')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Wali 2 Alamat Provinsi --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_prov_code_2" class="form-label">Provinsi (Wali 2)</label>
                                <select class="form-select @error('wali_alamat_prov_code_2') is-invalid @enderror"
                                    id="wali_alamat_prov_code_2" name="wali_alamat_prov_code_2">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('wali_alamat_prov_code_2', $data['wali_alamat_prov_code_2'] ?? '') == $province->code ? 'selected' : '' }}>
                                            {{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('wali_alamat_prov_code_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 2 Alamat Kota/Kabupaten --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_alamat_kotakab_code_2" class="form-label">Kota/Kabupaten (Wali 2)</label>
                                <select class="form-select @error('wali_alamat_kotakab_code_2') is-invalid @enderror"
                                    id="wali_alamat_kotakab_code_2" name="wali_alamat_kotakab_code_2">
                                    <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('wali_alamat_kotakab_code_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 2 Alamat Kecamatan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_alamat_kec_code_2" class="form-label">Kecamatan (Wali 2)</label>
                                <select class="form-select @error('wali_alamat_kec_code_2') is-invalid @enderror"
                                    id="wali_alamat_kec_code_2" name="wali_alamat_kec_code_2">
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('wali_alamat_kec_code_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 2 Alamat Kelurahan/Desa --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_alamat_kel_code_2" class="form-label">Kelurahan/Desa (Wali 2)</label>
                                <select class="form-select @error('wali_alamat_kel_code_2') is-invalid @enderror"
                                    id="wali_alamat_kel_code_2" name="wali_alamat_kel_code_2">
                                    <option value="" disabled selected>Pilih Kelurahan/Desa</option>
                                    {{-- Populated dynamically --}}
                                </select>
                                @error('wali_alamat_kel_code_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_lahir_tempat_2" class="form-label">Tempat Lahir</label>
                                <input type="text"
                                    class="form-control @error('wali_lahir_tempat_2') is-invalid @enderror"
                                    id="wali_lahir_tempat_2" name="wali_lahir_tempat_2" placeholder="Tempat Lahir"
                                    value="{{ old('wali_lahir_tempat_2') ? strtoupper(old('wali_lahir_tempat_2')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_lahir_tempat_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_lahir_tgl_2" class="form-label">Tanggal Lahir</label>
                                <input type="date"
                                    class="form-control @error('wali_lahir_tgl_2') is-invalid @enderror"
                                    id="wali_lahir_tgl_2" name="wali_lahir_tgl_2"
                                    value="{{ old('wali_lahir_tgl_2') }}">
                                @error('wali_lahir_tgl_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_jenis_kelamin_2" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('wali_jenis_kelamin_2') is-invalid @enderror"
                                    id="wali_jenis_kelamin_2" name="wali_jenis_kelamin_2">
                                    <option value="P" {{ old('wali_jenis_kelamin_2') == 'P' ? 'selected' : '' }}
                                        selected>
                                        Perempuan
                                    </option>
                                </select>
                                @error('wali_jenis_kelamin_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Agama --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_agama_2" class="form-label">Agama</label>
                                <select class="form-select @error('wali_agama_2') is-invalid @enderror" id="wali_agama_2"
                                    name="wali_agama_2">
                                    <option value="" disabled selected>Pilih Agama</option>
                                    <option value="1" {{ old('wali_agama_2') == '1' ? 'selected' : '' }}>Islam
                                    </option>
                                    <option value="2" {{ old('wali_agama_2') == '2' ? 'selected' : '' }}>Kristen
                                    </option>
                                    <option value="3" {{ old('wali_agama_2') == '3' ? 'selected' : '' }}>Katholik
                                    </option>
                                    <option value="4" {{ old('wali_agama_2') == '4' ? 'selected' : '' }}>Hindu
                                    </option>
                                    <option value="5" {{ old('wali_agama_2') == '5' ? 'selected' : '' }}>Buddha
                                    </option>
                                    <option value="6" {{ old('wali_agama_2') == '6' ? 'selected' : '' }}>Konghuchu
                                    </option>
                                    <option value="99" {{ old('wali_agama_2') == '99' ? 'selected' : '' }}>LAINNYA
                                    </option>
                                </select>
                                @error('wali_agama_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Golongan Darah --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_golongan_darah_2" class="form-label">Golongan Darah</label>
                                <select class="form-select @error('wali_golongan_darah_2') is-invalid @enderror"
                                    id="wali_golongan_darah_2" name="wali_golongan_darah_2">
                                    <option value="" disabled selected>Pilih Golongan Darah</option>
                                    <option value="A" {{ old('wali_golongan_darah_2') == 'A' ? 'selected' : '' }}>A
                                    </option>
                                    <option value="A+" {{ old('wali_golongan_darah_2') == 'A+' ? 'selected' : '' }}>
                                        A+
                                    </option>
                                    <option value="A-" {{ old('wali_golongan_darah_2') == 'A-' ? 'selected' : '' }}>
                                        A-
                                    </option>
                                    <option value="B" {{ old('wali_golongan_darah_2') == 'B' ? 'selected' : '' }}>B
                                    </option>
                                    <option value="B+" {{ old('wali_golongan_darah_2') == 'B+' ? 'selected' : '' }}>
                                        B+
                                    </option>
                                    <option value="B-" {{ old('wali_golongan_darah_2') == 'B-' ? 'selected' : '' }}>
                                        B-
                                    </option>
                                    <option value="AB" {{ old('wali_golongan_darah_2') == 'AB' ? 'selected' : '' }}>
                                        AB
                                    </option>
                                    <option value="AB+" {{ old('wali_golongan_darah_2') == 'AB+' ? 'selected' : '' }}>
                                        AB+
                                    </option>
                                    <option value="AB-" {{ old('wali_golongan_darah_2') == 'AB-' ? 'selected' : '' }}>
                                        AB-
                                    </option>
                                    <option value="O" {{ old('wali_golongan_darah_2') == 'O' ? 'selected' : '' }}>O
                                    </option>
                                    <option value="O+" {{ old('wali_golongan_darah_2') == 'O+' ? 'selected' : '' }}>
                                        O+
                                    </option>
                                    <option value="O-" {{ old('wali_golongan_darah_2') == 'O-' ? 'selected' : '' }}>
                                        O-
                                    </option>
                                </select>
                                @error('wali_golongan_darah_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Kewarganegaraan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_kewarganegaraan_2" class="form-label">Kewarganegaraan</label>
                                <select class="form-select @error('wali_kewarganegaraan_2') is-invalid @enderror"
                                    id="wali_kewarganegaraan_2" name="wali_kewarganegaraan_2">
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    <option value="ID" {{ old('wali_kewarganegaraan_2') == 'ID' ? 'selected' : '' }}>
                                        Indonesia</option>
                                    <option value="AS" {{ old('wali_kewarganegaraan_2') == 'AS' ? 'selected' : '' }}>
                                        Amerika
                                        Serikat</option>
                                    <option value="AU" {{ old('wali_kewarganegaraan_2') == 'AU' ? 'selected' : '' }}>
                                        Australia</option>
                                    <option value="CA" {{ old('wali_kewarganegaraan_2') == 'CA' ? 'selected' : '' }}>
                                        Canada
                                    </option>
                                    <option value="CN" {{ old('wali_kewarganegaraan_2') == 'CN' ? 'selected' : '' }}>
                                        China
                                    </option>
                                    <option value="JP" {{ old('wali_kewarganegaraan_2') == 'JP' ? 'selected' : '' }}>
                                        Jepang
                                    </option>
                                    <option value="MY" {{ old('wali_kewarganegaraan_2') == 'MY' ? 'selected' : '' }}>
                                        Malaysia</option>
                                    <option value="SG" {{ old('wali_kewarganegaraan_2') == 'SG' ? 'selected' : '' }}>
                                        Singapura</option>
                                </select>
                                @error('wali_kewarganegaraan_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="tab">
                {{-- Form Kontak Darurat --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form Kontak Darurat / WALI</h3>
                        <div class="row">
                            {{-- Nama Kontak Darurat --}}
                            <div class="col-md-6 mb-3">
                                <label for="kd_nama" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('kd_nama') is-invalid @enderror"
                                    id="kd_nama" name="kd_nama" placeholder="Nama Kontak Darurat"
                                    value="{{ old('kd_nama') ? strtoupper(old('kd_nama')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('kd_nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Hubungan Kontak Darurat --}}
                            <div class="col-md-6 mb-3">
                                <label for="kd_hubungan" class="form-label">Hubungan</label>
                                <input type="text" class="form-control @error('kd_hubungan') is-invalid @enderror"
                                    id="kd_hubungan" name="kd_hubungan" placeholder="Hubungan Kontak Darurat"
                                    value="{{ old('kd_hubungan') ? strtoupper(old('kd_hubungan')) : '' }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('kd_hubungan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- No HP Kontak Darurat --}}
                            <div class="col-md-6 mb-3">
                                <label for="kd_no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control @error('kd_no_hp') is-invalid @enderror"
                                    id="kd_no_hp" name="kd_no_hp" placeholder="No HP Kontak Darurat"
                                    value="{{ old('kd_no_hp') }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('kd_no_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir Kontak Darurat --}}
                            <div class="col-md-6 mb-3">
                                <label for="kd_tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('kd_tgl_lahir') is-invalid @enderror"
                                    id="kd_tgl_lahir" name="kd_tgl_lahir" value="{{ old('kd_tgl_lahir') }}">
                                @error('kd_tgl_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="kd_pekerjaan" class="form-label">Pekerjaan</label>
                                <select class="form-select @error('kd_pekerjaan') is-invalid @enderror"
                                    id="kd_pekerjaan" name="kd_pekerjaan">
                                    <option value="" disabled selected>Pilih Pekerjaan</option>
                                    <option value="1" {{ old('kd_pekerjaan') == '1' ? 'selected' : '' }}>Tidak
                                        bekerja</option>
                                    <option value="2" {{ old('kd_pekerjaan') == '2' ? 'selected' : '' }}>Nelayan
                                    </option>
                                    <option value="3" {{ old('kd_pekerjaan') == '3' ? 'selected' : '' }}>Petani
                                    </option>
                                    <option value="4" {{ old('kd_pekerjaan') == '4' ? 'selected' : '' }}>
                                        Peternak</option>
                                    <option value="5" {{ old('kd_pekerjaan') == '5' ? 'selected' : '' }}>
                                        PNS/TNI/Polri</option>
                                    <option value="6" {{ old('kd_pekerjaan') == '6' ? 'selected' : '' }}>
                                        Karyawan Swasta</option>
                                    <option value="7" {{ old('kd_pekerjaan') == '7' ? 'selected' : '' }}>
                                        Pedagang Kecil</option>
                                    <option value="8" {{ old('kd_pekerjaan') == '8' ? 'selected' : '' }}>
                                        Pedagang Besar</option>
                                    <option value="9" {{ old('kd_pekerjaan') == '9' ? 'selected' : '' }}>
                                        Wiraswasta</option>
                                    <option value="10" {{ old('kd_pekerjaan') == '10' ? 'selected' : '' }}>
                                        Wirausaha</option>
                                    <option value="11" {{ old('kd_pekerjaan') == '11' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="12" {{ old('kd_pekerjaan') == '12' ? 'selected' : '' }}>
                                        Pensiunan</option>
                                    <option value="13" {{ old('kd_pekerjaan') == '13' ? 'selected' : '' }}>
                                        Peneliti</option>
                                    <option value="14" {{ old('kd_pekerjaan') == '14' ? 'selected' : '' }}>Tim
                                        Ahli / Konsultan</option>
                                    <option value="15" {{ old('kd_pekerjaan') == '15' ? 'selected' : '' }}>Magang
                                    </option>
                                    <option value="16" {{ old('kd_pekerjaan') == '16' ? 'selected' : '' }}>Tenaga
                                        Pengajar / Instruktur / Fasilitator</option>
                                    <option value="17" {{ old('kd_pekerjaan') == '17' ? 'selected' : '' }}>
                                        Pimpinan / Manajerial</option>
                                    <option value="98" {{ old('kd_pekerjaan') == '98' ? 'selected' : '' }}>Sudah
                                        Meninggal</option>
                                    <option value="99" {{ old('kd_pekerjaan') == '99' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('kd_pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Penghasilan --}}
                            <div class="col-md-4 mb-3">
                                <label for="kd_penghasilan" class="form-label">Penghasilan</label>
                                <select class="form-select @error('kd_penghasilan') is-invalid @enderror"
                                    id="kd_penghasilan" name="kd_penghasilan">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="11" {{ old('kd_penghasilan') == '11' ? 'selected' : '' }}>
                                        Kurang dari Rp. 500,000</option>
                                    <option value="12" {{ old('kd_penghasilan') == '12' ? 'selected' : '' }}>
                                        Rp. 500,000 - Rp. 999,999
                                    </option>
                                    <option value="13" {{ old('kd_penghasilan') == '13' ? 'selected' : '' }}>
                                        Rp. 1,000,000 - Rp. 1,999,999
                                    </option>
                                    <option value="14" {{ old('kd_penghasilan') == '14' ? 'selected' : '' }}>
                                        Rp. 2,000,000 - Rp. 4,999,999
                                    </option>
                                    <option value="15" {{ old('kd_penghasilan') == '15' ? 'selected' : '' }}>
                                        Rp. 5,000,000 - Rp. 20,000,000
                                    </option>
                                    <option value="16" {{ old('kd_penghasilan') == '16' ? 'selected' : '' }}>
                                        Lebih dari Rp. 20,000,000
                                    </option>
                                </select>
                                @error('kd_penghasilan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pendidikan Terakhir --}}
                            <div class="col-md-4 mb-3">
                                <label for="kd_pendidikan" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-select @error('kd_pendidikan') is-invalid @enderror"
                                    id="kd_pendidikan" name="kd_pendidikan">
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    <option value="0" {{ old('kd_pendidikan') == '0' ? 'selected' : '' }}>
                                        Tidak sekolah</option>
                                    <option value="1" {{ old('kd_pendidikan') == '1' ? 'selected' : '' }}>
                                        PAUD</option>
                                    <option value="2" {{ old('kd_pendidikan') == '2' ? 'selected' : '' }}>
                                        TK/ sederajat</option>
                                    <option value="3" {{ old('kd_pendidikan') == '3' ? 'selected' : '' }}>
                                        Putus SD</option>
                                    <option value="4" {{ old('kd_pendidikan') == '4' ? 'selected' : '' }}>SD
                                        / sederajat</option>
                                    <option value="5" {{ old('kd_pendidikan') == '5' ? 'selected' : '' }}>
                                        SMP / sederajat</option>
                                    <option value="6" {{ old('kd_pendidikan') == '6' ? 'selected' : '' }}>
                                        SMA / sederajat</option>
                                    <option value="7" {{ old('kd_pendidikan') == '7' ? 'selected' : '' }}>
                                        Paket A</option>
                                    <option value="8" {{ old('kd_pendidikan') == '8' ? 'selected' : '' }}>
                                        Paket B</option>
                                    <option value="9" {{ old('kd_pendidikan') == '9' ? 'selected' : '' }}>
                                        Paket C</option>
                                    <option value="20" {{ old('kd_pendidikan') == '20' ? 'selected' : '' }}>
                                        D1</option>
                                    <option value="21" {{ old('kd_pendidikan') == '21' ? 'selected' : '' }}>
                                        D2</option>
                                    <option value="22" {{ old('kd_pendidikan') == '22' ? 'selected' : '' }}>
                                        D3</option>
                                    <option value="23" {{ old('kd_pendidikan') == '23' ? 'selected' : '' }}>
                                        D4</option>
                                    <option value="30" {{ old('kd_pendidikan') == '30' ? 'selected' : '' }}>
                                        S1</option>
                                    <option value="31" {{ old('kd_pendidikan') == '31' ? 'selected' : '' }}>
                                        Profesi</option>
                                    <option value="32" {{ old('kd_pendidikan') == '32' ? 'selected' : '' }}>
                                        Sp-1</option>
                                    <option value="35" {{ old('kd_pendidikan') == '35' ? 'selected' : '' }}>
                                        S2</option>
                                    <option value="36" {{ old('kd_pendidikan') == '36' ? 'selected' : '' }}>
                                        S2 Terapan</option>
                                    <option value="37" {{ old('kd_pendidikan') == '37' ? 'selected' : '' }}>
                                        Sp-2</option>
                                    <option value="40" {{ old('kd_pendidikan') == '40' ? 'selected' : '' }}>
                                        S3</option>
                                    <option value="41" {{ old('kd_pendidikan') == '41' ? 'selected' : '' }}>
                                        S3 Terapan</option>
                                    <option value="90" {{ old('kd_pendidikan') == '90' ? 'selected' : '' }}>
                                        Non formal</option>
                                    <option value="91" {{ old('kd_pendidikan') == '91' ? 'selected' : '' }}>
                                        Informal</option>
                                    <option value="99" {{ old('kd_pendidikan') == '99' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                @error('kd_pendidikan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="tab">
                {{-- Form Kebutuhan Khusus --}}
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Form Kebutuhan Khusus</h3>
                        <div class="row">
                            <!-- Pilihan Dropdown -->
                            <div class="col-md-12 mb-3">
                                <label for="kebutuhan_khusus_pertanyaan">Pilihan :</label>
                                <select id="kebutuhan_khusus_pertanyaan" class="form-control @error('kebutuhan_khusus_pertanyaan') is-invalid @enderror"
                                    name="kebutuhan_khusus_pertanyaan" onchange="toggleKebutuhanKhusus(this.value)">
                                    <option value="0" {{ old('kebutuhan_khusus_pertanyaan') == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1" {{ old('kebutuhan_khusus_pertanyaan') == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                                @error('kebutuhan_khusus_pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="kebutuhan_khusus_section" style="display:none;" class="col-md-12 mb-3">
                                <div class="row">
                                    <!-- Kebutuhan Khusus Mahasiswa -->
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header bg-primary text-white">
                                                <i data-feather="user"></i> MAHASISWA
                                            </div>
                                            <div class="card-body">
                                                @foreach (['1' => 'A - Tuna Netra', '2' => 'B - Tuna Rungu', '3' => 'C - Tuna Grahita Ringan', '4' => 'C1 - Tuna Grahita Sedang', '5' => 'D - Tuna Daksa Ringan', '6' => 'D1 - Tuna Daksa Sedang'] as $key => $value)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="kebutuhan_khusus_mahasiswa"
                                                            name="kebutuhan_khusus_mahasiswa[]"
                                                            value="{{ $key }}"
                                                            {{ in_array($key, old('kebutuhan_khusus_mahasiswa', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kebutuhan_khusus_mahasiswa_{{ $key }}">{{ $value }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kebutuhan Khusus Ayah -->
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header bg-success text-white">
                                                <i data-feather="user"></i> AYAH
                                            </div>
                                            <div class="card-body">
                                                @foreach (['1' => 'A - Tuna Netra', '2' => 'B - Tuna Rungu', '3' => 'C - Tuna Grahita Ringan', '4' => 'C1 - Tuna Grahita Sedang', '5' => 'D - Tuna Daksa Ringan', '6' => 'D1 - Tuna Daksa Sedang'] as $key => $value)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="kebutuhan_khusus_ayah"
                                                            name="kebutuhan_khusus_ayah[]"
                                                            value="{{ $key }}"
                                                            {{ in_array($key, old('kebutuhan_khusus_ayah', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kebutuhan_khusus_ayah_{{ $key }}">{{ $value }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kebutuhan Khusus Ibu -->
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header bg-secondary text-white">
                                                <i data-feather="user"></i> IBU
                                            </div>
                                            <div class="card-body">
                                                @foreach (['1' => 'A - Tuna Netra', '2' => 'B - Tuna Rungu', '3' => 'C - Tuna Grahita Ringan', '4' => 'C1 - Tuna Grahita Sedang', '5' => 'D - Tuna Daksa Ringan', '6' => 'D1 - Tuna Daksa Sedang'] as $key => $value)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="kebutuhan_khusus_ibu"
                                                            name="kebutuhan_khusus_ibu[]" value="{{ $key }}"
                                                            {{ in_array($key, old('kebutuhan_khusus_ibu', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kebutuhan_khusus_ibu_{{ $key }}">{{ $value }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-buttons mt-4">
                <button type="button" class="btn btn-secondary" id="backBtn"
                    onclick="window.location.href='{{ route('mahasiswa.index') }}'"
                    style="display: none;">Kembali</button>
                <button type="button" class="btn btn-secondary" id="prevBtn"
                    onclick="nextPrev(-1)">Sebelumnya</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Selanjutnya</button>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-icon {
            background-color: #e9ecef;
            color: #364b98;
            border-radius: 50%;
            padding: 10px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .step-title {
            margin-top: 5px;
        }

        .step::after {
            content: '';
            position: absolute;
            top: 15px;
            width: 100%;
            height: 2px;
            background-color: #e9ecef;
            z-index: -1;
            left: 50%;
            transform: translateX(-50%);
        }

        .step.active::after {
            background-color: #364b98;
        }

        .step.active .step-icon {
            background-color: #364b98;
            color: #fff;
        }

        .step.completed::after {
            background-color: #364b98;
        }

        .step.completed .step-icon {
            background-color: #364b98;
            color: #fff;
        }

        .tab {
            display: none;
        }

        .tab.active {
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            function populateOptions(selector, data, selectedValue) {
                $(selector).empty().append('<option value="">Pilih</option>');
                $.each(data, function(key, value) {
                    $(selector).append('<option value="' + value.code + '"' +
                        (value.code === selectedValue ? ' selected' : '') + '>' + value.name +
                        '</option>');
                });
                $(selector).prop('disabled', false);
            }

            function loadCities(provinceCode, selectedCity, selector) {
                $.ajax({
                    url: '/mahasiswa/cities/' + provinceCode,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        populateOptions(selector, data, selectedCity);
                    }
                });
            }

            function loadDistricts(cityCode, selectedDistrict, selector) {
                $.ajax({
                    url: '/mahasiswa/districts/' + cityCode,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        populateOptions(selector, data, selectedDistrict);
                    }
                });
            }

            function loadVillages(districtCode, selectedVillage, selector) {
                $.ajax({
                    url: '/mahasiswa/villages/' + districtCode,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        populateOptions(selector, data, selectedVillage);
                    }
                });
            }

            function initSelects(provCode, cityCode, distCode, villageCode, prefix, prefix2) {
                if (provCode) {
                    loadCities(provCode, cityCode, `#${prefix}_kotakab_code${prefix2}`);
                    if (cityCode) {
                        loadDistricts(cityCode, distCode, `#${prefix}_kec_code${prefix2}`);
                        if (distCode) {
                            loadVillages(distCode, villageCode, `#${prefix}_kel_code${prefix2}`);
                        }
                    }
                }
            }

            // Load data for existing values if available
            @if (old('alamat_prov_code'))
                var provCode = '{{ old('alamat_prov_code') }}';
                var cityCode = '{{ old('alamat_kotakab_code') }}';
                var distCode = '{{ old('alamat_kec_code') }}';
                var villageCode = '{{ old('alamat_kel_code') }}';
                initSelects(provCode, cityCode, distCode, villageCode, 'alamat', '');
            @endif

            @if (old('wali_alamat_prov_code_1'))
                var waliProvCode1 = '{{ old('wali_alamat_prov_code_1') }}';
                var waliCityCode1 = '{{ old('wali_alamat_kotakab_code_1') }}';
                var waliDistCode1 = '{{ old('wali_alamat_kec_code_1') }}';
                var waliVillageCode1 = '{{ old('wali_alamat_kel_code_1') }}';
                initSelects(waliProvCode1, waliCityCode1, waliDistCode1, waliVillageCode1, 'wali_alamat', '_1');
            @endif

            @if (old('wali_alamat_prov_code_2'))
                var waliProvCode2 = '{{ old('wali_alamat_prov_code_2') }}';
                var waliCityCode2 = '{{ old('wali_alamat_kotakab_code_2') }}';
                var waliDistCode2 = '{{ old('wali_alamat_kec_code_2') }}';
                var waliVillageCode2 = '{{ old('wali_alamat_kel_code_2') }}';
                initSelects(waliProvCode2, waliCityCode2, waliDistCode2, waliVillageCode2, 'wali_alamat', '_2');
            @endif

            $('#alamat_prov_code').on('change', function() {
                var provinceCode = $(this).val();
                loadCities(provinceCode, '', '#alamat_kotakab_code');
            });

            $('#alamat_kotakab_code').on('change', function() {
                var cityCode = $(this).val();
                loadDistricts(cityCode, '', '#alamat_kec_code');
            });

            $('#alamat_kec_code').on('change', function() {
                var districtCode = $(this).val();
                loadVillages(districtCode, '', '#alamat_kel_code');
            });

            // For Wali 1
            $('#wali_alamat_prov_code_1').on('change', function() {
                var provinceCode = $(this).val();
                loadCities(provinceCode, '', '#wali_alamat_kotakab_code_1');
            });

            $('#wali_alamat_kotakab_code_1').on('change', function() {
                var cityCode = $(this).val();
                loadDistricts(cityCode, '', '#wali_alamat_kec_code_1');
            });

            $('#wali_alamat_kec_code_1').on('change', function() {
                var districtCode = $(this).val();
                loadVillages(districtCode, '', '#wali_alamat_kel_code_1');
            });

            // For Wali 2
            $('#wali_alamat_prov_code_2').on('change', function() {
                var provinceCode = $(this).val();
                loadCities(provinceCode, '', '#wali_alamat_kotakab_code_2');
            });

            $('#wali_alamat_kotakab_code_2').on('change', function() {
                var cityCode = $(this).val();
                loadDistricts(cityCode, '', '#wali_alamat_kec_code_2');
            });

            $('#wali_alamat_kec_code_2').on('change', function() {
                var districtCode = $(this).val();
                loadVillages(districtCode, '', '#wali_alamat_kel_code_2');
            });
        });
    </script>

    <script>
        var currentTab = 0;
        showTab(currentTab);

        function showTab(n) {
            var tabs = document.getElementsByClassName("tab");
            var steps = document.getElementsByClassName("step");

            // Hide all tabs
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = "none";
            }

            // Remove active class from all steps
            for (var i = 0; i < steps.length; i++) {
                steps[i].classList.remove("active");
            }

            // Show the current tab
            tabs[n].style.display = "block";

            // Add active class to the current step
            steps[n].classList.add("active");

            // Update progress indicator
            if (n == 0) {
                steps[0].classList.remove("completed");
                steps[1].classList.remove("completed");
                steps[2].classList.remove("completed");
                steps[3].classList.remove("completed");
            }

            if (n == 1) {
                steps[0].classList.add("completed");
                steps[2].classList.remove("completed");
                steps[3].classList.remove("completed");
            }

            if (n == 2) {
                steps[0].classList.add("completed");
                steps[1].classList.add("completed");
                steps[3].classList.remove("completed");
            }

            if (n == 3) {
                steps[0].classList.add("completed");
                steps[1].classList.add("completed");
                steps[2].classList.add("completed");
            }

            // Update navigation buttons
            if (n == 0) {
                document.getElementById("backBtn").style.display = "inline";
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("backBtn").style.display = "none";
                document.getElementById("prevBtn").style.display = "inline";
            }

            document.getElementById("nextBtn").style.display = n == (tabs.length - 1) ? "none" : "inline";
            document.getElementById("submitBtn").style.display = n == (tabs.length - 1) ? "inline" : "none";
        }

        function nextPrev(n) {
            var tabs = document.getElementsByClassName("tab");

            // Validate the current form
            // if (n == 1 && !validateForm()) return false;

            // Hide the current tab
            tabs[currentTab].style.display = "none";

            // Move to the next or previous tab
            currentTab = currentTab + n;

            // If at the end, submit the form
            if (currentTab >= tabs.length) {
                document.getElementById("formWizard").submit();
                return false;
            }

            // Show the new tab
            showTab(currentTab);
        }

        // function validateForm() {
        //     var x, y, i, valid = true;
        //     x = document.getElementsByClassName("tab");
        //     y = x[currentTab].getElementsByTagName("input");
        //     for (i = 0; i < y.length; i++) {
        //     // Skip validation for NPWP input
        //     if (y[i].id === "npwp" || y[i].id === "no_kps") continue;

        //     if (y[i].value == "") {
        //         y[i].className += " is-invalid";
        //         valid = false;
        //     } else {
        //         y[i].classList.remove("is-invalid");
        //     }
        //     }
        //     return valid;
        // }
    </script>

    <script>
        document.getElementById('email').addEventListener('input', function() {
            const emailInput = this;

            // Periksa apakah input kosong
            if (emailInput.value === '') {
                emailInput.classList.remove('is-valid', 'is-invalid');
            } else if (emailInput.checkValidity()) {
                // Validasi jika input tidak kosong dan valid
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
            } else {
                // Jika input tidak valid
                emailInput.classList.remove('is-valid');
                emailInput.classList.add('is-invalid');
            }
        });

        function toggleNoKPSInput() {
            var terimaKps = document.getElementById('terima_kps').value;
            var noKpsWrapper = document.getElementById('no_kps_wrapper');

            if (terimaKps == '1') {
                noKpsWrapper.style.display = 'block'; // Tampilkan input No KPS
            } else {
                noKpsWrapper.style.display = 'none'; // Sembunyikan input No KPS
            }
        }

        // Panggil fungsi saat halaman dimuat agar tetap mempertahankan nilai lama (old input)
        window.onload = function() {
            toggleNoKPSInput();
        };

        function toggleKebutuhanKhusus(value) {
            var section = document.getElementById('kebutuhan_khusus_section');
            section.style.display = (value === '1') ? 'block' : 'none';
        }
    </script>

    {{-- Toast --}}
    @if (session('toast_message'))
        <script>
            Swal.fire({
                icon: 'error',
                text: "{{ session('toast_message') }}",
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
@endpush
