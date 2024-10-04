@extends('layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mata Kuliah</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Mata Kuliah</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
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
                                    <th>Program Studi</th>
                                    <th>Kode Matkul</th>
                                    <th>Nama Matkul</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($matkul as $mk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mk->nama_program_studi }}</td>
                                        <td>{{ $mk->kode_matakuliah }}</td>
                                        <td>{{ $mk->nama_matakuliah }}</td>
                                        <td>
                                            <a href="{{ route('mata-kuliah.edit', $mk->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('mata-kuliah.show', $mk->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('mata-kuliah.destroy', $mk->id) }}" method="post"
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
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
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
