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
                                    @foreach ($jenisTinggal['data'] as $jt)
                                        <option value="{{ $jt['id_jenis_tinggal'] }}"
                                            {{ old('jenis_tinggal') == $jt['id_jenis_tinggal'] ? 'selected' : '' }}>
                                            {{ $jt['nama_jenis_tinggal'] }}
                                        </option>
                                    @endforeach
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
                                    @foreach ($alatTransportasi['data'] as $transportasi)
                                        <option value="{{ $transportasi['id_alat_transportasi'] }}">
                                            {{ $transportasi['nama_alat_transportasi'] }}
                                        </option>
                                    @endforeach
                                    @foreach ($alatTransportasi['data'] as $at)
                                        <option value="{{ $at['id_alat_transportasi'] }}"
                                            {{ old('alat_transportasi') == $at['id_alat_transportasi'] ? 'selected' : '' }}>
                                            {{ $at['nama_alat_transportasi'] }}
                                        </option>
                                    @endforeach
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
                            <div class="col-md-4 mb-3">
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
                            <div class="col-md-4 mb-3">
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

                            {{-- Dusun --}}
                            <div class="col-md-4 mb-3">
                                <label for="alamat_dusun" class="form-label">Dusun</label>
                                <input type="text" class="form-control @error('alamat_dusun') is-invalid @enderror"
                                    id="alamat_dusun" name="alamat_dusun" placeholder="Nama Dusun"
                                    value="{{ old('alamat_dusun') }}" oninput="this.value = this.value.toUpperCase()">
                                @error('alamat_dusun')
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
                                    @foreach ($agama['data'] as $ag)
                                        <option value="{{ $ag['id_agama'] }}"
                                            {{ old('agama') == $ag['id_agama'] ? 'selected' : '' }}>
                                            {{ $ag['nama_agama'] }}
                                        </option>
                                    @endforeach
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
                                <select
                                    class="js-example-basic-single form-select @error('kewarganegaraan') is-invalid @enderror"
                                    id="kewarganegaraan" name="kewarganegaraan" data-width="100%">
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    @foreach ($negara['data'] as $ng)
                                        <option value="{{ $ng['id_negara'] }}"
                                            {{ old('kewarganegaraan') == $ng['id_negara'] ? 'selected' : '' }}>
                                            {{ $ng['nama_negara'] }}
                                        </option>
                                    @endforeach
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
                {{-- Form Status Kehidupan --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Status Kehidupan</h5>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="status_kehidupan_ayah">Status Kehidupan Ayah</label>
                                <select class="form-select @error('status_kehidupan_ayah') is-invalid @enderror"
                                    id="status_kehidupan_ayah" name="status_kehidupan_ayah" onchange="toggleFormsAyah()">
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="hidup"
                                        {{ old('status_kehidupan_ayah') == 'hidup' ? 'selected' : '' }}>Masih Hidup
                                    </option>
                                    <option value="meninggal"
                                        {{ old('status_kehidupan_ayah') == 'meninggal' ? 'selected' : '' }}>Sudah
                                        Meninggal</option>
                                </select>
                                @error('status_kehidupan_ayah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="status_kehidupan_ibu">Status Kehidupan Ibu</label>
                                <select class="form-select @error('status_kehidupan_ibu') is-invalid @enderror"
                                    id="status_kehidupan_ibu" name="status_kehidupan_ibu" onchange="toggleFormsIbu()">
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="hidup" {{ old('status_kehidupan_ibu') == 'hidup' ? 'selected' : '' }}>
                                        Masih Hidup
                                    </option>
                                    <option value="meninggal"
                                        {{ old('status_kehidupan_ibu') == 'meninggal' ? 'selected' : '' }}>Sudah Meninggal
                                    </option>
                                </select>
                                @error('status_kehidupan_ibu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <br id="br_status" style="display: none;">

                {{-- Form Wali Mahasiswa Ayah --}}
                <div class="card" id="form_wali_ayah" style="display: none;">
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
                                    @foreach ($pekerjaan['data'] as $pk)
                                        <option value="{{ $pk['id_pekerjaan'] }}"
                                            {{ old('wali_pekerjaan_1') == $pk['id_pekerjaan'] ? 'selected' : '' }}>
                                            {{ $pk['nama_pekerjaan'] }}
                                        </option>
                                    @endforeach
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
                                    <option value="" disabled selected>Pilih Penghasilan</option>
                                    @foreach ($penghasilan['data'] as $ph)
                                        <option value="{{ $ph['id_penghasilan'] }}"
                                            {{ old('wali_penghasilan_1') == $ph['id_penghasilan'] ? 'selected' : '' }}>
                                            {{ $ph['nama_penghasilan'] }}
                                        </option>
                                    @endforeach
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
                                <select
                                    class="js-example-basic-single form-select @error('pendidikan_terakhir_1') is-invalid @enderror"
                                    id="pendidikan_terakhir_1" name="pendidikan_terakhir_1" data-width="100%">
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    @foreach ($jenjangPendidikan['data'] as $jp)
                                        <option value="{{ $jp['id_jenjang_didik'] }}"
                                            {{ old('pendidikan_terakhir_1') == $jp['id_jenjang_didik'] ? 'selected' : '' }}>
                                            {{ $jp['nama_jenjang_didik'] }}
                                        </option>
                                    @endforeach
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

                <br id="br_wali_ayah" style="display: none;">

                {{-- Form KTP Wali Ayah --}}
                <div class="card" id="form_ktp_ayah" style="display: none;">
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
                                <label for="wali_alamat_prov_code_1" class="form-label">Provinsi</label>
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
                                <label for="wali_alamat_kotakab_code_1" class="form-label">Kota/Kabupaten</label>
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
                                <label for="wali_alamat_kec_code_1" class="form-label">Kecamatan</label>
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
                                <label for="wali_alamat_kel_code_1" class="form-label">Kelurahan/Desa</label>
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
                                    @foreach ($agama['data'] as $ag)
                                        <option value="{{ $ag['id_agama'] }}"
                                            {{ old('wali_agama_1') == $ag['id_agama'] ? 'selected' : '' }}>
                                            {{ $ag['nama_agama'] }}
                                        </option>
                                    @endforeach
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
                                <select
                                    class="js-example-basic-single form-select @error('wali_kewarganegaraan_1') is-invalid @enderror"
                                    id="wali_kewarganegaraan_1" name="wali_kewarganegaraan_1" data-width="100%">
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    @foreach ($negara['data'] as $ng)
                                        <option value="{{ $ng['id_negara'] }}"
                                            {{ old('wali_kewarganegaraan_1') == $ng['id_negara'] ? 'selected' : '' }}>
                                            {{ $ng['nama_negara'] }}
                                        </option>
                                    @endforeach
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

                <br id="br_ktp_ayah" style="display: none;">

                {{-- Form Wali Mahasiswa Ibu --}}
                <div class="card" id="form_wali_ibu" style="display: none;">
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
                                    @foreach ($pekerjaan['data'] as $pk)
                                        <option value="{{ $pk['id_pekerjaan'] }}"
                                            {{ old('wali_pekerjaan_2') == $pk['id_pekerjaan'] ? 'selected' : '' }}>
                                            {{ $pk['nama_pekerjaan'] }}
                                        </option>
                                    @endforeach
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
                                    @foreach ($penghasilan['data'] as $ph)
                                        <option value="{{ $ph['id_penghasilan'] }}"
                                            {{ old('wali_penghasilan_2') == $ph['id_penghasilan'] ? 'selected' : '' }}>
                                            {{ $ph['nama_penghasilan'] }}
                                        </option>
                                    @endforeach
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
                                <select class="js-example-basic-single form-select @error('pendidikan_terakhir_2') is-invalid @enderror"
                                    id="pendidikan_terakhir_2" name="pendidikan_terakhir_2" data-width="100%">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    @foreach ($jenjangPendidikan['data'] as $jp)
                                    <option value="{{ $jp['id_jenjang_didik'] }}"
                                        {{ old('pendidikan_terakhir_2') == $jp['id_jenjang_didik'] ? 'selected' : '' }}>
                                        {{ $jp['nama_jenjang_didik'] }}
                                    </option>
                                @endforeach
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

                {{-- Form Wali Mahasiswa Ibu Meninggal --}}
                <div class="card" id="form_wali_ibu_meninggal" style="display: none;">
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
                        </div>
                    </div>
                </div>

                <br id="br_wali_ibu" style="display: none;">

                {{-- Form KTP Wali Ibu --}}
                <div class="card" id="form_ktp_ibu" style="display: none;">
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
                                <label for="wali_alamat_prov_code_2" class="form-label">Provinsi</label>
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
                                <label for="wali_alamat_kotakab_code_2" class="form-label">Kota/Kabupaten</label>
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
                                <label for="wali_alamat_kec_code_2" class="form-label">Kecamatan</label>
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
                                <label for="wali_alamat_kel_code_2" class="form-label">Kelurahan/Desa</label>
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
                                    @foreach ($agama['data'] as $ag)
                                        <option value="{{ $ag['id_agama'] }}"
                                            {{ old('wali_agama_2') == $ag['id_agama'] ? 'selected' : '' }}>
                                            {{ $ag['nama_agama'] }}
                                        </option>
                                    @endforeach
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
                                <select class="js-example-basic-single form-select @error('wali_kewarganegaraan_2') is-invalid @enderror"
                                    id="wali_kewarganegaraan_2" name="wali_kewarganegaraan_2" data-width="100%">
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    @foreach ($negara['data'] as $ng)
                                        <option value="{{ $ng['id_negara'] }}"
                                            {{ old('wali_kewarganegaraan_2') == $ng['id_negara'] ? 'selected' : '' }}>
                                            {{ $ng['nama_negara'] }}
                                        </option>
                                    @endforeach
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
                                    @foreach ($pekerjaan['data'] as $pk)
                                        <option value="{{ $pk['id_pekerjaan'] }}"
                                            {{ old('kd_pekerjaan') == $pk['id_pekerjaan'] ? 'selected' : '' }}>
                                            {{ $pk['nama_pekerjaan'] }}
                                        </option>
                                    @endforeach
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
                                    @foreach ($penghasilan['data'] as $ph)
                                        <option value="{{ $ph['id_penghasilan'] }}"
                                            {{ old('kd_penghasilan') == $ph['id_penghasilan'] ? 'selected' : '' }}>
                                            {{ $ph['nama_penghasilan'] }}
                                        </option>
                                    @endforeach
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
                                <select class="js-example-basic-single form-select @error('kd_pendidikan') is-invalid @enderror"
                                    id="kd_pendidikan" name="kd_pendidikan" data-width="100%">
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    @foreach ($jenjangPendidikan['data'] as $jp)
                                        <option value="{{ $jp['id_jenjang_didik'] }}"
                                            {{ old('kd_pendidikan') == $jp['id_jenjang_didik'] ? 'selected' : '' }}>
                                            {{ $jp['nama_jenjang_didik'] }}
                                        </option>
                                    @endforeach
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
                                <label class="form-label" for="kebutuhan_khusus_pertanyaan">Pilihan :</label>
                                <select class="form-select" id="kebutuhan_khusus_pertanyaan"
                                    class="form-control @error('kebutuhan_khusus_pertanyaan') is-invalid @enderror"
                                    name="kebutuhan_khusus_pertanyaan" onchange="toggleKebutuhanKhusus(this.value)">
                                    <option value="0"
                                        {{ old('kebutuhan_khusus_pertanyaan') == '0' ? 'selected' : '' }}>Tidak</option>
                                    <option value="1"
                                        {{ old('kebutuhan_khusus_pertanyaan') == '1' ? 'selected' : '' }}>Ya</option>
                                </select>
                                @error('kebutuhan_khusus_pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="kebutuhan_khusus_section" style="display:none;" class="col-md-12 mb-3">
                                <div class="row">
                                    <!-- Loop untuk setiap kategori kebutuhan khusus -->
                                    @foreach (['mahasiswa' => 'MAHASISWA', 'ayah' => 'AYAH', 'ibu' => 'IBU'] as $key => $label)
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header bg-{{ $key == 'mahasiswa' ? 'primary' : ($key == 'ayah' ? 'success' : 'secondary') }} text-white">
                                                    <i data-feather="user"></i> {{ strtoupper($label) }}
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($kebutuhanKhususOptions as $optionKey => $optionValue)
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input kebutuhan-khusus" 
                                                                   type="checkbox" 
                                                                   id="kebutuhan_khusus_{{ $key }}_{{ $optionKey }}" 
                                                                   name="kebutuhan_khusus_{{ $key }}[]" 
                                                                   value="{{ $optionValue }}" 
                                                                   {{ in_array($optionValue, old("kebutuhan_khusus_$key", [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="kebutuhan_khusus_{{ $key }}_{{ $optionKey }}">{{ $optionValue }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
                <button type="button" class="btn btn-primary" id="nextBtn"
                    onclick="nextPrev(1)">Selanjutnya</button>
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

            $('.js-example-basic-single').select2();
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

        function toggleFormsAyah() {
            // Validasi untuk ayah
            var statusAyah = document.getElementById('status_kehidupan_ayah').value;

            if (statusAyah === 'meninggal') {
                // Sembunyikan form Wali dan KTP Ayah
                document.getElementById('br_status').style.display = 'none';
                document.getElementById('form_wali_ayah').style.display = 'none';
                document.getElementById('br_wali_ayah').style.display = 'none';
                document.getElementById('form_ktp_ayah').style.display = 'none';
                document.getElementById('br_ktp_ayah').style.display = 'none';
            } else {
                // Tampilkan form Wali dan KTP Ayah
                document.getElementById('br_status').style.display = 'block';
                document.getElementById('form_wali_ayah').style.display = 'block';
                document.getElementById('br_wali_ayah').style.display = 'block';
                document.getElementById('form_ktp_ayah').style.display = 'block';
                document.getElementById('br_ktp_ayah').style.display = 'block';
            }
        }

        function toggleFormsIbu() {
            // Validasi untuk ibu
            var statusIbu = document.getElementById('status_kehidupan_ibu').value;

            if (statusIbu === 'meninggal') {
                // Sembunyikan form Wali dan KTP Ibu
                document.getElementById('br_status').style.display = 'block';
                document.getElementById('form_wali_ibu').style.display = 'none';
                document.getElementById('form_wali_ibu_meninggal').style.display = 'block';
                document.getElementById('br_wali_ibu').style.display = 'none';
                document.getElementById('form_ktp_ibu').style.display = 'none';
            } else {
                // Tampilkan form Wali dan KTP Ibu
                document.getElementById('br_status').style.display = 'block';
                document.getElementById('form_wali_ibu').style.display = 'block';
                document.getElementById('form_wali_ibu_meninggal').style.display = 'none';
                document.getElementById('br_wali_ibu').style.display = 'block';
                document.getElementById('form_ktp_ibu').style.display = 'block';
            }
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
