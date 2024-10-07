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
                    <select name="program_studi_id" id="program_studi" class="form-control" disabled>
                        <option value="{{ $nilai->program_studi_id }}" selected>
                            {{ $nilai->programStudi->nama_program_studi }}
                        </option>
                    </select>
                    @error('program_studi_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tampilkan Kelas -->
                <div class="mb-3">
                    <label for="kelas">Kelas</label>
                    <select name="kelas_id" id="kelas" class="form-control" disabled>
                        <option value="{{ $nilai->kelas_id }}" selected>
                            {{ $nilai->kelas->nama_kelas }}
                        </option>
                    </select>
                    @error('kelas_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tampilkan Mata Kuliah -->
                <div class="mb-3">
                    <label for="matakuliah">Mata Kuliah</label>
                    <select name="matakuliah_id" id="matakuliah" class="form-control" disabled>
                        <option value="{{ $nilai->matakuliah_id }}" selected>
                            {{ $nilai->matakuliah->nama_matakuliah }}
                        </option>
                    </select>
                    @error('matakuliah_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <h4 class="card-title">Edit Nilai Mahasiswa</h4>
                <table class="table table-bordered mb-3" id="nilai-table">
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
                            <th>Nilai Huruf</th>
                            <th>Nilai Indeks</th>
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
                                        class="form-control nilai-input" value="{{ $detail->hasil_proyek }}" min="0"
                                        required>
                                </td>
                                <td>
                                    <input type="number"
                                        name="details[{{ $detail->mahasiswa_id }}][aktivitas_partisipatif]"
                                        class="form-control nilai-input" value="{{ $detail->aktivitas_partisipatif }}"
                                        min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][quiz]"
                                        class="form-control nilai-input" value="{{ $detail->quiz }}" min="0"
                                        required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][tugas]"
                                        class="form-control nilai-input" value="{{ $detail->tugas }}" min="0"
                                        required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][uts]"
                                        class="form-control nilai-input" value="{{ $detail->uts }}" min="0"
                                        required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][uas]"
                                        class="form-control nilai-input" value="{{ $detail->uas }}" min="0"
                                        required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $detail->mahasiswa_id }}][nilai_angka]"
                                        class="form-control nilai-input" value="{{ $detail->nilai_angka }}" min="0"
                                        required>
                                </td>

                                <!-- Tambahkan input hidden untuk nilai huruf dan indeks -->
                                <td>
                                    <input type="text" name="details[{{ $detail->mahasiswa_id }}][nilai_huruf]"
                                        class="form-control nilai-huruf" readonly>
                                </td>
                                <td>
                                    <input type="text" name="details[{{ $detail->mahasiswa_id }}][nilai_indeks]"
                                        class="form-control nilai-indeks" readonly>
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

@push('scripts')
    <script>
        const nilaiInputs = document.querySelectorAll('.nilai-input');
        nilaiInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (parseInt(this.value) > 100) {
                    this.value = 100; // Batasi nilai maksimal 100
                }
            });
        });

        function calculateGradeAndIndex() {
            const nilaiTables = document.querySelectorAll('#nilai-table tbody tr');

            nilaiTables.forEach(row => {
                const nilaiAngka = parseFloat(row.querySelector('[name$="[nilai_angka]"]').value) || 0;

                let nilaiHuruf = '';
                let nilaiIndeks = 0.00;

                // Logika perhitungan nilai huruf dan indeks berdasarkan nilai angka
                if (nilaiAngka >= 85 && nilaiAngka <= 100) {
                    nilaiHuruf = 'A';
                    nilaiIndeks = 4.00;
                } else if (nilaiAngka >= 80 && nilaiAngka < 85) {
                    nilaiHuruf = 'A-';
                    nilaiIndeks = 3.70;
                } else if (nilaiAngka >= 75 && nilaiAngka < 80) {
                    nilaiHuruf = 'B+';
                    nilaiIndeks = 3.30;
                } else if (nilaiAngka >= 70 && nilaiAngka < 75) {
                    nilaiHuruf = 'B';
                    nilaiIndeks = 3.00;
                } else if (nilaiAngka >= 65 && nilaiAngka < 70) {
                    nilaiHuruf = 'B-';
                    nilaiIndeks = 2.70;
                } else if (nilaiAngka >= 60 && nilaiAngka < 65) {
                    nilaiHuruf = 'C+';
                    nilaiIndeks = 2.30;
                } else if (nilaiAngka >= 55 && nilaiAngka < 60) {
                    nilaiHuruf = 'C';
                    nilaiIndeks = 2.00;
                } else if (nilaiAngka >= 50 && nilaiAngka < 55) {
                    nilaiHuruf = 'D';
                    nilaiIndeks = 1.00;
                } else {
                    nilaiHuruf = 'E';
                    nilaiIndeks = 0.00;
                }

                // Update nilai huruf dan indeks di input tersembunyi
                row.querySelector('.nilai-huruf').value = nilaiHuruf;
                row.querySelector('.nilai-indeks').value = nilaiIndeks.toFixed(2);
            });
        }

        // Event listener untuk semua input nilai
        document.getElementById('nilai-table').addEventListener('input', function(e) {
            calculateGradeAndIndex();
        });

        // Jalankan perhitungan saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function() {
            calculateGradeAndIndex();
        });
    </script>
@endpush
