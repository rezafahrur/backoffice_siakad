@extends('layouts.app')

@section('title', 'Tambah Aktivitas Mahasiswa Bimbing Uji')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Data</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Aktivitas Mahasiswa Bimbing Uji</li>
    </ol>
</nav>

<div class="row mb-3">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Form Tambah Aktivitas</h6>
                <form action="{{ route('bimbingUji.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="aktivitas_mahasiswa_id" class="form-label">Kode Aktivitas</label>
                        <select name="aktivitas_mahasiswa_id" class="form-control" required>
                            <option value="">Pilih Kode Aktivitas Mahasiswa</option>
                            @foreach($aktivitas as $a)
                                <option value="{{ $a->id }}">{{ $a->kode_aktivitas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nidn_dosen" class="form-label">NIDN Dosen</label>
                        <input type="text" name="nidn_dosen" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_dosen" class="form-label">Nama Dosen</label>
                        <input type="text" name="nama_dosen" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_peran" class="form-label">Jenis Peran</label>
                        <select name="jenis_peran" class="form-control" required>
                            <option value="">Pilih Jenis Peran</option>
                            <option value="1" {{ old('jenis_peran') == '1' ? 'selected' : '' }}>Pembimbing</option>
                            <option value="2" {{ old('jenis_peran') == '2' ? 'selected' : '' }}>Penguji</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="urutan_pembimbing" class="form-label">Urutan Pembimbing</label>
                        <input type="number" name="urutan_pembimbing" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori_kegiatan" class="form-label">Kategori Kegiatan</label>
                        <select name="kategori_kegiatan" class="form-control" required>
                            <option value="">Pilih Kode Kegiatan</option>
                            <option value="110100">110100 - Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing, menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan</option>
                            <option value="110200">110200 - Membimbing seminar mahasiswa</option>
                            <option value="110300">110300 - Membimbing kuliah kerja nyata, praktik kerja nyata, atau praktik kerja lapangan</option>
                            <option value="110400">110400 - Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi, dan laporan akhir studi yang sesuai dengan bidang penugasannya</option>
                            <option value="110500">110500 - Bertugas sebagai penguji pada ujian akhir</option>
                            <option value="110600">110600 - Membina kegiatan mahasiswa di bidang akademik dan kemahasiswaan</option>
                            <option value="110700">110700 - Mengembangkan program kuliah yang mempunyai nilai kebaharuan metode atau substansi</option>
                            <option value="110800">110800 - Mengembangkan bahan pengajaran/bahan kuliah yang mempunyai nilai kebaharuan</option>
                            <option value="110900">110900 - Menyampaikan orasi ilmiah di tingkat perguruan tinggi</option>
                            <option value="111000">111000 - Menduduki jabatan pimpinan perguruan tinggi</option>
                            <option value="111100">111100 - Membimbing dosen yang mempunyai jabatan akademik lebih rendah</option>
                            <option value="111200">111200 - Melaksanakan kegiatan detasering dan pencangkokan di luar institusi tempat bekerja</option>
                            <option value="111300">111300 - Melakukan kegiatan pengembangan diri untuk meningkatkan kompetensi</option>
                        </select>
                    </div>

                    <a href="{{ route('bimbingUji.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
