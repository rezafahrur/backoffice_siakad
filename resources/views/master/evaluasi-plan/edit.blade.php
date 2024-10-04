@extends('layouts.app')

@section('title', 'Edit Rencana Evaluasi')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('evaluasi_plan.index') }}">Rencana Evaluasi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Rencana Evaluasi</h4>
            <form id="evaluasi-form" action="{{ route('evaluasi_plan.update', $evaluasiPlan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="matakuliah_id">Matakuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-control" required>
                                <option value="">Select Matakuliah</option>
                                @foreach ($matakuliah as $mk)
                                    <option value="{{ $mk->id }}"
                                        {{ $mk->id == $evaluasiPlan->matakuliah_id ? 'selected' : '' }}>
                                        {{ $mk->nama_matakuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="program_studi_name">Program Studi</label>
                            <input type="text" id="program_studi_name" class="form-control"
                                value="{{ $evaluasiPlan->programStudi->nama_program_studi }}" readonly>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="program_studi_id" id="program_studi_id"
                    value="{{ $evaluasiPlan->program_studi_id }}">

                <div class="table-responsive mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 160px;">Jenis Evaluasi</th>
                                <th style="width: 160px;">Nama Evaluasi</th>
                                <th>Deskripsi (Indo)</th>
                                <th>Deskripsi (Eng)</th>
                                <th style="width: 50px;">Bobot</th>
                                <th style="width: 50px;">No Urut</th>
                            </tr>
                        </thead>
                        <tbody id="details-section">
                            @foreach ($evaluasiPlan->details as $index => $detail)
                                <tr class="detail-item">
                                    <td>
                                        <select name="details[{{ $index }}][jenis_evaluasi]" class="form-control jenis-evaluasi"
                                            required>
                                            <option value="">Pilih...</option>
                                            <option value="2" {{ $detail->jenis_evaluasi == 2 ? 'selected' : '' }}>
                                                Hasil Partisipatif</option>
                                            <option value="3" {{ $detail->jenis_evaluasi == 3 ? 'selected' : '' }}>
                                                Hasil Proyek</option>
                                            <option value="4" {{ $detail->jenis_evaluasi == 4 ? 'selected' : '' }}>
                                                Kognitif/ Pengetahuan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="details[{{ $index }}][nama_evaluasi]"
                                            class="form-control nama-evaluasi"
                                            {{ $detail->jenis_evaluasi == 4 ? '' : 'disabled' }}>
                                            <option value="">Pilih...</option>
                                            <option value="TGS" {{ $detail->nama_evaluasi == 'TGS' ? 'selected' : '' }}>
                                                Tugas</option>
                                            <option value="QIZ" {{ $detail->nama_evaluasi == 'QIZ' ? 'selected' : '' }}>
                                                Quiz</option>
                                            <option value="UTS" {{ $detail->nama_evaluasi == 'UTS' ? 'selected' : '' }}>
                                                UTS</option>
                                            <option value="UAS" {{ $detail->nama_evaluasi == 'UAS' ? 'selected' : '' }}>
                                                UAS</option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea name="details[{{ $index }}][desc_indo]" class="form-control" required>{{ $detail->desc_indo }}</textarea>
                                    </td>
                                    <td>
                                        <textarea name="details[{{ $index }}][desc_eng]" class="form-control">{{ $detail->desc_eng }}</textarea>
                                    </td>
                                    <td><input type="number" name="details[{{ $index }}][bobot]"
                                            class="form-control" value="{{ $detail->bobot }}" style="width: 80px;"
                                            required></td>
                                    <td><input type="number" name="details[{{ $index }}][no_urut]"
                                            class="form-control" value="{{ $detail->no_urut }}" style="width: 80px;"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="add-detail" class="btn btn-sm btn-success btn-icon">
                        <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                    </button>
                </div>

                <a href="{{ route('evaluasi_plan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let detailIndex = {{ count($evaluasiPlan->details) }};

        document.getElementById('add-detail').addEventListener('click', function() {
            let newRow = `
            <tr class="detail-item">
                <td>
                    <select name="details[${detailIndex}][jenis_evaluasi]" class="form-control" required>
                        <option value="0">Pilih...</option>
                        <option value="2">Hasil Partisipatif</option>
                        <option value="3">Hasil Proyek</option>
                        <option value="4">Kognitif atau Pengetahuan</option>
                    </select>
                </td>
                <td>
                    <select name="details[${detailIndex}][nama_evaluasi]" class="form-control nama-evaluasi" disabled>
                        <option value="">Pilih...</option>
                        <option value="TGS">Tugas</option>
                        <option value="QIZ">Quiz</option>
                        <option value="UTS">UTS</option>
                        <option value="UAS">UAS</option>
                    </select>
                </td>
                <td><textarea name="details[${detailIndex}][desc_indo]" class="form-control" required></textarea></td>
                <td><textarea name="details[${detailIndex}][desc_eng]" class="form-control"></textarea></td>
                <td><input type="number" name="details[${detailIndex}][bobot]" class="form-control" style="width: 80px;" required></td>
                <td><input type="number" name="details[${detailIndex}][no_urut]" class="form-control" style="width: 80px;"></td>
            </tr>
            `;
            document.getElementById('details-section').insertAdjacentHTML('beforeend', newRow);
            detailIndex++;
        });

        // Aktifkan dan nonaktifkan Nama Evaluasi tergantung pada Jenis Evaluasi yang dipilih
        $(document).on('change', '.jenis-evaluasi', function() {
            let jenisEvaluasi = $(this).val();
            let namaEvaluasiSelect = $(this).closest('tr').find('.nama-evaluasi');

            if (jenisEvaluasi == '4') {
                namaEvaluasiSelect.prop('disabled', false);
            } else {
                namaEvaluasiSelect.prop('disabled', true);
                namaEvaluasiSelect.prop('selectedIndex', 0);
            }
        });

        $(document).ready(function() {
            // Pastikan setiap dropdown jenis evaluasi di halaman sudah diperiksa saat halaman dimuat
            $('.jenis-evaluasi').each(function() {
                let jenisEvaluasi = $(this).val();
                let namaEvaluasiSelect = $(this).closest('tr').find('.nama-evaluasi');

                // Jika jenis_evaluasi == 4, aktifkan dropdown nama_evaluasi, selain itu nonaktifkan
                if (jenisEvaluasi == '4') {
                    namaEvaluasiSelect.prop('disabled', false);
                } else {
                    namaEvaluasiSelect.prop('disabled', true);
                    namaEvaluasiSelect.prop('selectedIndex', 0);
                }
            });
        });

        document.getElementById('matakuliah_id').addEventListener('change', function() {
            let matakuliahId = this.value;
            if (matakuliahId) {
                fetch(`/evaluasi-plan/get-program-studi/${matakuliahId}`)
                    .then(response => response.json())
                    .then(data => {
                        let programStudiInput = document.getElementById('program_studi_name');
                        let programStudiHiddenInput = document.getElementById('program_studi_id');
                        if (data.length > 0) {
                            programStudiInput.value = data[0].nama_program_studi;
                            programStudiHiddenInput.value = data[0].id;
                        } else {
                            programStudiInput.value = '';
                            programStudiHiddenInput.value = '';
                        }
                    })
                    .catch(error => console.error('Error fetching program studi:', error));
            } else {
                document.getElementById('program_studi_name').value = '';
                document.getElementById('program_studi_id').value = '';
            }
        });

        document.getElementById('evaluasi-form').addEventListener('submit', function(event) {
            let totalBobot = 0;
            document.querySelectorAll('input[name^="details"][name$="[bobot]"]').forEach(function(input) {
                totalBobot += parseInt(input.value) || 0;
            });

            if (totalBobot !== 100) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Total Bobot Salah',
                    text: 'Total bobot harus sama dengan 100. Saat ini total bobot adalah ' + totalBobot,
                });
            }
        });
    </script>
@endpush
