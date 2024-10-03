@extends('layouts.app')

@section('title', 'Create Skala Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('skala-nilai.index') }}">Skala Nilai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Skala Nilai</h4>
            <form action="{{ route('skala-nilai.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-control @error('semester_id') is-invalid @enderror" id="semester_id" name="semester_id">
                            <option value="">Pilih Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
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
                                <option value="{{ $program_studi->id }}" {{ old('program_studi_id') == $program_studi->id ? 'selected' : '' }}>
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
                        <label for="tgl_mulai_efektif" class="form-label">Tanggal Mulai Efektif</label>
                        <input type="date" class="form-control @error('tgl_mulai_efektif') is-invalid @enderror" id="tgl_mulai_efektif"
                            name="tgl_mulai_efektif" value="{{ old('tgl_mulai_efektif') }}">
                        @error('tgl_mulai_efektif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tgl_akhir_efektif" class="form-label">Tanggal Akhir Efektif</label>
                        <input type="date" class="form-control @error('tgl_akhir_efektif') is-invalid @enderror" id="tgl_akhir_efektif"
                            name="tgl_akhir_efektif" value="{{ old('tgl_akhir_efektif') }}">
                        @error('tgl_akhir_efektif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Button Add Detail -->
                {{-- <div class="mb-3">
                    <button type="button" class="btn btn-primary" id="add-detail">Add Detail</button>
                </div> --}}

                <!-- Tabel untuk Detail Skala Nilai -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 160px;">Bobot Minimum</th>
                            <th style="width: 160px;">Bobot Maksimum</th>
                            <th>Nilai Huruf</th>
                            <th>Nilai Indeks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="details-table">
                        <!-- Baris input detail akan ditambahkan di sini oleh JavaScript -->
                        <tr class="detail-item">
                            <td>
                                <input type="number" step="0.01" class="form-control" name="details[0][bobot_minimum]" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="details[0][bobot_maksimum]" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="details[0][nilai_huruf]" maxlength="1" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="details[0][nilai_indeks]" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-detail">
                                    <i class="btn-icon-prepend" data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                </button>
                            </td>
                            
                            
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="add-detail" class="btn btn-sm btn-success btn-icon">
                        <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                    </button>
                </div>

                <a href="{{ route('skala-nilai.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
let detailIndex = 0;

document.getElementById('add-detail').addEventListener('click', function () {
    const tableBody = document.getElementById('details-table');
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>
            <input type="number" step="0.01" class="form-control" name="details[${detailIndex}][bobot_minimum]" required>
        </td>
        <td>
            <input type="number" step="0.01" class="form-control" name="details[${detailIndex}][bobot_maksimum]" required>
        </td>
        <td>
            <input type="text" class="form-control" name="details[${detailIndex}][nilai_huruf]" maxlength="1" required>
        </td>
        <td>
            <input type="number" step="0.01" class="form-control" name="details[${detailIndex}][nilai_indeks]" required>
        </td>
        <td>
            <button type="button" class="btn btn-danger remove-detail">
                <i class="btn-icon-prepend" data-feather="trash-2" style="width: 16px; height: 16px;"></i>
            </button>
        </td>
    `;

    tableBody.appendChild(row);
    detailIndex++;  // Increment index for the next row

    feather.replace();

    row.querySelector('.remove-detail').addEventListener('click', function () {
        row.remove();
    });
});


    </script>
@endsection

