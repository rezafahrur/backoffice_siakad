@extends('layouts.custom')

@section('title', 'Edit Mahasiswa')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('mahasiswa.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="card-body">
        <!-- Progress Bar -->
        <div class="row text-center">
            <div class="col step active" id="step1">
                <div class="step-icon">1</div>
                <div class="step-title">Mahasiswa</div>
            </div>
            <div class="col step" id="step2">
                <div class="step-icon">2</div>
                <div class="step-title">Wali</div>
            </div>
            <div class="col step" id="step3">
                <div class="step-icon">3</div>
                <div class="step-title">Kontak Darurat</div>
            </div>
        </div>

        <form id="formWizard" class="mt-4" action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
            @method('PUT')
            @csrf

            <!-- Step 1 -->
            <div class="tab">
                {{-- Form Mahasiswa --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Edit Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            {{-- ID Mahasiswa --}}
                            <input type="hidden" name="id" value="{{ $mahasiswa->id }}">

                            {{-- Semester Berjalan --}}
                            <input type="hidden" name="semester_berjalan" id="semester_berjalan" value="1">

                            {{-- Nama --}}
                            <div class="col-md-4 mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" placeholder="NAMA"
                                    value="{{ old('nama') ?? $mahasiswa->nama }}"
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
                                    id="email" name="email" placeholder="Email"
                                    value="{{ old('email') ?? $mahasiswa->email }}">
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
                                    id="nisn" name="nisn" placeholder="NISN"
                                    value="{{ old('nisn') ?? $mahasiswa->nisn }}" maxlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
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
                                            {{ old('jurusan', $mahasiswa->jurusan_id) == $js->id ? 'selected' : '' }}>
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
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Aktif"
                                        {{ old('status', $mahasiswa->status) == 'Aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="Non Aktif"
                                        {{ old('status', $mahasiswa->status) == 'Non Aktif' ? 'selected' : '' }}>Non
                                        Aktif
                                    </option>
                                    <option value="Cuti"
                                        {{ old('status', $mahasiswa->status) == 'Cuti' ? 'selected' : '' }}>Cuti
                                    </option>
                                    <option value="Lulus"
                                        {{ old('status', $mahasiswa->status) == 'Lulus' ? 'selected' : '' }}>Lulus
                                    </option>
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
                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                    id="no_hp" name="no_hp" placeholder="No HP"
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

                {{-- Form KTP Mahasiswa --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form KTP Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                    id="nik" name="nik" placeholder="NIK"
                                    value="{{ old('nik') ?? $mahasiswa->ktp->nik }}" maxlength="16"
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
                                            {{ old('alamat_prov_code', $data['alamat_prov_code'] ?? $mahasiswa->ktp->alamat_prov_code) == $province->code ? 'selected' : '' }}>
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
                                    {{-- Populated dynamically --}}
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
                                    {{-- Populated dynamically --}}
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
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    id="jenis_kelamin" name="jenis_kelamin">
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
                                <select class="form-select @error('golongan_darah') is-invalid @enderror"
                                    id="golongan_darah" name="golongan_darah">
                                    <option value="" disabled selected>Pilih Golongan Darah</option>
                                    <option value="A"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'A' ? 'selected' : '' }}>
                                        A
                                    </option>
                                    <option value="A+"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'A+' ? 'selected' : '' }}>
                                        A+
                                    </option>
                                    <option value="A-"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'A-' ? 'selected' : '' }}>
                                        A-
                                    </option>
                                    <option value="B"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'B' ? 'selected' : '' }}>
                                        B
                                    </option>
                                    <option value="B+"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'B+' ? 'selected' : '' }}>
                                        B+
                                    </option>
                                    <option value="B-"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'B-' ? 'selected' : '' }}>
                                        B-
                                    </option>
                                    <option value="AB"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'AB' ? 'selected' : '' }}>
                                        AB
                                    </option>
                                    <option value="AB+"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'AB+' ? 'selected' : '' }}>
                                        AB+
                                    </option>
                                    <option value="AB-"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'AB-' ? 'selected' : '' }}>
                                        AB-
                                    </option>
                                    <option value="O"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'O' ? 'selected' : '' }}>
                                        O
                                    </option>
                                    <option value="O+"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'O+' ? 'selected' : '' }}>
                                        O+
                                    </option>
                                    <option value="O-"
                                        {{ old('golongan_darah', $mahasiswa->ktp->golongan_darah) == 'O-' ? 'selected' : '' }}>
                                        O-
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
            </div>

            <!-- Step 2 -->
            <div class="tab">
                {{-- Form Wali Mahasiswa Ayah --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Wali Mahasiswa Ayah</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nama_1" class="form-label">Nama Wali</label>
                                <input type="text" class="form-control @error('wali_nama_1') is-invalid @enderror"
                                    id="wali_nama_1" name="wali_nama_1" placeholder="Nama Wali"
                                    value="{{ old('wali_nama_1') ?? $wali1->nama }}"
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
                                <label for="wali_no_hp_1" class="form-label">No HP Wali</label>
                                <input type="text" class="form-control @error('wali_no_hp_1') is-invalid @enderror"
                                    id="wali_no_hp_1" name="wali_no_hp_1" placeholder="No HP Wali"
                                    value="{{ old('wali_no_hp_1') ?? $wali1->mahasiswaWaliDetail->hp }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('wali_no_hp_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat Domisili Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_domisili_1" class="form-label">Alamat Domisili Wali</label>
                                <textarea class="form-control @error('wali_alamat_domisili_1') is-invalid @enderror" id="wali_alamat_domisili_1"
                                    name="wali_alamat_domisili_1" placeholder="Alamat Wali" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_domisili_1') ?? $wali1->mahasiswaWaliDetail->alamat_domisili }}</textarea>
                                @error('wali_alamat_domisili_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_pekerjaan_1" class="form-label">Pekerjaan Wali</label>
                                <input type="text"
                                    class="form-control @error('wali_pekerjaan_1') is-invalid @enderror"
                                    id="wali_pekerjaan_1" name="wali_pekerjaan_1" placeholder="Pekerjaan Wali"
                                    value="{{ old('wali_pekerjaan_1') ?? $wali1->mahasiswaWaliDetail->pekerjaan }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_pekerjaan_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Penghasilan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_penghasilan_1" class="form-label">Penghasilan Wali</label>
                                <select class="form-select @error('wali_penghasilan_1') is-invalid @enderror"
                                    id="wali_penghasilan_1" name="wali_penghasilan_1">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp. 500.000"
                                        {{ old('wali_penghasilan_1', $wali1->mahasiswaWaliDetail->penghasilan) == '< Rp. 500.000' ? 'selected' : '' }}>
                                        < Rp. 500.000</option>
                                    <option value="Rp. 500.000 - Rp. 1.000.000"
                                        {{ old('wali_penghasilan_1', $wali1->mahasiswaWaliDetail->penghasilan) == 'Rp. 500.000 - Rp. 1.000.000' ? 'selected' : '' }}>
                                        Rp. 500.000 - Rp. 1.000.000
                                    </option>
                                    <option value="Rp. 1.000.000 - Rp. 1.500.000"
                                        {{ old('wali_penghasilan_1', $wali1->mahasiswaWaliDetail->penghasilan) == 'Rp. 1.000.000 - Rp. 1.500.000' ? 'selected' : '' }}>
                                        Rp. 1.000.000 - Rp. 1.500.000
                                    </option>
                                    <option value="Rp. 1.500.000 - Rp. 2.000.000"
                                        {{ old('wali_penghasilan_1', $wali1->mahasiswaWaliDetail->penghasilan) == 'Rp. 1.500.000 - Rp. 2.000.000' ? 'selected' : '' }}>
                                        Rp. 1.500.000 - Rp. 2.000.000
                                    </option>
                                    <option value="> Rp. 2.000.000"
                                        {{ old('wali_penghasilan_1', $wali1->mahasiswaWaliDetail->penghasilan) == '> Rp. 2.000.000' ? 'selected' : '' }}>
                                        > Rp. 2.000.000
                                    </option>
                                    {{-- Add more options here --}}
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
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="SD"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'SD' ? 'selected' : '' }}>
                                        SD
                                    </option>
                                    <option value="SMP"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'SMP' ? 'selected' : '' }}>
                                        SMP
                                    </option>
                                    <option value="SMA"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'SMA' ? 'selected' : '' }}>
                                        SMA
                                    </option>
                                    <option value="SMK"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'SMK' ? 'selected' : '' }}>
                                        SMK
                                    </option>
                                    <option value="D1"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'D1' ? 'selected' : '' }}>
                                        D1
                                    </option>
                                    <option value="D2"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'D2' ? 'selected' : '' }}>
                                        D2
                                    </option>
                                    <option value="D3"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'D3' ? 'selected' : '' }}>
                                        D3
                                    </option>
                                    <option value="D4"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'D4' ? 'selected' : '' }}>
                                        D4
                                    </option>
                                    <option value="S1"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'S1' ? 'selected' : '' }}>
                                        S1
                                    </option>
                                    <option value="S2"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'S2' ? 'selected' : '' }}>
                                        S2
                                    </option>
                                    <option value="S3"
                                        {{ old('pendidikan_terakhir_1', $wali1->mahasiswaWaliDetail->pendidikan) == 'S3' ? 'selected' : '' }}>
                                        S3
                                    </option>
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

                <div class="card">
                    <div class="card-body">
                        <hr>
                    </div>
                </div>

                {{-- Form KTP Wali Ayah --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form KTP Wali Ayah</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nik_1" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('wali_nik_1') is-invalid @enderror"
                                    id="wali_nik_1" name="wali_nik_1" placeholder="NIK"
                                    value="{{ old('wali_nik_1') ?? $wali1->ktp->nik }}" maxlength="16"
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
                                    name="wali_alamat_jalan_1" placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_jalan_1') ?? $wali1->ktp->alamat_jalan }}</textarea>
                                @error('wali_alamat_jalan_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- RT --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_rt_1" class="form-label">RT</label>
                                <input type="text"
                                    class="form-control @error('wali_alamat_rt_1') is-invalid @enderror"
                                    id="wali_alamat_rt_1" name="wali_alamat_rt_1" placeholder="000"
                                    value="{{ old('wali_alamat_rt_1') ?? $wali1->ktp->alamat_rt }}" maxlength="3"
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
                                    value="{{ old('wali_alamat_rw_1') ?? $wali1->ktp->alamat_rw }}" maxlength="3"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                @error('wali_alamat_rw_1')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 1 Alamat Provinsi --}}
                            <div class="col-md-3 mb-3">
                                <label for="wali_alamat_prov_code_1" class="form-label">Provinsi (Wali 1)</label>
                                <select class="form-select @error('wali_alamat_prov_code_1') is-invalid @enderror"
                                    id="wali_alamat_prov_code_1" name="wali_alamat_prov_code_1">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('wali_alamat_prov_code_1', $data['wali_alamat_prov_code_1'] ?? $wali1->ktp->alamat_prov_code) == $province->code ? 'selected' : '' }}>
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
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
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
                                    value="{{ old('wali_lahir_tempat_1') ?? $wali1->ktp->lahir_tempat }}"
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
                                    value="{{ old('wali_lahir_tgl_1') ?? $wali1->ktp->lahir_tgl }}">
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
                                    <option value="L"
                                        {{ old('wali_jenis_kelamin_1', $wali1->ktp->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="P"
                                        {{ old('wali_jenis_kelamin_1', $wali1->ktp->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                        Perempuan
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
                                <input type="text" class="form-control @error('wali_agama_1') is-invalid @enderror"
                                    id="wali_agama_1" name="wali_agama_1" placeholder="Agama"
                                    value="{{ old('wali_agama_1') ?? $wali1->ktp->agama }}"
                                    oninput="this.value = this.value.toUpperCase()">
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
                                    <option value="A"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'A' ? 'selected' : '' }}>
                                        A
                                    </option>
                                    <option value="A+"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'A+' ? 'selected' : '' }}>
                                        A+
                                    </option>
                                    <option value="A-"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'A-' ? 'selected' : '' }}>
                                        A-
                                    </option>
                                    <option value="B"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'B' ? 'selected' : '' }}>
                                        B
                                    </option>
                                    <option value="B+"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'B+' ? 'selected' : '' }}>
                                        B+
                                    </option>
                                    <option value="B-"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'B-' ? 'selected' : '' }}>
                                        B-
                                    </option>
                                    <option value="AB"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'AB' ? 'selected' : '' }}>
                                        AB
                                    </option>
                                    <option value="AB+"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'AB+' ? 'selected' : '' }}>
                                        AB+
                                    </option>
                                    <option value="AB-"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'AB-' ? 'selected' : '' }}>
                                        AB-
                                    </option>
                                    <option value="O"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'O' ? 'selected' : '' }}>
                                        O
                                    </option>
                                    <option value="O+"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'O+' ? 'selected' : '' }}>
                                        O+
                                    </option>
                                    <option value="O-"
                                        {{ old('wali_golongan_darah_1', $wali1->ktp->golongan_darah) == 'O-' ? 'selected' : '' }}>
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
                                <input type="text"
                                    class="form-control @error('wali_kewarganegaraan_1') is-invalid @enderror"
                                    id="wali_kewarganegaraan_1" name="wali_kewarganegaraan_1"
                                    placeholder="Kewarganegaraan"
                                    value="{{ old('wali_kewarganegaraan_1') ?? $wali1->ktp->kewarganegaraan }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_kewarganegaraan_1')
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

                {{-- Form Wali Mahasiswa Ibu --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Wali Mahasiswa Ibu</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nama_2" class="form-label">Nama Wali</label>
                                <input type="text" class="form-control @error('wali_nama_2') is-invalid @enderror"
                                    id="wali_nama_2" name="wali_nama_2" placeholder="Nama Wali"
                                    value="{{ old('wali_nama_2') ?? $wali2->nama }}"
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
                                <label for="wali_no_hp_2" class="form-label">No HP Wali</label>
                                <input type="text" class="form-control @error('wali_no_hp_2') is-invalid @enderror"
                                    id="wali_no_hp_2" name="wali_no_hp_2" placeholder="No HP Wali"
                                    value="{{ old('wali_no_hp_2') ?? $wali2->mahasiswaWaliDetail->hp }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('wali_no_hp_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat Domisili Wali --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_domisili_2" class="form-label">Alamat Domisili Wali</label>
                                <textarea class="form-control @error('wali_alamat_domisili_2') is-invalid @enderror" id="wali_alamat_domisili_2"
                                    name="wali_alamat_domisili_2" placeholder="Alamat Wali" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_domisili_2') ?? $wali2->mahasiswaWaliDetail->alamat_domisili }}</textarea>
                                @error('wali_alamat_domisili_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_pekerjaan_2" class="form-label">Pekerjaan Wali</label>
                                <input type="text"
                                    class="form-control @error('wali_pekerjaan_2') is-invalid @enderror"
                                    id="wali_pekerjaan_2" name="wali_pekerjaan_2" placeholder="Pekerjaan Wali"
                                    value="{{ old('wali_pekerjaan_2') ?? $wali2->mahasiswaWaliDetail->pekerjaan }}"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('wali_pekerjaan_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Penghasilan --}}
                            <div class="col-md-4 mb-3">
                                <label for="wali_penghasilan_2" class="form-label">Penghasilan Wali</label>
                                <select class="form-select @error('wali_penghasilan_2') is-invalid @enderror"
                                    id="wali_penghasilan_2" name="wali_penghasilan_2">
                                    <option value="">Pilih Penghasilan</option>
                                    <option value="< Rp. 500.000"
                                        {{ old('wali_penghasilan_2', $wali2->mahasiswaWaliDetail->penghasilan) == '< Rp. 500.000' ? 'selected' : '' }}>
                                        < Rp. 500.000</option>
                                    <option value="Rp. 500.000 - Rp. 1.000.000"
                                        {{ old('wali_penghasilan_2', $wali2->mahasiswaWaliDetail->penghasilan) == 'Rp. 500.000 - Rp. 1.000.000' ? 'selected' : '' }}>
                                        Rp. 500.000 - Rp. 1.000.000
                                    </option>
                                    <option value="Rp. 1.000.000 - Rp. 1.500.000"
                                        {{ old('wali_penghasilan_2', $wali2->mahasiswaWaliDetail->penghasilan) == 'Rp. 1.000.000 - Rp. 1.500.000' ? 'selected' : '' }}>
                                        Rp. 1.000.000 - Rp. 1.500.000
                                    </option>
                                    <option value="Rp. 1.500.000 - Rp. 2.000.000"
                                        {{ old('wali_penghasilan_2', $wali2->mahasiswaWaliDetail->penghasilan) == 'Rp. 1.500.000 - Rp. 2.000.000' ? 'selected' : '' }}>
                                        Rp. 1.500.000 - Rp. 2.000.000
                                    </option>
                                    <option value="> Rp. 2.000.000"
                                        {{ old('wali_penghasilan_2', $wali2->mahasiswaWaliDetail->penghasilan) == '> Rp. 2.000.000' ? 'selected' : '' }}>
                                        > Rp. 2.000.000
                                    </option>
                                    {{-- Add more options here --}}
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
                                    <option value="SD"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'SD' ? 'selected' : '' }}>
                                        SD
                                    </option>
                                    <option value="SMP"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'SMP' ? 'selected' : '' }}>
                                        SMP
                                    </option>
                                    <option value="SMA"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'SMA' ? 'selected' : '' }}>
                                        SMA
                                    </option>
                                    <option value="SMK"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'SMK' ? 'selected' : '' }}>
                                        SMK
                                    </option>
                                    <option value="D1"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'D1' ? 'selected' : '' }}>
                                        D1
                                    </option>
                                    <option value="D2"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'D2' ? 'selected' : '' }}>
                                        D2
                                    </option>
                                    <option value="D3"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'D3' ? 'selected' : '' }}>
                                        D3
                                    </option>
                                    <option value="D4"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'D4' ? 'selected' : '' }}>
                                        D4
                                    </option>
                                    <option value="S1"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'S1' ? 'selected' : '' }}>
                                        S1
                                    </option>
                                    <option value="S2"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'S2' ? 'selected' : '' }}>
                                        S2
                                    </option>
                                    <option value="S3"
                                        {{ old('pendidikan_terakhir_2', $wali2->mahasiswaWaliDetail->pendidikan) == 'S3' ? 'selected' : '' }}>
                                        S3
                                    </option>
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

                <div class="card">
                    <div class="card-body">
                        <hr>
                    </div>
                </div>

                {{-- Form KTP Wali Ibu --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form KTP Wali Ibu</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_nik_2" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('wali_nik_2') is-invalid @enderror"
                                    id="wali_nik_2" name="wali_nik_2" placeholder="NIK"
                                    value="{{ old('wali_nik_2') ?? $wali2->ktp->nik }}" maxlength="16"
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
                                    name="wali_alamat_jalan_2" placeholder="Alamat Jalan" oninput="this.value = this.value.toUpperCase()">{{ old('wali_alamat_jalan_2') ?? $wali2->ktp->alamat_jalan }}</textarea>
                                @error('wali_alamat_jalan_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- RT --}}
                            <div class="col-md-6 mb-3">
                                <label for="wali_alamat_rt_2" class="form-label">RT</label>
                                <input type="text"
                                    class="form-control @error('wali_alamat_rt_2') is-invalid @enderror"
                                    id="wali_alamat_rt_2" name="wali_alamat_rt_2" placeholder="000"
                                    value="{{ old('wali_alamat_rt_2') ?? $wali2->ktp->alamat_rt }}" maxlength="3"
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
                                    value="{{ old('wali_alamat_rw_2') ?? $wali2->ktp->alamat_rw }}" maxlength="3"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)">
                                @error('wali_alamat_rw_2')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Wali 2 Alamat Provinsi --}}
                            <div class="col-md-3 mb-3">
                                <label for="wali_alamat_prov_code_2" class="form-label">Provinsi (Wali 2)</label>
                                <select class="form-select @error('wali_alamat_prov_code_2') is-invalid @enderror"
                                    id="wali_alamat_prov_code_2" name="wali_alamat_prov_code_2">
                                    <option value="" disabled selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->code }}"
                                            {{ old('wali_alamat_prov_code_2', $data['wali_alamat_prov_code_2'] ?? $wali2->ktp->alamat_prov_code) == $province->code ? 'selected' : '' }}>
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
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
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
                                    value="{{ old('wali_lahir_tempat_2') ?? $wali2->ktp->lahir_tempat }}"
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
                                    value="{{ old('wali_lahir_tgl_2') ?? $wali2->ktp->lahir_tgl }}">
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
                                    <option value="L"
                                        {{ old('wali_jenis_kelamin_2', $wali2->ktp->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="P"
                                        {{ old('wali_jenis_kelamin_2', $wali2->ktp->jenis_kelamin) == 'P' ? 'selected' : '' }}>
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
                                <input type="text" class="form-control @error('wali_agama_2') is-invalid @enderror"
                                    id="wali_agama_2" name="wali_agama_2" placeholder="Agama"
                                    value="{{ old('wali_agama_2') ?? $wali2->ktp->agama }}"
                                    oninput="this.value = this.value.toUpperCase()">
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
                                    <option value="A"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'A' ? 'selected' : '' }}>
                                        A
                                    </option>
                                    <option value="A+"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'A+' ? 'selected' : '' }}>
                                        A+
                                    </option>
                                    <option value="A-"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'A-' ? 'selected' : '' }}>
                                        A-
                                    </option>
                                    <option value="B"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'B' ? 'selected' : '' }}>
                                        B
                                    </option>
                                    <option value="B+"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'B+' ? 'selected' : '' }}>
                                        B+
                                    </option>
                                    <option value="B-"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'B-' ? 'selected' : '' }}>
                                        B-
                                    </option>
                                    <option value="AB"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'AB' ? 'selected' : '' }}>
                                        AB
                                    </option>
                                    <option value="AB+"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'AB+' ? 'selected' : '' }}>
                                        AB+
                                    </option>
                                    <option value="AB-"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'AB-' ? 'selected' : '' }}>
                                        AB-
                                    </option>
                                    <option value="O"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'O' ? 'selected' : '' }}>
                                        O
                                    </option>
                                    <option value="O+"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'O+' ? 'selected' : '' }}>
                                        O+
                                    </option>
                                    <option value="O-"
                                        {{ old('wali_golongan_darah_2', $wali2->ktp->golongan_darah) == 'O-' ? 'selected' : '' }}>
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
                                <input type="text"
                                    class="form-control @error('wali_kewarganegaraan_2') is-invalid @enderror"
                                    id="wali_kewarganegaraan_2" name="wali_kewarganegaraan_2"
                                    placeholder="Kewarganegaraan"
                                    value="{{ old('wali_kewarganegaraan_2') ?? $wali2->ktp->kewarganegaraan }}"
                                    oninput="this.value = this.value.toUpperCase()">
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
                    <div class="card-header">
                        <h4 class="card-title">Form Kontak Darurat</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Nama Kontak Darurat --}}
                            <div class="col-md-6 mb-3">
                                <label for="kd_nama" class="form-label">Nama Kontak Darurat</label>
                                <input type="text" class="form-control @error('kd_nama') is-invalid @enderror"
                                    id="kd_nama" name="kd_nama" placeholder="Nama Kontak Darurat"
                                    value="{{ old('kd_nama') ?? $mahasiswa->nama_kontak_darurat }}"
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
                                    value="{{ old('kd_hubungan') ?? $mahasiswa->hubungan_kontak_darurat }}"
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
                                    value="{{ old('kd_no_hp') ?? $mahasiswa->hp_kontak_darurat }}" maxlength="13"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                @error('kd_no_hp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-buttons mt-4">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">Submit</button>
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

        .step:last-child::after {
            display: none;
        }

        .step.active::after {
            background-color: #e9ecef;
        }

        .step.active .step-icon {
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
                    console.log(cityCode, 'city code');
                    if (cityCode) {
                        loadDistricts(cityCode, distCode, `#${prefix}_kec_code${prefix2}`);
                        console.log(distCode, 'district code');
                        if (distCode) {
                            loadVillages(distCode, villageCode, `#${prefix}_kel_code${prefix2}`);
                            console.log(villageCode, 'village');
                        }
                    }
                }
            }

            // Load data for existing values if available 
            @if (old('alamat_prov_code') ?? $mahasiswa->ktp->alamat_prov_code)
                var provCode = '{{ old('alamat_prov_code') ?? $mahasiswa->ktp->alamat_prov_code }}';
                var cityCode = '{{ old('alamat_kotakab_code') ?? $mahasiswa->ktp->alamat_kotakab_code }}';
                var distCode = '{{ old('alamat_kec_code') ?? $mahasiswa->ktp->alamat_kec_code }}';
                var villageCode = '{{ old('alamat_kel_code') ?? $mahasiswa->ktp->alamat_kel_code }}';
                initSelects(provCode, cityCode, distCode, villageCode, 'alamat', '');
            @endif

            @if (old('wali_alamat_prov_code_1') ?? $wali1->ktp->alamat_prov_code)
                var waliProvCode1 = '{{ old('wali_alamat_prov_code_1') ?? $wali1->ktp->alamat_prov_code }}';
                var waliCityCode1 = '{{ old('wali_alamat_kotakab_code_1') ?? $wali1->ktp->alamat_kotakab_code }}';
                var waliDistCode1 = '{{ old('wali_alamat_kec_code_1') ?? $wali1->ktp->alamat_kec_code }}';
                var waliVillageCode1 = '{{ old('wali_alamat_kel_code_1') ?? $wali1->ktp->alamat_kel_code }}';
                initSelects(waliProvCode1, waliCityCode1, waliDistCode1, waliVillageCode1, 'wali_alamat', '_1');
            @endif

            @if (old('wali_alamat_prov_code_2') ?? $wali2->ktp->alamat_prov_code)
                var waliProvCode2 = '{{ old('wali_alamat_prov_code_2') ?? $wali2->ktp->alamat_prov_code }}';
                var waliCityCode2 = '{{ old('wali_alamat_kotakab_code_2') ?? $wali2->ktp->alamat_kotakab_code }}';
                var waliDistCode2 = '{{ old('wali_alamat_kec_code_2') ?? $wali2->ktp->alamat_kec_code }}';
                var waliVillageCode2 = '{{ old('wali_alamat_kel_code_2') ?? $wali2->ktp->alamat_kel_code }}';
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

            // Update navigation buttons
            document.getElementById("prevBtn").style.display = n == 0 ? "none" : "inline";
            document.getElementById("nextBtn").style.display = n == (tabs.length - 1) ? "none" : "inline";
            document.getElementById("submitBtn").style.display = n == (tabs.length - 1) ? "inline" : "none";
        }

        function nextPrev(n) {
            var tabs = document.getElementsByClassName("tab");

            // Validate the current form
            if (n == 1 && !validateForm()) return false;

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

        function validateForm() {
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                } else {
                    y[i].classList.remove("is-invalid");
                }
            }
            return valid;
        }
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
    </script>
@endpush
