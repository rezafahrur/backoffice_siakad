@extends('layouts.app')

@section('title', 'Detail Rencana Pembelajaran')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('pembelajaran_plans.index') }}">Rencana Pembelajaran</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Detail Rencana Pembelajaran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="matakuliah_id">Matakuliah</label>
                        <input type="text" class="form-control"
                            value="{{ $pembelajaranPlan->matakuliah->nama_matakuliah }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="program_studi_name">Program Studi</label>
                        <input type="text" class="form-control"
                            value="{{ $pembelajaranPlan->programStudi->nama_program_studi }}" readonly>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-md-2">Pertemuan</th>
                            <th>Materi (Indo)</th>
                            <th>Materi (Eng)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelajaranPlan->details as $detail)
                            <tr>
                                <td>{{ $detail->pertemuan }}</td>
                                <td>{{ $detail->materi_indo }}</td>
                                <td>{{ $detail->materi_eng }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <a href="{{ route('pembelajaran_plans.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
