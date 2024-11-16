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

                <div class="mb-3">
                    <label for="import_excel">Import Nilai</label>
                    <input type="file" id="import_excel" name="import_excel" class="form-control"
                        accept=".xlsx, .xls, .csv">
                    <button id="importButton" type="button" class="btn btn-success mt-2">Import Nilai</button>
                </div>

                <div id="mahasiswa-list">
                    <h4 class="card-title">Input Nilai Mahasiswa</h4>
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
                            <!-- Baris mahasiswa akan diisi secara dinamis menggunakan JavaScript -->
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Kembali</a>
                <button id="saveButton" type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('saveButton').addEventListener('click', function(event) {
            var matakuliahDropdown = document.getElementById('matakuliah');

            // Cek apakah mata kuliah sudah dipilih
            if (matakuliahDropdown.value === "") {
                event.preventDefault(); // Hentikan pengiriman formulir
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih mata kuliah terlebih dahulu sebelum menyimpan nilai.',
                });
            }
        });

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
                                        <input type="number" name="details[${mahasiswa.id}][hasil_proyek]" class="form-control nilai-input" placeholder="Nilai Proyek Akhir" value="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" name="details[${mahasiswa.id}][aktivitas_partisipatif]" class="form-control nilai-input" placeholder="Nilai Aktivitas Partisipatif" value="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" name="details[${mahasiswa.id}][quiz]" class="form-control nilai-input" placeholder="Nilai Quiz" value="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" name="details[${mahasiswa.id}][tugas]" class="form-control nilai-input" placeholder="Nilai Tugas" value="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" name="details[${mahasiswa.id}][uts]" class="form-control nilai-input" placeholder="Nilai UTS" value="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" name="details[${mahasiswa.id}][uas]" class="form-control nilai-input" placeholder="Nilai UAS" value="0" min="0" max="100">
                                    </td>
                                    <td>
                                        <input type="number" name="details[${mahasiswa.id}][nilai_angka]" class="form-control nilai-input" placeholder="Nilai Angka" value="0" min="0" max="100">
                                    </td>
                                    <td class="nilai-huruf"></td>
                                    <td class="nilai-indeks"></td>

                                    <!-- Tambahkan hidden input untuk nilai_huruf dan nilai_indeks -->
                                    <input type="hidden" name="details[${mahasiswa.id}][nilai_huruf]" class="nilai-huruf-input">
                                    <input type="hidden" name="details[${mahasiswa.id}][nilai_indeks]" class="nilai-indeks-input">
                                </tr>
                            `;


                                mahasiswaList.innerHTML += row;
                            });

                            // Tambahkan event listener untuk mencegah input lebih dari 100
                            const nilaiInputs = document.querySelectorAll('.nilai-input');
                            nilaiInputs.forEach(input => {
                                input.addEventListener('input', function() {
                                    if (parseInt(this.value) > 100) {
                                        this.value = 100; // Batasi nilai maksimal 100
                                    }
                                });
                            });
                        } else {
                            document.getElementById('nilai-table').style.display =
                                ''; // Sembunyikan tabel jika tidak ada data
                            mahasiswaList.innerHTML =
                                '<tr><td colspan="10" class="text-center">Tidak ada data mahasiswa di kelas ini</td></tr>'; // Tampilkan pesan tidak ada data
                        }
                    });
            } else {
                document.getElementById('nilai-table').style.display =
                    'none'; // Sembunyikan tabel jika kelas tidak dipilih
                document.getElementById('nilai-table').getElementsByTagName('tbody')[0].innerHTML =
                    ''; // Kosongkan tabel
            }
        });

        function calculateGradeAndIndex() {
            const nilaiTables = document.querySelectorAll('#nilai-table tbody tr');

            nilaiTables.forEach(row => {
                const nilaiAngka = parseFloat(row.querySelector('[name$="[nilai_angka]"]').value) || 0;

                let nilaiHuruf = '';
                let nilaiIndeks = 0.00;

                // Logika perhitungan nilai huruf dan indeks berdasarkan nilai angka
                if (nilaiAngka >= 85) {
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

                // Update nilai huruf dan indeks di tabel
                row.querySelector('.nilai-huruf').textContent = nilaiHuruf;
                row.querySelector('.nilai-indeks').textContent = nilaiIndeks.toFixed(2);

                // Update hidden input nilai_huruf dan nilai_indeks
                row.querySelector('.nilai-huruf-input').value = nilaiHuruf;
                row.querySelector('.nilai-indeks-input').value = nilaiIndeks.toFixed(2);
            });
        }

        // Event listener untuk semua input nilai
        document.getElementById('nilai-table').addEventListener('input', function(e) {
            calculateGradeAndIndex();
        });

        // import data excel
        document.getElementById('importButton').addEventListener('click', function() {
            const fileInput = document.getElementById('import_excel');
            const formData = new FormData();
            const programStudiId = document.getElementById('program_studi').value;
            const kelasId = document.getElementById('kelas').value;
            const matakuliahId = document.getElementById('matakuliah').value;

            if (!programStudiId || !kelasId || !matakuliahId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih Program Studi, Kelas, dan Mata Kuliah sebelum mengimpor nilai.',
                });
                return;
            }

            if (!fileInput.files[0]) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih file Excel untuk mengimpor nilai.',
                });
                return;
            }

            formData.append('file', fileInput.files[0]);
            formData.append('program_studi_id', programStudiId);
            formData.append('kelas_id', kelasId);
            formData.append('matakuliah_id', matakuliahId);

            fetch('/kuliah/nilai/import', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat mengimpor data.',
                    });
                });
        });
    </script>
@endpush
