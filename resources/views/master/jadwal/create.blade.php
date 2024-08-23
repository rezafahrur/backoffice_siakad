@extends('layouts.custom')

@section('title', 'Form Tambah Paket Jadwal')

@section('content')
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('jadwal.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>

    <div class="card-header">
        <h3 class="card-title">Form Tambah Paket Jadwal</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Form Tambah Paket Jadwal -->
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="paket_matakuliah_id" class="form-label">Paket Mata Kuliah</label>
                    <select name="paket_matakuliah_id" id="paket_matakuliah_id" class="form-control"
                        onchange="fetchPaketDetails()">
                        <option value="">Pilih Paket Mata Kuliah</option>
                        @foreach ($paketMataKuliahs as $paketMataKuliah)
                            <option value="{{ $paketMataKuliah->id }}">{{ $paketMataKuliah->nama_paket_matakuliah }}
                            </option>
                        @endforeach
                    </select>
                    @error('paket_matakuliah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Detail Paket Jadwal -->
            <div id="jadwal-details">

            </div>

            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <script>
        function fetchPaketDetails() {
            var paketId = document.getElementById('paket_matakuliah_id').value;

            if (paketId) {
                fetch(`/jadwal/details/${paketId}`)
                    .then(response => response.json())
                    .then(data => {
                        let detailsDiv = document.getElementById('jadwal-details');
                        detailsDiv.innerHTML = ''; // Clear previous details

                        data.details.forEach(detail => {
                            let ruangKelasOptions = data.ruangKelas.map(rk =>
                                `<option value="${rk.id}">${rk.nama_ruang_kelas}</option>`).join('');
                            let hrOptions = data.hrs.map(hr => `<option value="${hr.id}">${hr.nama}</option>`)
                                .join('');

                            let detailField = `
                                <!-- Detail Paket Jadwal -->
                                <hr> <!-- Separator line between details -->
                                <div class="detail-paket-jadwal my-5">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Mata Kuliah</label>
                                            <input type="hidden" name="details[${detail.id}][paket_matakuliah_detail_id]" value="${detail.id}">
                                            <input type="text" class="form-control" value="${detail.matakuliah.nama_matakuliah}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Ruang Kelas</label>
                                            <select name="details[${detail.id}][ruang_kelas_id]" class="form-control" required>
                                                ${ruangKelasOptions}
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">HR</label>
                                            <select name="details[${detail.id}][hr_id]" class="form-control" required>
                                                ${hrOptions}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Hari</label>
                                            <select name="details[${detail.id}][jadwal_hari]" class="form-control" required>
                                                <option value="1">Senin</option>
                                                <option value="2">Selasa</option>
                                                <option value="3">Rabu</option>
                                                <option value="4">Kamis</option>
                                                <option value="5">Jumat</option>
                                                <option value="6">Sabtu</option>
                                                <option value="7">Minggu</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jam Mulai</label>
                                            <input type="time" name="details[${detail.id}][jadwal_jam_mulai]" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jam Selesai</label>
                                            <input type="time" name="details[${detail.id}][jadwal_jam_akhir]" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            `;
                            detailsDiv.insertAdjacentHTML('beforeend', detailField);
                        });
                    });
            } else {
                document.getElementById('jadwal-details').innerHTML = ''; // Clear if no Paket Mata Kuliah is selected
            }
        }
    </script>
@endsection
