@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Kelas</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
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
                                    <th>Nama Kelas</th>
                                    <th>Program Studi</th>
                                    <th>Semester</th>
                                    <th>Kurikulum</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kelas as $kl)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kl->nama_kelas }}</td>
                                        <td>{{ $kl->programStudi->nama_program_studi ?? 'N/A' }}</td>
                                        <td>{{ $kl->semester->nama_semester ?? 'N/A' }}</td>
                                        <td>{{ $kl->kurikulum->nama_kurikulum ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('kelas.edit', $kl->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('kelas.show', $kl->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('kelas.destroy', $kl->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger btn-icon">
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
