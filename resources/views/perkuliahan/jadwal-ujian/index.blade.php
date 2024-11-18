@extends('layouts.app')

@section('title', 'Jadwal Ujian')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jadwal Ujian</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Jadwal Ujian</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('jadwal-ujian.create') }}"
                                class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kelas</th>
                                    <th>Kode Jadwal Ujian</th>
                                    <th>Ruang Kelas</th>
                                    <th>Mata Kuliah</th>
                                    <th>Tanggal</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Akhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwalUjians as $jadwalUjian)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwalUjian->kelas->nama_kelas ?? 'Kelas tidak tersedia' }}</td>
                                        @foreach ($jadwalUjian->details->take(1) as $detail)
                                            <td>{{ $detail->kode_jadwal_ujian }}</td>
                                            <td>{{ $detail->ruangKelas->nama_ruang_kelas ?? 'Ruang Kelas tidak tersedia' }}</td>
                                            <td>{{ $detail->matakuliah->nama_matakuliah ?? 'Mata Kuliah tidak tersedia' }}</td>
                                            <td>{{ $detail->tanggal }}</td>
                                            <td>{{ $detail->jam_mulai }}</td>
                                            <td>{{ $detail->jam_akhir }}</td>
                                        @endforeach
                                    
                                        <td>
                                            <a href="{{ route('jadwal-ujian.edit', $jadwalUjian->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('jadwal-ujian.show', $jadwalUjian->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('jadwal-ujian.destroy', $jadwalUjian->id) }}"
                                                method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-delete btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
