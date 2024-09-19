@extends('layouts.app')

@section('title', 'Form Periode Perkuliahan')

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
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Form Periode Perkuliahan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('periode-perkuliahan.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- Semester --}}
                    <div class="col-md-6 mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-select" id="semester_id" name="semester_id" required>
                            <option value="">Pilih Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->nama_semester }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kode Prodi --}}
                    <div class="col-md-6 mb-3">
                        <label for="program_studi_id" class="form-label">Kode Prodi</label>
                        <select class="form-select" id="program_studi_id" name="program_studi_id" required>
                            <option value="" disabled selected>Pilih Program Studi</option>
                            @foreach ($programStudi as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_program_studi }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row">
                    {{-- Tanggal Awal Perkuliahan --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_awal_kuliah" class="form-label">Tanggal Awal Perkuliahan</label>
                        <input type="date" class="form-control" id="tanggal_awal_kuliah" name="tanggal_awal_kuliah"
                            required>
                    </div>

                    {{-- Tanggal Akhir Perkuliahan --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_akhir_kuliah" class="form-label">Tanggal Akhir Perkuliahan</label>
                        <input type="date" class="form-control" id="tanggal_akhir_kuliah" name="tanggal_akhir_kuliah"
                            required>
                    </div>

                </div>

                <div class="row">
                    {{-- Jml Target Mhs Baru --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_target_mhs_baru" class="form-label">Jumlah Target Mhs Baru</label>
                        <input type="number" class="form-control" id="jml_target_mhs_baru" name="jml_target_mhs_baru"
                            placeholder="Jumlah Target Mhs Baru" required>
                    </div>

                    {{-- Jml Pendaftar Ikut Seleksi --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_pendaftar_ikut_seleksi" class="form-label">Jumlah Pendaftar Ikut Seleksi</label>
                        <input type="number" class="form-control" id="jml_pendaftar_ikut_seleksi"
                            name="jml_pendaftar_ikut_seleksi" placeholder="Jumlah Pendaftar Ikut Seleksi" required>
                    </div>
                </div>

                <div class="row">
                    {{-- Jml Pendaftar Lulus Seleksi --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_pendaftar_lulus_seleksi" class="form-label">Jumlah Pendaftar Lulus Seleksi</label>
                        <input type="number" class="form-control" id="jml_pendaftar_lulus_seleksi"
                            name="jml_pendaftar_lulus_seleksi" placeholder="Jumlah Pendaftar Lulus Seleksi" required>
                    </div>

                    {{-- Jml Daftar Ulang --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_daftar_ulang" class="form-label">Jumlah Daftar Ulang</label>
                        <input type="number" class="form-control" id="jml_daftar_ulang" name="jml_daftar_ulang"
                            placeholder="Jumlah Daftar Ulang" required>
                    </div>
                </div>

                <div class="row">
                    {{-- Jml Mengundurkan Diri --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_mengundurkan_diri" class="form-label">Jumlah Mengundurkan Diri</label>
                        <input type="number" class="form-control" id="jml_mengundurkan_diri" name="jml_mengundurkan_diri"
                            placeholder="Jumlah Mengundurkan Diri" required>
                    </div>

                    {{-- Jml Minggu Pertemuan --}}
                    <div class="col-md-6 mb-3">
                        <label for="jml_minggu_pertemuan" class="form-label">Jumlah Minggu Pertemuan</label>
                        <input type="number" class="form-control" id="jml_minggu_pertemuan" name="jml_minggu_pertemuan"
                            placeholder="Jumlah Minggu Pertemuan" required>
                    </div>
                </div>


                <a href="{{ route('periode-perkuliahan.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
