@extends('layouts.app')

@section('title', 'Create Rencana Evaluasi')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('evaluasi_plan.index') }}">Rencana Evaluasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Rencana Evaluasi</h4>
            <form id="evaluasi-form" action="{{ route('evaluasi_plan.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="matakuliah_id">Matakuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-control" required>
                                <option value="">Select Matakuliah</option>
                                @foreach ($matakuliah as $mk)
                                    <option value="{{ $mk->id }}">{{ $mk->nama_matakuliah }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="program_studi_name">Program Studi</label>
                            <input type="text" id="program_studi_name" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Hidden input for program_studi_id -->
                <input type="hidden" name="program_studi_id" id="program_studi_id">

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
                            <tr class="detail-item">
                                <!-- Jenis Evaluasi as a Select -->
                                <td>
                                    <select name="details[0][jenis_evaluasi]" class="form-control jenis-evaluasi" required>
                                        <option value="">Pilih...</option>
                                        <option value="2">Hasil Partisipatif</option>
                                        <option value="3">Hasil Proyek</option>
                                        <option value="4">Kognitif/ Pengetahuan</option>
                                    </select>
                                </td>
                                <!-- Nama Evaluasi -->
                                <td>
                                    <select name="details[0][nama_evaluasi]" class="form-control nama-evaluasi" disabled>
                                        <option value="">Pilih...</option>
                                        <option value="TGS">Tugas</option>
                                        <option value="QIZ">Quiz</option>
                                        <option value="UTS">UTS</option>
                                        <option value="UAS">UAS</option>
                                    </select>
                                </td>
                                <!-- Deskripsi Bahasa Indo -->
                                <td>
                                    <textarea name="details[0][desc_indo]" class="form-control" required></textarea>
                                </td>
                                <!-- Deskripsi Bahasa Eng -->
                                <td>
                                    <textarea name="details[0][desc_eng]" class="form-control"></textarea>
                                </td>
                                <!-- Bobot (Number Input with Fixed Width) -->
                                <td><input type="text"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)"
                                        name="details[0][bobot]" class="form-control" style="width: 50px;" required></td>
                                <!-- No Urut (Number Input with Fixed Width) -->
                                <td><input type="text"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)"
                                        name="details[0][no_urut]" class="form-control" style="width: 50px;"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" id="add-detail" class="btn btn-sm btn-success btn-icon">
                        <i class="btn-icon-prepend" data-feather="plus-circle"></i>
                    </button>
                </div>

                <a href="{{ route('evaluasi_plan.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let detailIndex = 1;
        document.getElementById('add-detail').addEventListener('click', function() {
            let newRow = `
            <tr class="detail-item">
                <!-- Jenis Evaluasi as a Select -->
                <td>
                    <select name="details[${detailIndex}][jenis_evaluasi]" class="form-control jenis-evaluasi" required>
                        <option value="0">Pilih...</option>
                        <option value="2">Hasil Partisipatif</option>
                        <option value="3">Hasil Proyek</option>
                        <option value="4">Kognitif atau Pengetahuan</option>
                    </select>
                </td>
                <!-- Nama Evaluasi -->
                <td>
                    <select name="details[${detailIndex}][nama_evaluasi]" class="form-control nama-evaluasi" disabled>
                        <option value="">Pilih...</option>
                        <option value="TGS">Tugas</option>
                        <option value="QIZ">Quiz</option>
                        <option value="UTS">UTS</option>
                        <option value="UAS">UAS</option>
                    </select>
                </td>
                <!-- Deskripsi Bahasa Indo -->
                <td><textarea name="details[${detailIndex}][desc_indo]" class="form-control" required></textarea></td>
                <!-- Deskripsi Bahasa Eng -->
                <td><textarea name="details[${detailIndex}][desc_eng]" class="form-control"></textarea></td>
                <!-- Bobot (Number Input with Fixed Width) -->
                <td><input type="number" name="details[${detailIndex}][bobot]" class="form-control" style="width: 80px;" required></td>
                <!-- No Urut (Number Input with Fixed Width) -->
                <td><input type="number" name="details[${detailIndex}][no_urut]" class="form-control" style="width: 80px;"></td>
            </tr>
            `;
            document.getElementById('details-section').insertAdjacentHTML('beforeend', newRow);
            detailIndex++;
        });

        // Aktifkan dan nonaktifkan Nama Evaluasi tergantung pada Jenis Evaluasi yang dipilih
        $(document).on('change', '.jenis-evaluasi', function() {
            console.log('Jenis evaluasi changed'); // Debugging log
            let jenisEvaluasi = $(this).val();
            let namaEvaluasiSelect = $(this).closest('tr').find('.nama-evaluasi');

            if (jenisEvaluasi == '4') {
                namaEvaluasiSelect.prop('disabled', false);
            } else {
                namaEvaluasiSelect.prop('disabled', true);
                namaEvaluasiSelect.val(''); // Reset value when disabled
            }
        });

        // Fetch Program Studi based on selected Matakuliah
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

        // Validation for total bobot using SweetAlert
        document.getElementById('evaluasi-form').addEventListener('submit', function(event) {
            let totalBobot = 0;
            document.querySelectorAll('input[name^="details"][name$="[bobot]"]').forEach(function(input) {
                totalBobot += parseInt(input.value);
            });

            if (totalBobot !== 100) {
                event.preventDefault(); // Prevent form submission
                alert('Total bobot harus 100');
            }
        });
    </script>
@endpush
