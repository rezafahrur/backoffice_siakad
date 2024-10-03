@extends('layouts.app')

@section('title', 'Data Skala Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Skala Nilai</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Skala Nilai</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('skala-nilai.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
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
                                    <th>Semester</th>
                                    <th>Program Studi</th>
                                    <th>Tanggal Mulai Efektif</th>
                                    <th>Tanggal Akhir Efektif</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($skalaNilai as $skala)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $skala->semester->nama_semester }}</td>
                                        <td>{{ $skala->programStudi->nama_program_studi }}</td>
                                        <td>{{ $skala->tgl_mulai_efektif }}</td>
                                        <td>{{ $skala->tgl_akhir_efektif }}</td>

                                        <td>
                                            <a href="{{ route('skala-nilai.edit', $skala->id) }}"
                                                class="btn btn-skala btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('skala-nilai.show', $skala->id) }}"
                                                class="btn btn-skala btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('skala-nilai.destroy', $skala->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-skala btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data Kosong</td>
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
