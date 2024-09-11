@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('paket-matakuliah.index') }}">Kurikulum</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Kurikulum</li>
        </ol>
    </nav>

    <!-- Detail Paket Mata Kuliah -->

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $paketMatakuliah->nama_paket_matakuliah }}</h5>
        </div>
        <div class="card-body">
            <div class="mb-2">
                <strong>Program Studi:</strong>
                <span class="badge bg-secondary">{{ $paketMatakuliah->programStudi->nama_program_studi }}</span>
            </div>
            <div class="mb-2">
                <strong>Semester:</strong>
                <span class="badge bg-info">{{ $paketMatakuliah->semester }}</span>
            </div>
            <div>
                <strong>Status:</strong>
                <span class="badge {{ $paketMatakuliah->status == '1' ? 'bg-success' : 'bg-danger' }}">
                    {{ $paketMatakuliah->status == '1' ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>
        </div>
        <div class="card-header">
            <h6 class="mb-0">Daftar Mata Kuliah :</h6>
        </div>
        <div class="card-body">
            @if ($paketMatakuliah->paketMataKuliahDetail->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Tidak ada mata kuliah yang ditambahkan pada paket ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nama Matakuliah</th>
                                <th scope="col">Kode Mata Kuliah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paketMatakuliah->paketMataKuliahDetail as $detail)
                                <tr>
                                    <td>{{ $detail->matakuliah->nama_matakuliah }}</td>
                                    <td>{{ $detail->matakuliah->kode_matakuliah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
