@extends('layouts.app')
@section('title', 'Aktivitas Peserta')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Aktivitas Mahasiswa Peserta</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daftar Aktivitas Mahasiswa Peserta</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                        <a href="{{ route('aktivitas-peserta.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                            <i class="btn-icon-prepend" data-feather="plus-square"></i>
                            Tambah Data
                        </a>
                        <a href="{{ route('aktivitas-peserta.export') }}" class="btn btn-success btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="download"></i>
                            Aktivitas Mahasiswa Peserta
                        </a>
                    </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Aktivitas</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Nama Prodi</th>
                                    <th>Kode Matakuliah</th>
                                    <th>Nama Matakuliah</th>
                                    <th>SKS</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peserta as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td> <!-- Penomoran otomatis -->
                                        <td>{{ $item->aktivitasMahasiswa->kode_aktivitas }}</td> <!-- relasi ke aktivitas mahasiswa -->
                                        <td>{{ $item->mahasiswa->nama }}</td>
                                        <td>{{ $item->programStudi->nama_program_studi }}</td>
                                        <td>{{ $item->matakuliah->kode_matakuliah }}</td>
                                        <td>{{ $item->matakuliah->nama_matakuliah }}</td>
                                        <td>{{ $item->sks }}</td>
                                        <td>
                                            <a href="{{ route('aktivitas-peserta.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('aktivitas-peserta.show', $item->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('aktivitas-peserta.destroy', $item->id) }}"
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
                                        <td colspan="13" class="text-center">Data tidak ditemukan</td>
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