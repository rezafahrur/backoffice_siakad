@extends('layouts.app')

@section('title', 'Form Edit Periode Perkuliahan')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('periode-perkuliahan.index') }}">Periode Perkuliahan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Update
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Form Edit Periode Perkuliahan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('periode-perkuliahan.update', $periodePerkuliahan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Semester --}}
                    <div class="col-md-6 mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-select" id="semester_id" name="semester_id" required>
                            <option value="">Pilih Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ $semester->id == old('semester_id', $periodePerkuliahan->semester_id) ? 'selected' : '' }}>
                                    {{ $semester->nama_semester }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Program Studi --}}
                    <div class="col-md-6 mb-3">
                        <label for="program_studi_id" class="form-label">Kode Prodi</label>
                        <select class="form-select" id="program_studi_id" name="program_studi_id" required>
                            <option value="" disabled>Pilih Program Studi</option>
                            @foreach ($programStudi as $prodi)
                                <option value="{{ $prodi->id }}"
                                    {{ $prodi->id == old('program_studi_id', $periodePerkuliahan->program_studi_id) ? 'selected' : '' }}>
                                    {{ $prodi->nama_program_studi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    {{-- Tanggal Awal Perkuliahan --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_awal_kuliah" class="form-label">Tanggal Awal Perkuliahan</label>
                        <input type="date" class="form-control" id="tanggal_awal_kuliah" name="tanggal_awal_kuliah"
                            value="{{ old('tanggal_awal_kuliah', \Carbon\Carbon::parse($periodePerkuliahan->tanggal_awal_kuliah)->format('Y-m-d')) }}" required>
                    </div>
                
                    {{-- Tanggal Akhir Perkuliahan --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_akhir_kuliah" class="form-label">Tanggal Akhir Perkuliahan</label>
                        <input type="date" class="form-control" id="tanggal_akhir_kuliah" name="tanggal_akhir_kuliah"
                            value="{{ old('tanggal_akhir_kuliah', \Carbon\Carbon::parse($periodePerkuliahan->tanggal_akhir_kuliah)->format('Y-m-d')) }}" required>
                    </div>
                </div>              

                <div class="row">
                    {{-- Jml Target Mhs Baru --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_target_mhs_baru" class="form-label">Jumlah Target Mhs Baru</label>
                        <input type="number" class="form-control" id="jml_target_mhs_baru" name="jml_target_mhs_baru"
                            value="{{ old('jml_target_mhs_baru', $periodePerkuliahan->jml_target_mhs_baru) }}" required>
                    </div>

                    {{-- Jml Pendaftar Ikut Seleksi --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_pendaftar_ikut_seleksi" class="form-label">Jumlah Pendaftar Ikut Seleksi</label>
                        <input type="number" class="form-control" id="jml_pendaftar_ikut_seleksi"
                            name="jml_pendaftar_ikut_seleksi"
                            value="{{ old('jml_pendaftar_ikut_seleksi', $periodePerkuliahan->jml_pendaftar_ikut_seleksi) }}"
                            required>
                    </div>
                </div>

                <div class="row">
                    {{-- Jml Pendaftar Lulus Seleksi --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_pendaftar_lulus_seleksi" class="form-label">Jumlah Pendaftar Lulus Seleksi</label>
                        <input type="number" class="form-control" id="jml_pendaftar_lulus_seleksi"
                            name="jml_pendaftar_lulus_seleksi"
                            value="{{ old('jml_pendaftar_lulus_seleksi', $periodePerkuliahan->jml_pendaftar_lulus_seleksi) }}"
                            required>
                    </div>

                    {{-- Jml Daftar Ulang --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_daftar_ulang" class="form-label">Jumlah Daftar Ulang</label>
                        <input type="number" class="form-control" id="jml_daftar_ulang" name="jml_daftar_ulang"
                            value="{{ old('jml_daftar_ulang', $periodePerkuliahan->jml_daftar_ulang) }}" required>
                    </div>
                </div>

                <div class="row">
                    {{-- Jml Mengundurkan Diri --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_mengundurkan_diri" class="form-label">Jumlah Mengundurkan Diri</label>
                        <input type="number" class="form-control" id="jml_mengundurkan_diri" name="jml_mengundurkan_diri"
                            value="{{ old('jml_mengundurkan_diri', $periodePerkuliahan->jml_mengundurkan_diri) }}"
                            required>
                    </div>

                    {{-- Jml Minggu Pertemuan --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_minggu_pertemuan" class="form-label">Jumlah Minggu Pertemuan</label>
                        <input type="number" class="form-control" id="jml_minggu_pertemuan" name="jml_minggu_pertemuan"
                            value="{{ old('jml_minggu_pertemuan', $periodePerkuliahan->jml_minggu_pertemuan) }}" required>
                    </div>
                </div>

                <a href="{{ route('periode-perkuliahan.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
