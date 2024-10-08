@extends('layouts.app')

@section('title', 'Aktivitas Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Aktivitas Mahasiswa</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daftar Aktivitas Mahasiswa</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('aktivitas.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                            <a href="{{ route('aktivitas.export') }}" class="btn btn-success btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="download"></i>
                                Aktivitas Mahasiswa
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program Studi</th>
                                    <th>Semester</th>
                                    <th>Kode Aktivitas</th>
                                    <th>Judul</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($aktivitas as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->programStudi ? $item->programStudi->nama_program_studi : 'Data Tidak Ditemukan' }}
                                        </td>
                                        <td>{{ $item->semester ? $item->semester->nama_semester : 'Data Tidak Ditemukan' }}
                                        </td>
                                        <td>{{ $item->kode_aktivitas }}</td>
                                        <td>{{ $item->judul }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal_mulai)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal_selesai)) }}</td>
                                        <td>
                                            <a href="{{ route('aktivitas.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('aktivitas.show', $item->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('aktivitas.destroy', $item->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger btn-icon"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?');">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
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
