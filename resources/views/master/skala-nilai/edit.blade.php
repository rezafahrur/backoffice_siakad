@extends('layouts.app')

@section('title', 'Edit Skala Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('skala-nilai.index') }}">Skala Nilai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Skala Nilai</h4>
            <form action="{{ route('skala-nilai.update', $skalaNilai->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-control @error('semester_id') is-invalid @enderror" id="semester_id" name="semester_id">
                            <option value="">Pilih Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ $skalaNilai->semester_id == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->kode_semester }} - {{ $semester->nama_semester }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="program_studi_id" class="form-label">Program Studi</label>
                        <select class="form-control @error('program_studi_id') is-invalid @enderror" id="program_studi_id" name="program_studi_id">
                            <option value="">Pilih Program Studi</option>
                            @foreach ($programStudis as $program_studi)
                                <option value="{{ $program_studi->id }}" {{ $skalaNilai->program_studi_id == $program_studi->id ? 'selected' : '' }}>
                                    {{ $program_studi->kode_prodi }} - {{ $program_studi->nama_program_studi }}
                                </option>
                            @endforeach
                        </select>
                        @error('program_studi_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> 

                    <div class="col-md-6">
                        <label for="nilai_huruf" class="form-label">Nilai Huruf</label>
                        <input type="text" class="form-control @error('nilai_huruf') is-invalid @enderror" id="nilai_huruf"
                            name="nilai_huruf" value="{{ old('nilai_huruf', $skalaNilai->nilai_huruf) }}">
                        @error('nilai_huruf')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nilai_indeks" class="form-label">Nilai Angka</label>
                        <input type="number" class="form-control @error('nilai_indeks') is-invalid @enderror" id="nilai_indeks"
                            name="nilai_indeks" value="{{ old('nilai_indeks', $skalaNilai->nilai_indeks) }}">
                        @error('nilai_indeks')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="bobot_minimum" class="form-label">Bobot Minimum</label>
                        <input type="number" class="form-control @error('bobot_minimum') is-invalid @enderror" id="bobot_minimum"
                            name="bobot_minimum" value="{{ old('bobot_minimum', $skalaNilai->bobot_minimum) }}">
                        @error('bobot_minimum')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="bobot_maksimum" class="form-label">Bobot Maksimum</label>
                        <input type="number" class="form-control @error('bobot_maksimum') is-invalid @enderror" id="bobot_maksimum"
                            name="bobot_maksimum" value="{{ old('bobot_maksimum', $skalaNilai->bobot_maksimum) }}">
                        @error('bobot_maksimum')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tgl_mulai_efektif" class="form-label">Tanggal Mulai Efektif</label>
                        <input type="date" class="form-control @error('tgl_mulai_efektif') is-invalid @enderror" id="tgl_mulai_efektif"
                            name="tgl_mulai_efektif" value="{{ old('tgl_mulai_efektif', $skalaNilai->tgl_mulai_efektif) }}">
                        @error('tgl_mulai_efektif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tgl_akhir_efektif" class="form-label">Tanggal Akhir Efektif</label>
                        <input type="date" class="form-control @error('tgl_akhir_efektif') is-invalid @enderror" id="tgl_akhir_efektif"
                            name="tgl_akhir_efektif" value="{{ old('tgl_akhir_efektif', $skalaNilai->tgl_akhir_efektif) }}">
                        @error('tgl_akhir_efektif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <a href="{{ route('skala-nilai.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
