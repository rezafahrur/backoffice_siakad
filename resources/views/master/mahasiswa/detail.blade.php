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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-krs-tab" data-bs-toggle="pill" data-bs-target="#pills-krs"
                            type="button" role="tab" aria-controls="pills-krs" aria-selected="false">KRS</button>
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

                                    {{-- Status Mahasiswa --}}
                                    <dt class="col-sm-4">Status Mahasiswa</dt>
                                    <dd class="col-sm-8">
                                        @if ($mahasiswa->status == 1)
                                            Aktif
                                        @else
                                            Nonaktif
                                        @endif
                                    </dd>
                                </dl>
                                </dl>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table mb-1 table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">No. Hp</th>
                                                <th scope="col">Alamat Domisili</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mhsDetail as $detail)
                                                <tr>
                                                    <td>{{ $detail->hp }}</td>
                                                    <td>{{ $detail->alamat_domisili }}</td>
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

                    <!-- KRS -->
                    <div class="tab-pane fade" id="pills-krs" role="tabpanel" aria-labelledby="pills-krs-tab">
                        <!-- Title and Wizard Buttons -->
                        <div class="row">
                            <h4 class="card-title">KRS</h4>
                            <ul class="nav nav-pills mb-3" id="pills-semester-tab" role="tablist">
                                @foreach ($krs as $index => $krsItem)
                                    @if ($krsItem && $krsItem->paketMatakuliah)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if ($index == 0) active @endif"
                                                id="pills-semester-{{ $krsItem->paketMatakuliah->semester }}-tab"
                                                data-bs-toggle="pill"
                                                data-bs-target="#pills-semester-{{ $krsItem->paketMatakuliah->semester }}"
                                                type="button" role="tab"
                                                aria-controls="pills-semester-{{ $krsItem->paketMatakuliah->semester }}"
                                                aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                                                Semester {{ $krsItem->paketMatakuliah->semester }}
                                            </button>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>

                        <!-- KRS Content for Each Semester -->
                        <div class="tab-content" id="pills-semester-content">
                            @foreach ($krs as $index => $krsItem)
                                @if ($krsItem && $krsItem->paketMatakuliah)
                                    <!-- Tambahkan pengecekan ini -->
                                    <div class="tab-pane fade @if ($index == 0) show active @endif"
                                        id="pills-semester-{{ $krsItem->semester }}" role="tabpanel"
                                        aria-labelledby="pills-semester-{{ $krsItem->semester }}-tab">
                                        <!-- Kolom KRS -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <dl class="row">
                                                    <dt class="col-sm-4">Tanggal Transfer</dt>
                                                    <dd class="col-sm-8">
                                                        {{ \Carbon\Carbon::parse($krsItem->tgl_transfer)->format('d-m-Y') }}
                                                    </dd>

                                                    <dt class="col-sm-4">Paket Matakuliah</dt>
                                                    <dd class="col-sm-8">
                                                        {{ $krsItem->paketMatakuliah->nama_paket_matakuliah }}</dd>

                                                    <dt class="col-sm-4">Total SKS</dt>
                                                    <dd class="col-sm-8">
                                                        @php
                                                            $totalSks = 0;
                                                            foreach (
                                                                $krsItem->paketMatakuliah->paketMatakuliahDetail
                                                                as $matkul
                                                            ) {
                                                                $totalSks += $matkul->matakuliah->sks;
                                                            }
                                                            echo $totalSks;
                                                        @endphp
                                                    </dd>
                                                </dl>
                                            </div>
                                        </div>

                                        <!-- Table for Paket Matakuliah Details -->
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <h5 class="mb-3">Detail Paket Matakuliah</h5>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Kode Matakuliah</th>
                                                            <th>Nama Matakuliah</th>
                                                            <th>SKS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($krsItem->paketMatakuliah->paketMatakuliahDetail as $index => $matkul)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $matkul->matakuliah->kode_matakuliah }}</td>
                                                                <td>{{ $matkul->matakuliah->nama_matakuliah }}</td>
                                                                <td>{{ $matkul->matakuliah->sks }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>KRS tidak ditemukan untuk semester ini.</p>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
