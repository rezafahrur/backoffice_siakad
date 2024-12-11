@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Jadwal Ujian</h2>
    @if ($errors->has('update_error'))
        <script>
            console.error("{{ $errors->first('update_error') }}");
        </script>
        <div class="alert alert-danger">
            {{ $errors->first('update_error') }}
        </div>
    @endif

    <form action="{{ route('jadwal-ujian.update', $jadwalUjians->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label for="kelas_id" class="form-label">Kelas</label>
            <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id" name="kelas_id">
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $kls)
                    <option value="{{ $kls->id }}" {{ old('kelas_id', $jadwalUjians->kelas_id) == $kls->id ? 'selected' : '' }}>
                        {{ $kls->nama_kelas }}
                    </option>
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
                @foreach($jadwalUjians->details as $index => $detail)
                <tr>
                    <td>
                        <select class="form-control" name="details[{{ $index }}][ruang_kelas_id]" required>
                            <option value="">Pilih Ruang Kelas</option>
                            @foreach($ruangKelas as $ruang)
                                <option value="{{ $ruang->id }}" {{ $detail->ruang_kelas_id == $ruang->id ? 'selected' : '' }}>
                                    {{ $ruang->nama_ruang_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-control mata-kuliah-dropdown" name="details[{{ $index }}][matakuliah_id]" required>
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliah as $matkul)
                                <option value="{{ $matkul->id }}" {{ $detail->matakuliah_id == $matkul->id ? 'selected' : '' }}>
                                    {{ $matkul->nama_matakuliah }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="details[{{ $index }}][kode_jadwal_ujian]" value="{{ $detail->kode_jadwal_ujian }}" maxlength="10" required></td>
                    <td><input type="date" class="form-control" name="details[{{ $index }}][tanggal]" value="{{ $detail->tanggal }}" required></td>
                    <td><input type="time" class="form-control" name="details[{{ $index }}][jam_mulai]" value="{{ $detail->jam_mulai }}" required></td>
                    <td><input type="time" class="form-control" name="details[{{ $index }}][jam_akhir]" value="{{ $detail->jam_akhir }}" required></td>
                    <td>
                        <button type="button" class="btn btn-danger remove-detail">
                            <i class="btn-icon-prepend" data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
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
let detailIndex = {{ count($jadwalUjians->details) }};

// Fungsi untuk menambahkan baris baru
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

    tableBody.appendChild(row);
    detailIndex++;

    feather.replace();
});

// Event listener untuk tombol remove-detail (dengan event delegation)
document.getElementById('details-table').addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-detail')) {
        const row = event.target.closest('tr');
        row.remove();
    }
});

</script>
@endsection
