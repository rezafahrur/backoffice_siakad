@extends('layouts.app')

@section('title', 'Periode Perkuliahan')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Periode Perkuliahan</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Periode Perkuliahan</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('periode-perkuliahan.create') }}"
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
                                    <th>Semester</th>
                                    <th>Jumlah Target Mhs Baru</th>
                                    <th>Jumlah Daftar Ulang</th>
                                    <th>Kode Prodi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($periodePerkuliahans as $periode)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $periode->semester->nama_semester }}</td>
                                        <td>{{ $periode->jml_target_mhs_baru }}</td>
                                        <td>{{ $periode->jml_daftar_ulang }}</td>
                                        <td>{{ $periode->programStudi->nama_program_studi }}</td>
                                        <td>
                                            <a href="{{ route('periode-perkuliahan.edit', $periode->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('periode-perkuliahan.show', $periode->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('periode-perkuliahan.destroy', $periode->id) }}"
                                                method="post" class="d-inline">
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
