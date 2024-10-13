@extends('layouts.app')

@section('title', 'Data Rencana Pembelajaran')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Rencana Pembelajaran</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Rencana Pembelajaran</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('pembelajaran_plans.create') }}"
                                class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                            <a href="{{ route('pembelajaran_plans.export') }}" class="btn btn-success btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="download"></i>
                                Export
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>Program Studi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($plans as $pp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pp->matakuliah->nama_matakuliah }}</td>
                                        <td>{{ $pp->programStudi->nama_program_studi }}</td>
                                        <td>
                                            <a href="{{ route('pembelajaran_plans.edit', $pp->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('pembelajaran_plans.show', $pp->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('pembelajaran_plans.destroy', $pp->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-delete btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
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
