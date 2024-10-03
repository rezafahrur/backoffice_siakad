@extends('layouts.app')

@section('title', 'Edit Aktivitas Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item"><a href="{{ route('aktivitas.index') }}">Aktivitas Mahasiswa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Aktivitas</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Aktivitas Mahasiswa</h6>
                    <form action="{{ route('aktivitas.update', $aktivitas->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="kode_aktivitas" class="form-label">Kode Aktivitas</label>
                            <input type="text" class="form-control" name="kode_aktivitas" id="kode_aktivitas"
                                value="{{ $aktivitas->kode_aktivitas }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="program_studi_id" class="form-label">Program Studi</label>
                                <select name="program_studi_id" id="program_studi_id" class="form-control">
                                    @foreach ($prodi as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $aktivitas->program_studi_id ? 'selected' : '' }}>
                                            {{ $item->nama_program_studi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="semester_id" class="form-label">Semester</label>
                                <select name="semester_id" id="semester_id" class="form-control">
                                    @foreach ($semester as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $aktivitas->semester_id ? 'selected' : '' }}>
                                            {{ $item->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_aktivitas" class="form-label">Jenis Aktivitas</label>
                                <select name="jenis_aktivitas" id="jenis_aktivitas" class="form-control">
                                    <option value="1" {{ $aktivitas->jenis_aktivitas == '1' ? 'selected' : '' }}>
                                        Laporan akhir studi</option>
                                    <option value="2" {{ $aktivitas->jenis_aktivitas == '2' ? 'selected' : '' }}>Tugas
                                        akhir/Skripsi</option>
                                    <option value="3" {{ $aktivitas->jenis_aktivitas == '3' ? 'selected' : '' }}>Tesis
                                    </option>
                                    <option value="4" {{ $aktivitas->jenis_aktivitas == '4' ? 'selected' : '' }}>
                                        Disertasi</option>
                                    <option value="5" {{ $aktivitas->jenis_aktivitas == '5' ? 'selected' : '' }}>
                                        Kuliah kerja nyata</option>
                                    <option value="6" {{ $aktivitas->jenis_aktivitas == '6' ? 'selected' : '' }}>Kerja
                                        praktek/PKL</option>
                                    <option value="7" {{ $aktivitas->jenis_aktivitas == '7' ? 'selected' : '' }}>
                                        Bimbingan akademis</option>
                                    <option value="10" {{ $aktivitas->jenis_aktivitas == '10' ? 'selected' : '' }}>
                                        Aktivitas kemahasiswaan</option>
                                    <option value="11" {{ $aktivitas->jenis_aktivitas == '11' ? 'selected' : '' }}>
                                        Program kreativitas mahasiswa</option>
                                    <option value="12" {{ $aktivitas->jenis_aktivitas == '12' ? 'selected' : '' }}>
                                        Kompetisi</option>
                                    <option value="13" {{ $aktivitas->jenis_aktivitas == '13' ? 'selected' : '' }}>
                                        Magang/Praktik Kerja (Kampus Merdeka)</option>
                                    <option value="14" {{ $aktivitas->jenis_aktivitas == '14' ? 'selected' : '' }}>
                                        Asistensi Mengajar di Satuan Pendidikan (Kampus Merdeka)</option>
                                    <option value="15" {{ $aktivitas->jenis_aktivitas == '15' ? 'selected' : '' }}>
                                        Penelitian/Riset (Kampus Merdeka)</option>
                                    <option value="16" {{ $aktivitas->jenis_aktivitas == '16' ? 'selected' : '' }}>
                                        Proyek Kemanusiaan (Kampus Merdeka)</option>
                                    <option value="17" {{ $aktivitas->jenis_aktivitas == '17' ? 'selected' : '' }}>
                                        Kegiatan Wirausaha (Kampus Merdeka)</option>
                                    <option value="18" {{ $aktivitas->jenis_aktivitas == '18' ? 'selected' : '' }}>
                                        Studi/Proyek Independen (Kampus Merdeka)</option>
                                    <option value="19" {{ $aktivitas->jenis_aktivitas == '19' ? 'selected' : '' }}>
                                        Membangun Desa/Kuliah Kerja Nyata Tematik (Kampus Merdeka)</option>
                                    <option value="20" {{ $aktivitas->jenis_aktivitas == '20' ? 'selected' : '' }}>Bela
                                        Negara (Kampus Merdeka)</option>
                                    <option value="21" {{ $aktivitas->jenis_aktivitas == '21' ? 'selected' : '' }}>
                                        Pertukaran Pelajar (Kampus Merdeka)</option>
                                    <option value="22" {{ $aktivitas->jenis_aktivitas == '22' ? 'selected' : '' }}>
                                        Skripsi</option>
                                    <option value="23" {{ $aktivitas->jenis_aktivitas == '23' ? 'selected' : '' }}>
                                        Kegiatan Penelitian Reguler (Kampus Merdeka)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis_anggota" class="form-label">Jenis Anggota</label>
                                <select name="jenis_anggota" id="jenis_anggota"
                                    class="form-control @error('jenis_anggota') is-invalid @enderror">
                                    <option value="0" {{ $aktivitas->jenis_anggota == '0' ? 'selected' : '' }}>Personal
                                    </option>
                                    <option value="1" {{ $aktivitas->jenis_anggota == '1' ? 'selected' : '' }}>Kelompok
                                    </option>
                                </select>
                                @error('jenis_anggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" id="judul"
                                    value="{{ $aktivitas->judul }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lokasi" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" id="lokasi"
                                    value="{{ $aktivitas->lokasi }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan_aktivitas" class="form-label">Keterangan Aktivitas</label>
                            <textarea class="form-control" name="keterangan_aktivitas" id="keterangan_aktivitas">{{ $aktivitas->keterangan_aktivitas }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nomor_sk_tugas" class="form-label">Nomor SK Tugas</label>
                                <input type="text" class="form-control" name="nomor_sk_tugas" id="nomor_sk_tugas"
                                    value="{{ $aktivitas->nomor_sk_tugas }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_sk_tugas" class="form-label">Tanggal SK Tugas</label>
                                <input type="date" class="form-control" name="tanggal_sk_tugas" id="tanggal_sk_tugas"
                                    value="{{ $aktivitas->tanggal_sk_tugas }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ $aktivitas->tanggal_mulai }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                    value="{{ $aktivitas->tanggal_selesai }}">
                            </div>
                        </div>

                        <a href="{{ route('aktivitas.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
