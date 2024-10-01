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
                        <button class="nav-link" id="pills-krs-tab" data-bs-toggle="pill" data-bs-target="#pills-krs"
                            type="button" role="tab" aria-controls="pills-krs" aria-selected="false">KRS</button>
                    </li>

                    {{-- Back page button --}}
                    <li class="nav-item ms-auto" role="presentation">
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Back</a>
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
                                                    <td>{{ $detail->hp ?? '-'}}</td>
                                                    <td>{{ $detail->alamat_domisili ?? '-' }}</td>
                                                    <td>{{ $detail->kode_pos ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
