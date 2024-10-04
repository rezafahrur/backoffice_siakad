@extends('layouts.app')

@section('title', 'Tambah Aktivitas Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('aktivitas.index') }}">Aktivitas Mahasiswa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Aktivitas Mahasiswa</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Aktivitas Mahasiswa</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('aktivitas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode_aktivitas" class="form-label">Kode Aktivitas</label>
                    <input type="text" name="kode_aktivitas"
                        class="form-control @error('kode_aktivitas') is-invalid @enderror"
                        value="{{ old('kode_aktivitas') }}">
                    @error('kode_aktivitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="program_studi_id" class="form-label">Program Studi</label>
                        <select class="form-select" id="program_studi_id" name="program_studi_id" required>
                            <option value="" disabled selected>Pilih Program Studi</option>
                            @foreach ($prodi as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_program_studi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select class="form-select" id="semester_id" name="semester_id" required>
                            <option value="">Pilih Semester</option>
                            @foreach ($semester as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_semester }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_aktivitas" class="form-label">Jenis Aktivitas</label>
                        <select name="jenis_aktivitas" id="jenis_aktivitas" class="form-control">
                            <option value="1" {{ old('jenis_aktivitas') == '1' ? 'selected' : '' }}>Laporan akhir studi
                            </option>
                            <option value="2" {{ old('jenis_aktivitas') == '2' ? 'selected' : '' }}>Tugas
                                akhir/Skripsi</option>
                            <option value="3" {{ old('jenis_aktivitas') == '3' ? 'selected' : '' }}>Tesis</option>
                            <option value="4" {{ old('jenis_aktivitas') == '4' ? 'selected' : '' }}>Disertasi</option>
                            <option value="5" {{ old('jenis_aktivitas') == '5' ? 'selected' : '' }}>Kuliah kerja nyata
                            </option>
                            <option value="6" {{ old('jenis_aktivitas') == '6' ? 'selected' : '' }}>Kerja praktek/PKL
                            </option>
                            <option value="7" {{ old('jenis_aktivitas') == '7' ? 'selected' : '' }}>Bimbingan akademis
                            </option>
                            <option value="10" {{ old('jenis_aktivitas') == '10' ? 'selected' : '' }}>Aktivitas
                                kemahasiswaan</option>
                            <option value="11" {{ old('jenis_aktivitas') == '11' ? 'selected' : '' }}>Program
                                kreativitas mahasiswa</option>
                            <option value="12" {{ old('jenis_aktivitas') == '12' ? 'selected' : '' }}>Kompetisi
                            </option>
                            <option value="13" {{ old('jenis_aktivitas') == '13' ? 'selected' : '' }}>Magang/Praktik
                                Kerja (Kampus Merdeka)</option>
                            <option value="14" {{ old('jenis_aktivitas') == '14' ? 'selected' : '' }}>Asistensi
                                Mengajar di Satuan Pendidikan (Kampus Merdeka)</option>
                            <option value="15" {{ old('jenis_aktivitas') == '15' ? 'selected' : '' }}>Penelitian/Riset
                                (Kampus Merdeka)</option>
                            <option value="16" {{ old('jenis_aktivitas') == '16' ? 'selected' : '' }}>Proyek
                                Kemanusiaan (Kampus Merdeka)</option>
                            <option value="17" {{ old('jenis_aktivitas') == '17' ? 'selected' : '' }}>Kegiatan
                                Wirausaha (Kampus Merdeka)</option>
                            <option value="18" {{ old('jenis_aktivitas') == '18' ? 'selected' : '' }}>Studi/Proyek
                                Independen (Kampus Merdeka)</option>
                            <option value="19" {{ old('jenis_aktivitas') == '19' ? 'selected' : '' }}>Membangun
                                Desa/Kuliah Kerja Nyata Tematik (Kampus Merdeka)</option>
                            <option value="20" {{ old('jenis_aktivitas') == '20' ? 'selected' : '' }}>Bela Negara
                                (Kampus Merdeka)</option>
                            <option value="21" {{ old('jenis_aktivitas') == '21' ? 'selected' : '' }}>Pertukaran
                                Pelajar (Kampus Merdeka)</option>
                            <option value="22" {{ old('jenis_aktivitas') == '22' ? 'selected' : '' }}>Skripsi</option>
                            <option value="23" {{ old('jenis_aktivitas') == '23' ? 'selected' : '' }}>Kegiatan
                                Penelitian Reguler (Kampus Merdeka)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jenis_anggota" class="form-label">Jenis Anggota</label>
                        <select name="jenis_anggota" id="jenis_anggota" class="form-control @error('jenis_anggota') is-invalid @enderror">
                            <option value="0" {{ old('jenis_anggota') == '0' ? 'selected' : '' }}>Personal</option>
                            <option value="1" {{ old('jenis_anggota') == '1' ? 'selected' : '' }}>Kelompok</option>
                        </select>
                        @error('jenis_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan_aktivitas">Keterangan Aktivitas</label>
                    <textarea name="keterangan_aktivitas" class="form-control">{{ old('keterangan_aktivitas') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nomor_sk_tugas">Nomor SK Tugas</label>
                        <input type="text" name="nomor_sk_tugas" class="form-control"
                            value="{{ old('nomor_sk_tugas') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal_sk_tugas">Tanggal SK Tugas</label>
                        <input type="date" name="tanggal_sk_tugas" class="form-control"
                            value="{{ old('tanggal_sk_tugas') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                            value="{{ old('tanggal_mulai') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                            value="{{ old('tanggal_selesai') }}">
                    </div>
                </div>

                <a href="{{ route('aktivitas.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
