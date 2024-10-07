@extends('layouts.app')

@section('title', 'Form Create Kurikulum')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('kurikulum.index') }}">Kurikulum</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Kurikulum
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Kurikulum</h4>
            <form action="{{ route('kurikulum.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label for="nama_kurikulum" class="form-label">Nama Kurikulum</label>
                            <input type="text" class="form-control @error('nama_kurikulum') is-invalid @enderror"
                                id="nama_kurikulum" name="nama_kurikulum" placeholder="Nama Kurikulum"
                                value="{{ old('nama_kurikulum') }}">
                            @error('nama_kurikulum')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Tahun Akademik</label>
                            <select name="semester" class="form-control" id="semester">
                                <option value="">Pilih Tahun Akademik...</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->kode_semester }}">{{ $semester->nama_semester }}</option>
                                @endforeach
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Program Studi --}}
                        <div class="mb-3">
                            <label for="program_studi_id" class="form-label">Program Studi</label>
                            <select name="program_studi_id" class="form-control" id="program_studi_id" required>
                                <option value="">Pilih Program Studi...</option>
                                @foreach ($programStudis as $prodi)
                                    <option value="{{ $prodi->id }}">
                                        {{ $prodi->kode_program_studi }} - {{ $prodi->nama_program_studi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_studi_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    {{-- semester angka --}}
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="semester_angka" class="form-label">Semester Angka</label>
                            <select class="form-select" id="semester_angka" name="semester_angka" required>
                                <option value="" disabled selected>Pilih Semester...</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>
                    {{-- status --}}
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        {{-- sks lulus --}}
                        <div class="mb-3">
                            <label for="sum_sks_lulus" class="form-label">SKS Lulus</label>
                            <input type="number" class="form-control @error('sum_sks_lulus') is-invalid @enderror"
                                id="sum_sks_lulus" name="sum_sks_lulus" placeholder="sks lulus" readonly>
                            @error('sum_sks_lulus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        {{-- sks wajib --}}
                        <div class="mb-3">
                            <label for="sum_sks_wajib" class="form-label">SKS Wajib</label>
                            <input type="number" class="form-control @error('sum_sks_wajib') is-invalid @enderror"
                                id="sum_sks_wajib" name="sum_sks_wajib" placeholder="sks wajib"
                                value="{{ old('sum_sks_wajib', 0) }}">
                            @error('sum_sks_wajib')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-4">
                        {{-- sks pilihan --}}
                        <div class="mb-3">
                            <label for="sum_sks_pilihan" class="form-label">SKS Pilihan</label>
                            <input type="number" class="form-control @error('sum_sks_pilihan') is-invalid @enderror"
                                id="sum_sks_pilihan" name="sum_sks_pilihan" placeholder="sks pilihan"
                                value="{{ old('sum_sks_pilihan', 0) }}">
                            @error('sum_sks_pilihan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                    <select class="form-select" id="multiple-select-field" name="matakuliah_id[]" multiple required>

                    </select>
                </div>

                <a href="{{ route('kurikulum.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#multiple-select-field').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: "Pilih Mata Kuliah",
                closeOnSelect: false
            });

            const programStudiSelect = $('#program_studi_id');
            const semesterSelect = $('#semester_angka');
            const mataKuliahSelect = $('#multiple-select-field');

            // Fetch Mata Kuliah based on Program Studi and Semester
            function fetchMataKuliah() {
                const prodi = programStudiSelect.val();
                const semester = semesterSelect.val();

                $.ajax({
                    url: `/kurikulum/get-matakuliah/${prodi}/${semester}`,
                    method: 'GET',
                    success: function(response) {
                        mataKuliahSelect.empty();
                        response.forEach(mataKuliah => {
                            mataKuliahSelect.append(new Option(mataKuliah.nama_matakuliah,
                                mataKuliah.id, false, false));
                        });
                        mataKuliahSelect.trigger('change');
                    },
                    error: function(xhr) {
                        mataKuliahSelect.empty();
                        if (xhr.status === 404) {
                            mataKuliahSelect.append(new Option('Mata Kuliah tidak ditemukan.', '',
                                false, false));
                        } else {
                            mataKuliahSelect.append(new Option('Terjadi kesalahan pada server.', '',
                                false, false));
                        }
                        mataKuliahSelect.trigger('change');
                    }
                });
            }

            programStudiSelect.on('change', fetchMataKuliah);
            semesterSelect.on('change', fetchMataKuliah);

            // Automatically calculate SKS Wajib based on selected Mata Kuliah
            mataKuliahSelect.on('change', function() {
                const selectedIds = $(this).val();

                if (selectedIds.length > 0) {
                    $.ajax({
                        url: `/kurikulum/get-matakuliah-details`,
                        method: 'POST',
                        data: {
                            mataKuliahIds: selectedIds,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            let totalSKSWajib = 0;

                            response.forEach(mataKuliah => {
                                totalSKSWajib += (mataKuliah.sks_tatap_muka + mataKuliah
                                    .sks_praktek +
                                    mataKuliah.sks_praktek_lapangan + mataKuliah
                                    .sks_simulasi);
                            });

                            $('#sum_sks_wajib').val(totalSKSWajib);
                            calculateSKSLulus(); // Recalculate total SKS Lulus
                        },
                        error: function() {
                            alert('Error fetching Mata Kuliah details.');
                        }
                    });
                } else {
                    $('#sum_sks_wajib').val(0);
                    calculateSKSLulus();
                }
            });

            // Logic to automatically sum SKS Lulus and reset empty inputs
            function calculateSKSLulus() {
                let sksWajib = parseInt($('#sum_sks_wajib').val()) || 0;
                let sksPilihan = parseInt($('#sum_sks_pilihan').val()) || 0;
                $('#sum_sks_lulus').val(sksWajib + sksPilihan);
            }

            $('#sum_sks_wajib, #sum_sks_pilihan').on('input', calculateSKSLulus);
        });
    </script>
@endpush
