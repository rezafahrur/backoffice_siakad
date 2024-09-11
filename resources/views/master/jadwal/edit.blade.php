@extends('layouts.app')

@section('title', 'Form Edit Paket Jadwal')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Jadwal</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Paket Jadwal</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Form Edit Paket Jadwal -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="paket_matakuliah_id" class="form-label">Paket Mata Kuliah</label>
                        <input type="text" name="paket_matakuliah_name" id="paket_matakuliah_name" class="form-control"
                            value="{{ $jadwal->paketMataKuliah->nama_paket_matakuliah }}" readonly>
                        <input type="hidden" name="paket_matakuliah_id" value="{{ $jadwal->paket_matakuliah_id }}">
                    </div>
                </div>

                <!-- Detail Paket Jadwal -->
                <div id="jadwal-details">
                    @foreach ($jadwal->details as $detail)
                        <hr>
                        <div class="detail-paket-jadwal my-5">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Mata Kuliah</label>
                                    <input type="hidden" name="details[{{ $detail->id }}][paket_matakuliah_detail_id]"
                                        value="{{ $detail->paket_matakuliah_detail_id }}">
                                    <input type="text" class="form-control"
                                        value="{{ $detail->paketMataKuliahDetail->matakuliah->nama_matakuliah }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Ruang Kelas</label>
                                    <select name="details[{{ $detail->id }}][ruang_kelas_id]" class="form-control"
                                        required>
                                        @foreach ($ruangKelas as $rk)
                                            <option value="{{ $rk->id }}"
                                                {{ $detail->ruang_kelas_id == $rk->id ? 'selected' : '' }}>
                                                {{ $rk->nama_ruang_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">HR</label>
                                    <select name="details[{{ $detail->id }}][hr_id]" class="form-control" required>
                                        @foreach ($hrs as $hr)
                                            <option value="{{ $hr->id }}"
                                                {{ $detail->hr_id == $hr->id ? 'selected' : '' }}>
                                                {{ $hr->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Hari</label>
                                    <select name="details[{{ $detail->id }}][jadwal_hari]" class="form-control" required>
                                        <option value="1" {{ $detail->jadwal_hari == 1 ? 'selected' : '' }}>Senin
                                        </option>
                                        <option value="2" {{ $detail->jadwal_hari == 2 ? 'selected' : '' }}>Selasa
                                        </option>
                                        <option value="3" {{ $detail->jadwal_hari == 3 ? 'selected' : '' }}>Rabu
                                        </option>
                                        <option value="4" {{ $detail->jadwal_hari == 4 ? 'selected' : '' }}>Kamis
                                        </option>
                                        <option value="5" {{ $detail->jadwal_hari == 5 ? 'selected' : '' }}>Jumat
                                        </option>
                                        <option value="6" {{ $detail->jadwal_hari == 6 ? 'selected' : '' }}>Sabtu
                                        </option>
                                        <option value="7" {{ $detail->jadwal_hari == 7 ? 'selected' : '' }}>Minggu
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jam Mulai</label>
                                    <input type="time" name="details[{{ $detail->id }}][jadwal_jam_mulai]"
                                        value="{{ $detail->jadwal_jam_mulai }}" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jam Selesai</label>
                                    <input type="time" name="details[{{ $detail->id }}][jadwal_jam_akhir]"
                                        value="{{ $detail->jadwal_jam_akhir }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
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
                            detailsDiv.innerHTML += detailField;
                        });
                    })
                    .catch(error => console.log('Error:', error));
            }
        }
    </script>
@endpush
