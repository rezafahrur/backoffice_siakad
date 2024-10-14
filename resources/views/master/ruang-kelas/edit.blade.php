@extends('layouts.app')

@section('title', 'Form Edit Ruang Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('ruang-kelas.index') }}">Ruang Kelas</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit Ruang Kelas
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Edit Ruang Kelas</h4>
            <form id="kelasForm" action="{{ route('ruang-kelas.update', $ruangKelas->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Input Kode Ruang Kelas -->
                <div class="mb-3">
                    <label for="kode_ruang_kelas" class="form-label">Kode Ruang Kelas</label>
                    <input type="text" class="form-control @error('kode_ruang_kelas') is-invalid @enderror"
                        id="kode_ruang_kelas" name="kode_ruang_kelas" placeholder="Kode Ruang Kelas"
                        value="{{ old('kode_ruang_kelas', $ruangKelas->kode_ruang_kelas) }}" required>
                    @error('kode_ruang_kelas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Input Nama Ruang Kelas -->
                <div class="mb-3">
                    <label for="nama_ruang_kelas" class="form-label">Nama Ruang Kelas</label>
                    <input type="text" name="nama_ruang_kelas"
                        class="form-control @error('nama_ruang_kelas') is-invalid @enderror" id="nama_ruang_kelas"
                        value="{{ old('nama_ruang_kelas', $ruangKelas->nama_ruang_kelas) }}" required>
                    @error('nama_ruang_kelas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Input Kapasitas -->
                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="text" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                        id="kapasitas" value="{{ old('kapasitas', $ruangKelas->kapasitas) }}" required>
                    @error('kapasitas')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Form Generate Hari dan Jam (untuk jadwal baru) -->
                <div class="row mb-3">
                    <h4 class="card-title">Generate Hari dan Jam</h4>

                    <!-- Pilih Hari (Range) -->
                    <div class="form-group col-sm-2">
                        <label for="day_range_start">Pilih Hari Mulai</label>
                        <select name="day_range_start" id="day_range_start" class="form-control">
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="day_range_end">Pilih Hari Akhir</label>
                        <select name="day_range_end" id="day_range_end" class="form-control">
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Jam Mulai -->
                    <div class="form-group col-sm-2">
                        <label for="start_time">Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" value="07:00">
                    </div>

                    <!-- Pilih Jam Selesai -->
                    <div class="form-group col-sm-2">
                        <label for="end_time">Jam Selesai</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" value="17:00">
                    </div>

                    <!-- Pilih Durasi Sesi -->
                    <div class="form-group col-sm-2">
                        <label for="session_duration">Durasi Sesi (menit)</label>
                        <input type="number" name="session_duration" id="session_duration" class="form-control"
                            value="60" min="1">
                    </div>

                    <div class="form-group col-sm-2" style="position: relative;">
                        <button type="button" class="btn btn-primary" onclick="generateSchedule()"
                            style="position: absolute; bottom: 0; left: 0;">
                            <i class="btn-icon-prepend" data-feather="refresh-cw" style="width: 1em; height: 1em;"></i>
                        </button>
                    </div>
                </div>

                <div id="schedule-display" class="mt-3"></div>
                <div id="schedule-container" class="mt-3" style="display: none;"></div>

                <!-- Tombol Kembali dan Simpan -->
                <a href="{{ route('ruang-kelas.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                <button type="submit" id="submitButton" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function generateSchedule() {
            const daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            let startDay = document.getElementById('day_range_start').value;
            let endDay = document.getElementById('day_range_end').value;
            let startTime = document.getElementById('start_time').value;
            let endTime = document.getElementById('end_time').value;
            let sessionDuration = parseInt(document.getElementById('session_duration').value);

            let startIndex = daysOfWeek.indexOf(startDay);
            let endIndex = daysOfWeek.indexOf(endDay);

            let scheduleContainer = document.getElementById('schedule-container');
            let scheduleDisplay = document.getElementById('schedule-display');
            scheduleContainer.innerHTML = '';
            scheduleDisplay.innerHTML = '';

            let tableHtml = '<table class="table table-bordered"><thead><tr>';

            // Add day headers
            for (let i = startIndex; i <= endIndex; i++) {
                tableHtml += `<th>${daysOfWeek[i]}</th>`;
            }
            tableHtml += '</tr></thead><tbody>';

            let currentTime = startTime;
            while (currentTime < endTime) {
                let sessionEnd = addMinutes(currentTime, sessionDuration);
                if (sessionEnd > endTime) break;

                for (let i = startIndex; i <= endIndex; i++) {
                    let day = daysOfWeek[i];
                    let scheduleInput = `
                <input type="hidden" name="schedules[${day}][${currentTime}][jam_awal]" value="${currentTime}">
                <input type="hidden" name="schedules[${day}][${currentTime}][jam_akhir]" value="${sessionEnd}">
            `;
                    scheduleContainer.innerHTML += scheduleInput;

                    tableHtml += `<td>${currentTime} - ${sessionEnd}</td>`;
                }

                tableHtml += '</tr>';
                currentTime = sessionEnd;
            }

            tableHtml += '</tbody></table>';
            scheduleDisplay.innerHTML = tableHtml;

            // Tampilkan tombol submit
            document.getElementById('submitButton').style.display = 'inline-block';
        }

        function addMinutes(time, minsToAdd) {
            let [hours, minutes] = time.split(':').map(Number);
            minutes += minsToAdd;
            hours += Math.floor(minutes / 60);
            minutes = minutes % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }
    </script>
@endpush
