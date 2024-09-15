@extends('layouts.app')

@section('title', 'Detail Kurikulum')

@push('styles')
    <style></style>
@endpush

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
            <h5 class="mb-0">Detail Kurikulum</h5>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="row">
                        {{-- nama kurikulum --}}
                        <dt class="col-sm-4">Nama Kurikulum</dt>
                        <dd class="col-sm-8">{{ $kurikulum->nama_kurikulum }}</dd>

                        {{-- program studi --}}
                        <dt class="col-sm-4">Program Studi</dt>
                        <dd class="col-sm-8">{{ $kurikulum->programStudi->nama_program_studi }}</dd>

                        {{-- semester --}}
                        <dt class="col-sm-4">Semester</dt>
                        <dd class="col-sm-8">{{ $kurikulum->semester_angka }} - {{ $kurikulum->semesters->nama_semester }}
                        </dd>

                        {{-- status --}}
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ $kurikulum->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                {{ $kurikulum->status == '1' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </dd>

                        {{-- sks lulus --}}
                        <dt class="col-sm-4">SKS Lulus</dt>
                        <dd class="col-sm-8">{{ $kurikulum->sum_sks_lulus }}</dd>

                        {{-- sks wajib --}}
                        <dt class="col-sm-4">SKS Wajib</dt>
                        <dd class="col-sm-8">{{ $kurikulum->sum_sks_wajib }}</dd>

                        {{-- sks pilihan --}}
                        <dt class="col-sm-4">SKS Pilihan</dt>
                        <dd class="col-sm-8">{{ $kurikulum->sum_sks_pilihan }}</dd>

                    </div>
                </div>
            </div>

            <h6 class="card-title">Detail Mata Kuliah:</h6>

            @if ($kurikulum->kurikulumDetails->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Tidak ada paket mata kuliah yang ditambahkan pada kurikulum ini.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Nama Mata Kuliah</th>
                                <th scope="col">Kode Mata Kuliah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kurikulum->kurikulumDetails as $details)
                                <tr>
                                    <td>{{ $details->matakuliah->nama_matakuliah }}</td>
                                    <td>{{ $details->matakuliah->kode_matakuliah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif

        </div>
    </div>



@endsection
