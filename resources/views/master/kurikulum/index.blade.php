@extends('layouts.app')

@section('title', 'Data Kurikulum')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kurikulum</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Kurikulum</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('kurikulum.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                            <a href="{{ route('kurikulum.export') }}" class="btn btn-success btn-icon">
                                <i class="btn-icon-prepend" data-feather="download"></i>

                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kurikulum</th>
                                    <th>Semester</th>
                                    <th>Program Studi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kurikulums as $kr)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $kr->nama_kurikulum }}</td>
                                        <td>{{ $kr->semester_angka }} - {{ $kr->semesters->nama_semester }}</td>
                                        <td>{{ $kr->programStudi->nama_program_studi }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $kr->status == '1' ? 'bg-success' : 'bg-danger' }}">{{ $kr->status == '1' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('kurikulum.edit', $kr->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('kurikulum.show', $kr->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('kurikulum.destroy', $kr->id) }}" method="post"
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
                                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
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
