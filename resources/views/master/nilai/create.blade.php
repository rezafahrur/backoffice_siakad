@extends('layouts.app')

@section('title', 'Form Create Nilai')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('nilai.index') }}">Nilai</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Nilai
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Nilai</h4>
            <form action="{{ route('nilai.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <!-- Pilih Program Studi -->
                <div class="mb-3">
                    <label for="program_studi">Program Studi</label>
                    <select name="program_studi_id" id="program_studi" class="form-control">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ($programStudi as $ps)
                            <option value="{{ $ps->id }}">{{ $ps->nama_program_studi }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tampilkan Kelas yang difilter -->
                <div class="mb-3">
                    <label for="kelas">Kelas</label>
                    <select name="kelas_id" id="kelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                    </select>
                </div>

                <!-- Tampilkan Mata Kuliah yang difilter -->
                <div class="mb-3">
                    <label for="matakuliah">Mata Kuliah</label>
                    <select name="matakuliah_id" id="matakuliah" class="form-control">
                        <option value="">-- Pilih Mata Kuliah --</option>
                    </select>
                </div>

                <div id="mahasiswa-list">
                    {{-- judul --}}
                    <h4 class="card-title">Input Nilai Mahasiswa</h4>
                    <table class="table table-bordered mb-3" id="nilai-table" style="display: none;">
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
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris mahasiswa akan diisi secara dinamis menggunakan JavaScript -->
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('program_studi').addEventListener('change', function() {
            const programStudiId = this.value;

            if (programStudiId) {
                fetch(`/nilai/getKelasMataKuliah/${programStudiId}`)
                    .then(response => response.json())
                    .then(data => {
                        const kelasSelect = document.getElementById('kelas');
                        const matakuliahSelect = document.getElementById('matakuliah');

                        // Hapus opsi sebelumnya
                        kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                        matakuliahSelect.innerHTML = '<option value="">-- Pilih Mata Kuliah --</option>';

                        // Tambah opsi baru untuk Kelas
                        data.kelas.forEach(kelas => {
                            kelasSelect.innerHTML +=
                                `<option value="${kelas.id}">${kelas.nama_kelas}</option>`;
                        });

                        // Tambah opsi baru untuk Mata Kuliah
                        data.matakuliah.forEach(matakuliah => {
                            matakuliahSelect.innerHTML +=
                                `<option value="${matakuliah.id}">${matakuliah.nama_matakuliah}</option>`;
                        });
                    });
            } else {
                // Kosongkan dropdown jika Program Studi tidak dipilih
                document.getElementById('kelas').innerHTML = '<option value="">-- Pilih Kelas --</option>';
                document.getElementById('matakuliah').innerHTML =
                    '<option value="">-- Pilih Mata Kuliah --</option>';
            }
        });

        document.getElementById('kelas').addEventListener('change', function() {
            const kelasId = this.value;

            if (kelasId) {
                fetch(`/nilai/get-mahasiswa/` + kelasId)
                    .then(response => response.json())
                    .then(data => {
                        const mahasiswaList = document.getElementById('nilai-table').getElementsByTagName(
                            'tbody')[0];
                        mahasiswaList.innerHTML = ''; // Kosongkan baris tabel sebelumnya

                        if (data.length > 0) {
                            document.getElementById('nilai-table').style.display =
                                ''; // Tampilkan tabel jika data ada

                            // Loop data mahasiswa dan buat baris tabel untuk input nilai setiap mahasiswa
                            data.forEach((mahasiswa, index) => {
                                const row = `
                            <tr>
                                <td>${mahasiswa.nama}</td>
                                <input type="hidden" name="details[${mahasiswa.id}][mahasiswa_id]" value="${mahasiswa.id}">

                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][hasil_proyek]" class="form-control" placeholder="Nilai Proyek Akhir" value="0">
                                </td>
                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][aktivitas_partisipatif]" class="form-control" placeholder="Nilai Aktivitas Partisipatif" value="0">
                                </td>
                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][quiz]" class="form-control" placeholder="Nilai Quiz" value="0">
                                </td>
                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][tugas]" class="form-control" placeholder="Nilai Tugas" value="0">
                                </td>
                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][uts]" class="form-control" placeholder="Nilai UTS" value="0">
                                </td>
                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][uas]" class="form-control" placeholder="Nilai UAS" value="0">
                                </td>
                                <td>
                                    <input type="number" name="details[${mahasiswa.id}][nilai_angka]" class="form-control" placeholder="Nilai Angka" value="0">
                                </td>

                            </tr>
                        `;

                                mahasiswaList.innerHTML += row;
                            });
                        } else {
                            document.getElementById('nilai-table').style.display =
                                'none'; // Sembunyikan tabel jika tidak ada data
                        }
                    });
            } else {
                document.getElementById('nilai-table').style.display =
                    'none'; // Sembunyikan tabel jika kelas tidak dipilih
                document.getElementById('nilai-table').getElementsByTagName('tbody')[0].innerHTML =
                    ''; // Kosongkan tabel
            }
        });
    </script>
@endpush
