@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Jadwal Ujian</h2>
    
    <form action="{{ route('jadwal-ujian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12 mb-3">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id" required>
                <option value="">Pilih Kelas</option>
                @foreach($kelas as $kls)
                    <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
                @endforeach
            </select>
            @error('kelas_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Ruang Kelas</th>
                    <th>Mata Kuliah</th>
                    <th>Kode Jadwal Ujian</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="details-table">
                <tr>
                    <td>
                        <select class="form-control" name="details[0][ruang_kelas_id]" required>
                            <option value="">Pilih Ruang Kelas</option>
                            @foreach($ruangKelas as $ruang)
                                <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang_kelas }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-control mata-kuliah-dropdown" name="details[0][matakuliah_id]" required>
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliah as $matkul)
                                <option value="{{ $matkul->id }}">{{ $matkul->nama_matakuliah }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td><input type="text" class="form-control" name="details[0][kode_jadwal_ujian]" maxlength="10" required></td>
                    <td><input type="date" class="form-control" name="details[0][tanggal]" required></td>
                    <td><input type="time" class="form-control" name="details[0][jam_mulai]" required></td>
                    <td><input type="time" class="form-control" name="details[0][jam_akhir]" required></td>
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

        <button type="submit" class="btn btn-success">Simpan</button>

        <div id="error-alert" class="alert alert-danger d-none" role="alert">
            Gagal memuat Mata Kuliah. Silakan coba lagi atau hubungi admin.
        </div>
    </form>
</div>

<script>
    let detailIndex = 0;

    document.getElementById('add-detail').addEventListener('click', function () {
    const tableBody = document.getElementById('details-table');
    const row = document.createElement('tr');

    row.innerHTML = `
    <td>
                <select class="form-control" name="details[${detailIndex}][ruang_kelas_id]" required>
                    <option value="">Pilih Ruang Kelas</option>
                    @foreach($ruangKelas as $ruang)
                        <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang_kelas }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select class="form-control mata-kuliah-dropdown" name="details[${detailIndex}][matakuliah_id]" required>
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach($mataKuliah as $matkul)
                        <option value="{{ $matkul->id }}">{{ $matkul->nama_matakuliah }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" class="form-control" name="details[${detailIndex}][kode_jadwal_ujian]" maxlength="10" required></td>
            <td><input type="date" class="form-control" name="details[${detailIndex}][tanggal]" required></td>
            <td><input type="time" class="form-control" name="details[${detailIndex}][jam_mulai]" required></td>
            <td><input type="time" class="form-control" name="details[${detailIndex}][jam_akhir]" required></td>
            <td>
                <button type="button" class="btn btn-danger remove-detail">
                    <i class="btn-icon-prepend" data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                </button>
            </td>
    `;

    tableBody.appendChild(row); // Fixed typo here
    detailIndex++;  // Increment index for the next row

    feather.replace();

    row.querySelector('.remove-detail').addEventListener('click', function () {
        row.remove();
    });
});



    </script>
@endsection
