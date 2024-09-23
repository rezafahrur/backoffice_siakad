@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Kelas</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>

    <div class="card w-20">
        <div class="card-header">
            <h3 class="card-title">Detail Kelas</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="nama_kelas" class="col-md-2 col-form-label">Nama Kelas</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="nama_kelas" value="{{ $kelas->nama_kelas }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="program_studi" class="col-md-2 col-form-label">Program Studi</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="program_studi"
                        value="{{ $kelas->programStudi->nama_program_studi ?? 'N/A' }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="semester" class="col-md-2 col-form-label">Semester</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="semester"
                        value="{{ $kelas->semester->nama_semester ?? 'N/A' }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tanggal_mulai" class="col-md-2 col-form-label">Tanggal Mulai</label>
                <div class="col-md-10">
                    <input type="date" class="form-control" id="tanggal_mulai" value="{{ $kelas->tanggal_mulai }}"
                        readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="tanggal_akhir" class="col-md-2 col-form-label">Tanggal Akhir</label>
                <div class="col-md-10">
                    <input type="date" class="form-control" id="tanggal_akhir" value="{{ $kelas->tanggal_akhir }}"
                        readonly>
                </div>
            </div>

            <div class="row mb-3">
                <label for="kurikulum" class="col-md-2 col-form-label">Kurikulum</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="kurikulum"
                        value="{{ $kelas->kurikulum->nama_kurikulum ?? 'N/A' }}" readonly>
                </div>
            </div>

            <h5 class="my-4">Detail Mata Kuliah Kelas:</h5>

            @if ($kelas->details->isEmpty())
                <div class="alert alert-warning" role="alert"> Tidak ada detail paket kelas. </div>
            @else
                {{-- <div class="detail-item mb-4">
                        <hr class="my-3">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Mata Kuliah</label>
                                <input type="text" class="form-control"
                                    value="{{ $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'Unavailable' }}"
                                    readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" value="{{ $detail->description }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>Lingkup Kelas</label>
                                <input type="text" class="form-control"
                                    value="@if ($detail->lingkup_kelas == 1) Internal
                                           @elseif($detail->lingkup_kelas == 2) Eksternal
                                           @else Campuran @endif"
                                    readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Mode Kelas</label>
                                <input type="text" class="form-control"
                                    value="@if ($detail->mode_kelas == 'O') Online
                                           @elseif($detail->mode_kelas == 'F') Offline
                                           @else Campuran @endif"
                                    readonly>
                            </div>
                        </div>
                    </div> --}}
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
                                <th scope="col">Aktivitas Partisipatif</th>
                                <th scope="col">Hasil Proyek</th>
                                <th scope="col">Tugas</th>
                                <th scope="col">Quiz</th>
                                <th scope="col">UTS</th>
                                <th scope="col">UAS</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas->details as $detail)
                                <tr>
                                    <td>{{ $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'N/A' }}</td>
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
                                    <td>{{ $detail->aktivitas_partisipatif }}</td>
                                    <td>{{ $detail->hasil_proyek }}</td>
                                    <td>{{ $detail->tugas }}</td>
                                    <td>{{ $detail->quiz }}</td>
                                    <td>{{ $detail->uts }}</td>
                                    <td>{{ $detail->uas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <a href="{{ route('kelast.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
@endsection
