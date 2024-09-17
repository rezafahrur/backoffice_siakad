@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('mata-kuliah.index') }}">Mata Kuliah</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Mata Kuliah</h4>
            <form action="{{ route('mata-kuliah.update', $matkul->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="program_studi_id" class="form-label">Program Studi</label>
                            <select class="form-select @error('program_studi_id') is-invalid @enderror"
                                name="program_studi_id" id="program_studi_id">
                                <option value="" disabled>Pilih Program Studi</option>
                                @foreach ($programStudis as $programStudi)
                                    <option value="{{ $programStudi->id }}"
                                        {{ old('program_studi_id', $matkul->program_studi_id) == $programStudi->id ? 'selected' : '' }}>
                                        {{ $programStudi->nama_program_studi }}
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
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="kode_matakuliah" class="form-label">Kode Mata Kuliah</label>
                            <input type="text" name="kode_matakuliah"
                                class="form-control @error('kode_matakuliah') is-invalid @enderror" id="kode_matakuliah"
                                value="{{ old('kode_matakuliah', $matkul->kode_matakuliah) }}">
                            @error('kode_matakuliah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_matakuliah" class="form-label">Nama Mata Kuliah</label>
                            <input type="text" name="nama_matakuliah"
                                class="form-control @error('nama_matakuliah') is-invalid @enderror" id="nama_matakuliah"
                                value="{{ old('nama_matakuliah', $matkul->nama_matakuliah) }}">
                            @error('nama_matakuliah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- jenis mata kuliah --}}
                        <div class="mb-3">
                            <label for="jenis_matakuliah" class="form-label">Jenis Mata Kuliah</label>
                            <select name="jenis_matakuliah" id="jenis_matakuliah" class="form-select">
                                <option value="">Pilih Jenis Mata Kuliah</option>
                                <option value="W"
                                    {{ old('jenis_matakuliah', $matkul->jenis_matakuliah) == 'W' ? 'selected' : '' }}>
                                    Wajib Nasional
                                </option>
                                <option value="A"
                                    {{ old('jenis_matakuliah', $matkul->jenis_matakuliah) == 'A' ? 'selected' : '' }}>
                                    Wajib Program Studi
                                </option>
                                <option value="B"
                                    {{ old('jenis_matakuliah', $matkul->jenis_matakuliah) == 'B' ? 'selected' : '' }}>
                                    Pilihan
                                </option>
                                <option value="C"
                                    {{ old('jenis_matakuliah', $matkul->jenis_matakuliah) == 'C' ? 'selected' : '' }}>
                                    Peminatan
                                </option>
                                <option value="S"
                                    {{ old('jenis_matakuliah', $matkul->jenis_matakuliah) == 'S' ? 'selected' : '' }}>
                                    TA/Skripsi/Thesis/Disertasi
                                </option>
                            </select>
                            @error('jenis_matakuliah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-3">
                        {{-- SKS Tatap Muka --}}
                        <div class="mb-3">
                            <label for="sks_tatap_muka" class="form-label">SKS Tatap Muka</label>
                            <input type="number" name="sks_tatap_muka"
                                class="form-control @error('sks_tatap_muka') is-invalid @enderror" id="sks_tatap_muka"
                                value="{{ old('sks_tatap_muka', $matkul->sks_tatap_muka) }}">
                            @error('sks_tatap_muka')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        {{-- sks praktek --}}
                        <div class="mb-3">
                            <label for="sks_praktek" class="form-label">SKS Praktek</label>
                            <input type="number" name="sks_praktek"
                                class="form-control @error('sks_praktek') is-invalid @enderror" id="sks_praktek"
                                value="{{ old('sks_praktek', $matkul->sks_praktek) }}">
                            @error('sks_praktek')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        {{-- sks praktek lapangan --}}
                        <div class="mb-3">
                            <label for="sks_praktek_lapangan" class="form-label">SKS Praktek Lapangan</label>
                            <input type="number" name="sks_praktek_lapangan"
                                class="form-control @error('sks_praktek_lapangan') is-invalid @enderror"
                                id="sks_praktek_lapangan"
                                value="{{ old('sks_praktek_lapangan', $matkul->sks_praktek_lapangan) }}">
                            @error('sks_praktek_lapangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        {{-- sks simulasi --}}
                        <div class="mb-3">
                            <label for="sks_simulasi" class="form-label">SKS Simulasi</label>
                            <input type="number" name="sks_simulasi"
                                class="form-control @error('sks_simulasi') is-invalid @enderror" id="sks_simulasi"
                                value="{{ old('sks_simulasi', $matkul->sks_simulasi) }}">
                            @error('sks_simulasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- metode belajar --}}
                <div class="mb-3">
                    <label for="metode_belajar" class="form-label">Metode Belajar</label>
                    <input type="text" name="metode_belajar"
                        class="form-control @error('metode_belajar') is-invalid @enderror" id="metode_belajar"
                        value="{{ old('metode_belajar', $matkul->metode_belajar) }}">
                    @error('metode_belajar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{-- tanggal mulai efektif --}}
                        <div class="mb-3">
                            <label for="tgl_mulai_efektif" class="form-label">Tanggal Mulai Efektif</label>
                            <input type="date" name="tgl_mulai_efektif"
                                class="form-control @error('tgl_mulai_efektif') is-invalid @enderror"
                                id="tgl_mulai_efektif"
                                value="{{ old('tgl_mulai_efektif', $matkul->tgl_mulai_efektif) }}">
                            @error('tgl_mulai_efektif')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- tanggal akhir efektif --}}
                        <div class="mb-3">
                            <label for="tgl_akhir_efektif" class="form-label">Tanggal Akhir Efektif</label>
                            <input type="date" name="tgl_akhir_efektif"
                                class="form-control @error('tgl_akhir_efektif') is-invalid @enderror"
                                id="tgl_akhir_efektif"
                                value="{{ old('tgl_akhir_efektif', $matkul->tgl_akhir_efektif) }}">
                            @error('tgl_akhir_efektif')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- status --}}
                {{-- <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Pilih Status</option>
                        <option value="1" {{ old('status', $matkul->status) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status', $matkul->status) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
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
