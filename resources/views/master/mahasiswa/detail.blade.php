@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
    <div class="container">
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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-kebutuhan-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-kebutuhan" type="button" role="tab" aria-controls="pills-kebutuhan"
                            aria-selected="false">Kebutuhan Khusus</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-krs-tab" data-bs-toggle="pill" data-bs-target="#pills-krs"
                            type="button" role="tab" aria-controls="pills-krs" aria-selected="false">KRS</button>
                    </li>

                    {{-- Back page button --}}
                    <li class="nav-item ms-auto" role="presentation">
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
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

                                    {{-- Email --}}
                                    <dt class="col-sm-4">Email</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->email }}</dd>

                                    {{-- NISN --}}
                                    <dt class="col-sm-4">NISN</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->nisn }}</dd>

                                    {{-- NPWP --}}
                                    <dt class="col-sm-4">NPWP</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->npwp ?? '-' }}</dd>

                                    {{-- Jenis Tinggal --}}
                                    <dt class="col-sm-4">Jenis Tinggal</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->jenis_tinggal }}</dd>

                                    {{-- Alat Transportasi --}}
                                    <dt class="col-sm-4">Alat Transportasi</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->alat_transportasi }}</dd>
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

                                    {{-- Registrasi Tanggal --}}
                                    <dt class="col-sm-4">Registrasi Tanggal</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($mahasiswa->registrasi_tgl)->format('d-m-Y') }}</dd>

                                    {{-- Semester Berjalan --}}
                                    <dt class="col-sm-4">Semester Berjalan</dt>
                                    <dd class="col-sm-8">Semester {{ $mahasiswa->semester_berjalan }}</dd>

                                    {{-- Status Mahasiswa --}}
                                    <dt class="col-sm-4">Status Mahasiswa</dt>
                                    <dd class="col-sm-8">
                                        @if ($mahasiswa->status == 1)
                                            Aktif
                                        @else
                                            Nonaktif
                                        @endif
                                    </dd>

                                    {{-- Terima KPS --}}
                                    <dt class="col-sm-4">Terima KPS</dt>
                                    <dd class="col-sm-8">
                                        @if ($mahasiswa->terima_kps == 1)
                                            Ya
                                        @else
                                            Tidak
                                        @endif
                                    </dd>

                                    {{-- No KPS --}}
                                    <dt class="col-sm-4">No KPS</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->no_kps ?? '-' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table mb-1 table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Telp Rumah</th>
                                                <th scope="col">No. Hp</th>
                                                <th scope="col">Alamat Domisili</th>
                                                <th scope="col">Kode Pos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mhsDetail as $detail)
                                                <tr>
                                                    <td>{{ $detail->telp_rumah ?? '-' }}</td>
                                                    <td>{{ $detail->hp }}</td>
                                                    <td>{{ $detail->alamat_domisili }}</td>
                                                    <td>{{ $detail->kode_pos ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table mb-1 table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">No. Hp</th>
                                                <th scope="col">Alamat Domisili</th>
                                                <th scope="col">Pekerjaan</th>
                                                <th scope="col">Penghasilan</th>
                                                <th scope="col">Pendidikan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wali1Detail as $detail)
                                                <tr>
                                                    <td>{{ $detail->hp }}</td>
                                                    <td>{{ $detail->alamat_domisili }}</td>
                                                    <td>{{ $detail->pekerjaan }}</td>
                                                    <td>{{ $detail->penghasilan }}</td>
                                                    <td>{{ $detail->pendidikan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table mb-1 table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">No. Hp</th>
                                                <th scope="col">Alamat Domisili</th>
                                                <th scope="col">Pekerjaan</th>
                                                <th scope="col">Penghasilan</th>
                                                <th scope="col">Pendidikan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wali2Detail as $detail)
                                                <tr>
                                                    <td>{{ $detail->hp }}</td>
                                                    <td>{{ $detail->alamat_domisili }}</td>
                                                    <td>{{ $detail->pekerjaan }}</td>
                                                    <td>{{ $detail->penghasilan }}</td>
                                                    <td>{{ $detail->pendidikan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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
                            <div class="col-md-6">
                                <dl class="row">
                                    {{-- Tanggal Lahir --}}
                                    <dt class="col-sm-4">Tanggal Lahir</dt>
                                    <dd class="col-sm-8">
                                        {{ \Carbon\Carbon::parse($mahasiswa->tgl_lahir_kontak_darurat)->format('d-m-Y') }}
                                    </dd>

                                    {{-- Pekerjaan --}}
                                    <dt class="col-sm-4">Pekerjaan</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->pekerjaan_kontak_darurat }}</dd>

                                    {{-- Penghasilan --}}
                                    <dt class="col-sm-4">Penghasilan</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->penghasilan_kontak_darurat }}</dd>

                                    {{-- Pendidikan Terakhir --}}
                                    <dt class="col-sm-4">Pendidikan Terakhir</dt>
                                    <dd class="col-sm-8">{{ $mahasiswa->pendidikan_kontak_darurat }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Kebutuhan Khusus -->
                    <div class="tab-pane fade" id="pills-kebutuhan" role="tabpanel"
                        aria-labelledby="pills-kebutuhan-tab">
                        <div class="col-md-12 mb-3">
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
                                                        name="kebutuhan_khusus_mahasiswa[]" value="{{ $key }}"
                                                        {{ in_array($key, $mahasiswaKebutuhanKhusus) ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check"
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
                                                        id="kebutuhan_khusus_ayah" name="kebutuhan_khusus_ayah[]"
                                                        value="{{ $key }}"
                                                        {{ in_array($key, $wali1KebutuhanKhusus) ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check"
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
                                                        id="kebutuhan_khusus_ibu" name="kebutuhan_khusus_ibu[]"
                                                        value="{{ $key }}"
                                                        {{ in_array($key, $wali2KebutuhanKhusus) ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check"
                                                        for="kebutuhan_khusus_ibu_{{ $key }}">{{ $value }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KRS -->
                    <div class="tab-pane fade" id="pills-krs" role="tabpanel" aria-labelledby="pills-krs-tab">
                        <!-- Title and Wizard Buttons -->
                        <div class="row">
                            <h4 class="card-title">KRS</h4>
                            @if ($krs->isEmpty())
                                <!-- Pesan jika tidak ada data KRS -->
                                <p>KRS tidak ditemukan untuk mahasiswa ini.</p>
                            @else
                                <div class="col-md-12">
                                    <!-- Semester Navigation -->
                                    <ul class="nav nav-pills mb-3" id="pills-semester-tab" role="tablist">
                                        @foreach ($krs as $index => $krsItem)
                                            @if ($krsItem && $krsItem->kurikulum)
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="nav-link @if ($index == 0) active @endif"
                                                        id="pills-semester-{{ $krsItem->kurikulum->semester_angka }}-tab"
                                                        data-bs-toggle="pill"
                                                        data-bs-target="#pills-semester-{{ $krsItem->kurikulum->semester_angka }}"
                                                        type="button" role="tab"
                                                        aria-controls="pills-semester-{{ $krsItem->kurikulum->semester_angka }}"
                                                        aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                                        Semester {{ $krsItem->kurikulum->semester_angka }}
                                                    </button>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- KRS Content for Each Semester -->
                                <div class="tab-content" id="pills-semester-content">
                                    @foreach ($krs as $index => $krsItem)
                                        @if ($krsItem && $krsItem->kurikulum)
                                            <div class="tab-pane fade @if ($index == 0) show active @endif"
                                                id="pills-semester-{{ $krsItem->kurikulum->semester }}" role="tabpanel"
                                                aria-labelledby="pills-semester-{{ $krsItem->kurikulum->semester }}-tab">
                                                <!-- Kolom KRS -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">Tanggal Transfer</dt>
                                                            <dd class="col-sm-8">
                                                                {{ \Carbon\Carbon::parse($krsItem->tgl_transfer)->format('d-m-Y') }}
                                                            </dd>

                                                            <dt class="col-sm-4">Kurikulum</dt>
                                                            <dd class="col-sm-8">{{ $krsItem->kurikulum->nama_kurikulum }}
                                                            </dd>

                                                            <dt class="col-sm-4">Tahun Akademik</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $krsItem->kurikulum->semesters->nama_semester }}
                                                            </dd>

                                                            <dt class="col-sm-4">Program Studi</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $krsItem->kurikulum->programStudi->kode_program_studi }}
                                                                -
                                                                {{ $krsItem->kurikulum->programStudi->nama_program_studi }}
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-4">SKS Lulus</dt>
                                                            <dd class="col-sm-8">{{ $krsItem->kurikulum->sum_sks_lulus }}
                                                            </dd>

                                                            <dt class="col-sm-4">SKS Wajib</dt>
                                                            <dd class="col-sm-8">{{ $krsItem->kurikulum->sum_sks_wajib }}
                                                            </dd>

                                                            <dt class="col-sm-4">SKS Pilihan</dt>
                                                            <dd class="col-sm-8">
                                                                {{ $krsItem->kurikulum->sum_sks_pilihan }}</dd>

                                                            <dt class="col-sm-4">Tanggal Mulai - Akhir</dt>
                                                            <dd class="col-sm-8">
                                                                {{ \Carbon\Carbon::parse($krsItem->kelas->tgl_mulai)->format('d-m-Y') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($krsItem->kelas->tgl_akhir)->format('d-m-Y') }}
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>

                                                <!-- Table for Matakuliah Details -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Nama Mata Kuliah</th>
                                                                <th scope="col">Deskripsi</th>
                                                                <th scope="col">Lingkup Kelas</th>
                                                                <th scope="col">Mode Kelas</th>
                                                                <th scope="col">Dosen</th>
                                                                <th scope="col">Tatap Muka</th>
                                                                <th scope="col">Sks</th>
                                                                <th scope="col">Evaluasi</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($krsItem->kelas->details as $detail)
                                                                <tr>
                                                                    <td>{{ $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'N/A' }}
                                                                    </td>
                                                                    <td>{{ $detail->description }}</td>
                                                                    <td>
                                                                        @if ($detail->lingkup_kelas == 1)
                                                                            Internal
                                                                        @elseif($detail->lingkup_kelas == 2)
                                                                            Eksternal
                                                                        @else
                                                                            Campuran
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($detail->mode_kelas == 'O')
                                                                            Online
                                                                        @elseif($detail->mode_kelas == 'F')
                                                                            Offline
                                                                        @else
                                                                            Campuran
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $detail->hr->nama ?? 'N/A' }}</td>
                                                                    <td>{{ $detail->tatap_muka }}</td>
                                                                    <td>{{ $detail->sks_ajar }}</td>
                                                                    <td>
                                                                        @switch($detail->jenis_evaluasi)
                                                                            @case(1)
                                                                                Evaluasi Akademik
                                                                            @break

                                                                            @case(2)
                                                                                Aktivitas Partisipatif
                                                                            @break

                                                                            @case(3)
                                                                                Proyek
                                                                            @break

                                                                            @case(4)
                                                                                Kognitif / Pengetahuan
                                                                            @break

                                                                            @default
                                                                                N/A
                                                                        @endswitch
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
