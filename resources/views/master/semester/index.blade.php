@extends('layouts.app')

@section('title', 'Data Semester')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Semester</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Semester</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('semester.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
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
                                    <th>Kode Semester</th>
                                    <th>Nama Semester</th>
                                    <th>Tahun Akademik</th>
                                    <th>Semester</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semester as $sm)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sm->kode_semester }}</td>
                                        <td>{{ $sm->nama_semester }}</td>
                                        <td>{{ $sm->tahun_awal . '/' . $sm->tahun_akhir }}</td>
                                        <!-- Adjust this column based on your data -->
                                        <td>
                                            @if ($sm->semester == 1)
                                                Ganjil
                                            @elseif($sm->semester == 2)
                                                Genap
                                            @else
                                                Pendek
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('semester.edit', $sm->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            {{-- <a href="{{ route('semester.show', $sm->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a> --}}
                                            <form action="{{ route('semester.destroy', $sm->id) }}" method="post"
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
