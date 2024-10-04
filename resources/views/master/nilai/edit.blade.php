@extends('layouts.app')

@section('title', 'Edit Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('nilai.index') }}">Data Nilai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Nilai</h4>
            <form action="{{ route('nilai.update', $nilai->id) }}" method="post">
                @csrf
                @method('put')

                <!-- Pilih Program Studi -->
                <div class="mb-3">
                    <label for="program_studi">Program Studi</label>
                    <select name="program_studi_id" id="program_studi" class="form-control">
                        <option value="{{ $nilai->program_studi_id }}" selected>
                            {{ $nilai->programStudi->nama_program_studi }}
                        </option>
                        <!-- Tambahkan opsi lain jika diperlukan -->
                    </select>
                    @error('program_studi_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tampilkan Kelas -->
                <div class="mb-3">
                    <label for="kelas">Kelas</label>
                    <select name="kelas_id" id="kelas" class="form-control">
                        <option value="{{ $nilai->kelas_id }}" selected>
                            {{ $nilai->kelas->nama_kelas }}
                        </option>
                        <!-- Tambahkan opsi lain jika diperlukan -->
                    </select>
                    @error('kelas_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tampilkan Mata Kuliah -->
                <div class="mb-3">
                    <label for="matakuliah">Mata Kuliah</label>
                    <select name="matakuliah_id" id="matakuliah" class="form-control">
                        <option value="{{ $nilai->matakuliah_id }}" selected>
                            {{ $nilai->matakuliah->nama_matakuliah }}
                        </option>
                        <!-- Tambahkan opsi lain jika diperlukan -->
                    </select>
                    @error('matakuliah_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <h4 class="card-title">Edit Nilai Mahasiswa</h4>
                <table class="table table-bordered mb-3">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Hasil Proyek</th>
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
                                <input type="hidden" name="details[{{ $detail->mahasiswa_id }}][mahasiswa_id]"
                                    value="{{ $detail->mahasiswa_id }}">
                                <td>{{ $detail->mahasiswa->nama }}</td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][hasil_proyek]"
                                        class="form-control" value="{{ $detail->hasil_proyek }}" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][aktivitas_partisipatif]"
                                        class="form-control" value="{{ $detail->aktivitas_partisipatif }}" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][quiz]"
                                        class="form-control" value="{{ $detail->quiz }}" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][tugas]"
                                        class="form-control" value="{{ $detail->tugas }}" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][uts]"
                                        class="form-control" value="{{ $detail->uts }}" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][uas]"
                                        class="form-control" value="{{ $detail->uas }}" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][nilai_angka]"
                                        class="form-control" value="{{ $detail->nilai_angka }}" min="0" required>
                                </td>
                                <td>
                                    <input type="text" name="details[{{ $detail->mahasiswa_id }}][nilai_indeks]"
                                        class="form-control" value="{{ $detail->nilai_indeks }}" min="0" required disabled>
                                </td>
                                <td>
                                    <input type="text" name="details[{{ $detail->mahasiswa_id }}][nilai_huruf]"
                                        class="form-control" value="{{ $detail->nilai_huruf }}" min="0" required disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
