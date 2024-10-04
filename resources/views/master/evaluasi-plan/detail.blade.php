@extends('layouts.app')

@section('title', 'Detail Rencana Evaluasi')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('evaluasi_plan.index') }}">Rencana Evaluasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Detail Rencana Evaluasi</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong class="me-2">Matakuliah:</strong>
                {{ $evaluasiPlan->matakuliah->nama_matakuliah }}
            </div>
            <div class="mb-3">
                <strong class="me-2">Program Studi:</strong>
                {{ $evaluasiPlan->programStudi->nama_program_studi }}
            </div>
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Evaluasi</th>
                            <th>Nama Evaluasi</th>
                            <th>Deskripsi (Indo)</th>
                            <th>Deskripsi (Eng)</th>
                            <th>Bobot</th>
                            <th>No Urut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluasiPlan->details as $detail)
                            <tr>
                                <td>{{ $detail->jenis_evaluasi }}</td>
                                <td>{{ $detail->nama_evaluasi }}</td>
                                <td class="text-wrap">{{ $detail->desc_indo }}</td>
                                <td class="text-wrap">{{ $detail->desc_eng }}</td>
                                <td>{{ $detail->bobot }}</td>
                                <td>{{ $detail->no_urut }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('evaluasi_plan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
