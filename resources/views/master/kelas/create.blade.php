@extends('layouts.app')

@section('title', 'Form Create Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Kelas</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Create Kelas</h3>

            {{-- Check for validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Check for other error messages --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade mt-4">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('kelast.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Nama Kelas --}}
                        <div class="row mb-3">
                            <label for="nama_kelas" class="col-md-3 col-form-label">Nama Kelas</label>
                            <div class="col-md-9">
                                <input type="text" name="nama_kelas"
                                    class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas"
                                    value="{{ old('nama_kelas') }}">
                                @error('nama_kelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- Program Studi --}}
                        <div class="row mb-3">
                            <label for="program_studi_id" class="col-md-3 col-form-label">Program Studi</label>
                            <div class="col-md-9">
                                <select name="program_studi_id" id="program_studi_id"
                                    class="form-control @error('program_studi_id') is-invalid @enderror">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach ($programStudi as $ps)
                                        <option value="{{ $ps->id }}"
                                            {{ old('program_studi_id') == $ps->id ? 'selected' : '' }}>
                                            {{ $ps->nama_program_studi }}
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Tanggal Mulai --}}
                        <div class="row mb-3">
                            <label for="tanggal_mulai" class="col-md-3 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_mulai"
                                    class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai"
                                    value="{{ old('tanggal_mulai') }}">
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- Tanggal Akhir --}}
                        <div class="row mb-3">
                            <label for="tanggal_akhir" class="col-md-3 col-form-label">Tanggal Akhir</label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_akhir"
                                    class="form-control @error('tanggal_akhir') is-invalid @enderror" id="tanggal_akhir"
                                    value="{{ old('tanggal_akhir') }}">
                                @error('tanggal_akhir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Semester --}}
                        <div class="row mb-3">
                            <label for="semester_id" class="col-md-3 col-form-label">Semester</label>
                            <div class="col-md-9">
                                <select name="semester_id" id="semester_id"
                                    class="form-control @error('semester_id') is-invalid @enderror">
                                    <option value="">Pilih Semester</option>
                                    @foreach ($semester as $sms)
                                        <option value="{{ $sms->id }}"
                                            {{ old('semester_id') == $sms->id ? 'selected' : '' }}>
                                            {{ $sms->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('semester_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- Kurikulum --}}
                        <div class="row mb-3">
                            <label for="kurikulum_id" class="col-md-3 col-form-label">Kurikulum</label>
                            <div class="col-md-9">
                                <select name="kurikulum_id" id="kurikulum_id" onchange="fetchKurikulumDetails()"
                                    class="form-control">
                                    <option value="">Pilih Kurikulum</option>
                                    @foreach ($kurikulum as $kr)
                                        <option value="{{ $kr->id }}"
                                            {{ old('kurikulum_id') == $kr->id ? 'selected' : '' }}>
                                            {{ $kr->nama_kurikulum }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kurikulum_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Detail Paket Jadwal -->
                <div id="kelas-details">
                </div>

                <a href="{{ route('kelast.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function fetchKurikulumDetails() {
            var kurikulumId = document.getElementById('kurikulum_id').value;

            if (kurikulumId) {
                fetch(`/kelas/details/${kurikulumId}`)
                    .then(response => response.json())
                    .then(data => {
                        let detailsDiv = document.getElementById('kelas-details');
                        detailsDiv.innerHTML = ''; // Clear previous details

                        data.details.forEach(detail => {
                            // Check if 'matakuliah' exists and is not null
                            let namaMatakuliah = detail.matakuliah ? detail.matakuliah.nama_matakuliah :
                                'Mata kuliah tidak tersedia';

                            let lingkupKelasOptions = [{
                                    value: 1,
                                    label: "Internal"
                                },
                                {
                                    value: 2,
                                    label: "Eksternal"
                                },
                                {
                                    value: 3,
                                    label: "Campuran"
                                }
                            ].map(lingkup =>
                                `<option value="${lingkup.value}" ${lingkup.value == detail.lingkup_kelas ? 'selected' : ''}>${lingkup.label}</option>`
                            ).join('');

                            let modeKelasOptions = [{
                                    value: 'O',
                                    label: "Online"
                                },
                                {
                                    value: 'F',
                                    label: "Offline"
                                },
                                {
                                    value: 'M',
                                    label: "Campuran"
                                }
                            ].map(mode =>
                                `<option value="${mode.value}" ${mode.value == detail.mode_kelas ? 'selected' : ''}>${mode.label}</option>`
                            ).join('');

                            let detailField = `
                            <!-- Detail Kelas -->
                            <hr> <!-- Separator line between details -->
                            <div class="detail-kelas my-5">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Mata Kuliah</label>
                                        <input type="hidden" name="details[${detail.id}][kurikulum_detail_id]" value="${detail.id}">
                                        <input type="text" class="form-control" value="${namaMatakuliah}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Deskripsi</label>
                                        <input type="text" name="details[${detail.id}][description]" class="form-control" value="${detail.description || ''}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Lingkup Kelas</label>
                                        <select name="details[${detail.id}][lingkup_kelas]" class="form-control">
                                            ${lingkupKelasOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Mode Kelas</label>
                                        <select name="details[${detail.id}][mode_kelas]" class="form-control">
                                            ${modeKelasOptions}
                                        </select>
                                    </div>
                                </div>
                            </div>
                    `;
                            detailsDiv.insertAdjacentHTML('beforeend', detailField);
                        });
                    });
            } else {
                document.getElementById('kelas-details').innerHTML = ''; // Clear if no Paket Mata Kuliah is selected
            }
        }
    </script>
@endpush
