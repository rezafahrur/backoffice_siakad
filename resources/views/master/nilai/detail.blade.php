@extends('layouts.app')

@section('title', 'Detail Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('nilai.index') }}">Data Nilai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Nilai</h4>

            <div class="mb-3">
                <strong class="me-2">Program Studi:</strong>
                {{ $nilai->programStudi->nama_program_studi }}
            </div>

            <div class="mb-3">
                <strong class="me-2">Kelas:</strong>
                {{ $nilai->kelas->nama_kelas }}
            </div>

            <div class="mb-3">
                <strong class="me-2">Mata Kuliah:</strong>
                {{ $nilai->matakuliah->nama_matakuliah }}
            </div>

            <div class="table-responsive mb-3">
                <h4 class="card-title">Detail Nilai Mahasiswa</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Proyek Akhir</th>
                            <th>Aktivitas Partisipatif</th>
                            <th>Quiz</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>UAS</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Indeks</th>
                            <th>Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai->details as $detail)
                            <tr>
                                <td>{{ $detail->mahasiswa->nama }}</td>
                                <td>{{ $detail->hasil_proyek }}</td>
                                <td>{{ $detail->aktivitas_partisipatif }}</td>
                                <td>{{ $detail->quiz }}</td>
                                <td>{{ $detail->tugas }}</td>
                                <td>{{ $detail->uts }}</td>
                                <td>{{ $detail->uas }}</td>
                                <td>{{ $detail->nilai_angka }}</td>
                                <td>{{ $detail->nilai_indeks }}</td>
                                <td>{{ $detail->nilai_huruf }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
