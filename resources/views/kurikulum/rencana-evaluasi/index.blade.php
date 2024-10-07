@extends('layouts.app')

@section('title', 'Rencana Evaluasi')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Rencana Evaluasi</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Rencana Evaluasi</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('evaluasi_plan.create') }}"
                                class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                            <a href="{{ route('evaluasi_plan.export') }}" class="btn btn-success btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="download"></i>
                                Export
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Matakuliah</th>
                                    <th>Program Studi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluasiPlans as $evaluasiPlan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $evaluasiPlan->matakuliah->nama_matakuliah }}</td>
                                        <td>{{ $evaluasiPlan->programStudi->nama_program_studi }}</td>
                                        <td>
                                            <a href="{{ route('evaluasi_plan.edit', $evaluasiPlan->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('evaluasi_plan.show', $evaluasiPlan->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('evaluasi_plan.destroy', $evaluasiPlan->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection