@extends('layouts.app')

@section('title', 'Form Mata Kuliah')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Mata Kuliah</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Mata Kuliah</h4>
            <form action="{{ route('mata-kuliah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Program Studi --}}
                <div class="mb-3">
                    <select name="program_studi_id" id="program_studi_id" class="form-select">
                        <option value="">Pilih Program Studi</option>
                        @foreach ($matkuls as $matkul)
                            <option value="{{ $matkul->id }}">{{ $matkul->nama_program_studi }}</option>
                        @endforeach
                    </select>
                    @error('program_studi_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Kode Mata Kuliah --}}
                <div class="mb-3">
                    <label for="kode_matakuliah" class="form-label">Kode Mata Kuliah</label>
                    <input type="text" class="form-control @error('kode_matakuliah') is-invalid @enderror"
                        id="kode_matakuliah" name="kode_matakuliah" placeholder="Masukan Kode Mata Kuliah"
                        value="{{ old('kode_matakuliah') }}">
                    @error('kode_matakuliah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nama Mata Kuliah --}}
                <div class="mb-3">
                    <label for="nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
                    <input type="text" class="form-control @error('nama_matakuliah') is-invalid @enderror"
                        id="nama_matakuliah" name="nama_matakuliah" placeholder="Masukan Nama Mata Kuliah"
                        value="{{ old('nama_matakuliah') }}">
                    @error('nama_matakuliah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Jenis Mata Kuliah --}}
                <div class="mb-3">
                    <label for="jenis_matakuliah" class="form-label">Jenis Mata Kuliah</label>
                    <select name="jenis_matakuliah" id="jenis_matakuliah" class="form-select">
                        <option value="">Pilih Jenis Mata Kuliah</option>
                        <option value="W">Wajib Nasional</option>
                        <option value="A">Wajib Program Studi</option>
                        <option value="B">Pilihan</option>
                        <option value="C">Peminatan</option>
                        <option value="S">TA/Skripsi/Thesis/Disertasi</option>
                    </select>
                    @error('jenis_matakuliah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- SKS Tatap Muka --}}
                <div class="mb-3">
                    <label for="sks_tatap_muka" class="form-label">SKS Tatap Muka</label>
                    <input type="number" class="form-control @error('sks_tatap_muka') is-invalid @enderror"
                        id="sks_tatap_muka" name="sks_tatap_muka" placeholder="Masukan jumlah SKS Tatap Muka"
                        value="{{ old('sks_tatap_muka', 0) }}">
                    @error('sks_tatap_muka')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- SKS Praktek --}}
                <div class="mb-3">
                    <label for="sks_praktek" class="form-label">SKS Praktek</label>
                    <input type="number" class="form-control @error('sks_praktek') is-invalid @enderror" id="sks_praktek"
                        name="sks_praktek" placeholder="Masukan jumlah SKS Praktek" value="{{ old('sks_praktek', 0) }}">
                    @error('sks_praktek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- SKS Praktek Lapangan --}}
                <div class="mb-3">
                    <label for="sks_praktek_lapangan" class="form-label">SKS Praktek Lapangan</label>
                    <input type="number" class="form-control @error('sks_praktek_lapangan') is-invalid @enderror"
                        id="sks_praktek_lapangan" name="sks_praktek_lapangan"
                        placeholder="Masukan jumlah SKS Praktek Lapangan" value="{{ old('sks_praktek_lapangan', 0) }}">
                    @error('sks_praktek_lapangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- SKS Simulasi --}}
                <div class="mb-3">
                    <label for="sks_simulasi" class="form-label">SKS Simulasi</label>
                    <input type="number" class="form-control @error('sks_simulasi') is-invalid @enderror" id="sks_simulasi"
                        name="sks_simulasi" placeholder="Masukan jumlah SKS Simulasi" value="{{ old('sks_simulasi', 0) }}">
                    @error('sks_simulasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Metode Belajar --}}
                <div class="mb-3">
                    <label for="metode_belajar" class="form-label">Metode Belajar</label>
                    <input type="text" class="form-control @error('metode_belajar') is-invalid @enderror"
                        id="metode_belajar" name="metode_belajar" placeholder="Masukan Metode Belajar"
                        value="{{ old('metode_belajar') }}">
                    @error('metode_belajar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tanggal Mulai Efektif --}}
                <div class="mb-3">
                    <label for="tgl_mulai_efektif" class="form-label">Tanggal Mulai Efektif</label>
                    <input type="date" class="form-control @error('tgl_mulai_efektif') is-invalid @enderror"
                        id="tgl_mulai_efektif" name="tgl_mulai_efektif" value="{{ old('tgl_mulai_efektif') }}">
                    @error('tgl_mulai_efektif')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tanggal Akhir Efektif --}}
                <div class="mb-3">
                    <label for="tgl_akhir_efektif" class="form-label">Tanggal Akhir Efektif</label>
                    <input type="date" class="form-control @error('tgl_akhir_efektif') is-invalid @enderror"
                        id="tgl_akhir_efektif" name="tgl_akhir_efektif" value="{{ old('tgl_akhir_efektif') }}">
                    @error('tgl_akhir_efektif')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Status --}}
                {{-- <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="0" selected>Tidak Sinkron</option>
                        <option value="1">Sinkron</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div> --}}

                <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
