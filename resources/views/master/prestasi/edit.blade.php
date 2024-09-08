@extends('layouts.custom')

@section('title', 'Edit Prestasi')

@section('content')
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('prestasi.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('prestasi.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>

    <div class="card-header">
        <h4 class="card-title">Edit Prestasi Mahasiswa</h4>
    </div>
    <div class="card-body">
        {{-- Check for validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
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
            <div class="alert alert-danger alert-dismissible show fade">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Program Studi --}}
                <div class="col-md-6 mb-3">
                    <label for="program_studi_id" class="form-label">Program Studi</label>
                    <select name="program_studi_id" class="form-select" id="program_studi_id" required>
                        <option value="" disabled>Pilih Program Studi</option>
                        @foreach ($programStudi as $prd)
                            <option value="{{ $prd->id }}"
                                {{ $prestasi->program_studi_id == $prd->id ? 'selected' : '' }}>
                                {{ $prd->nama_program_studi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mahasiswa --}}
                <div class="col-md-6 mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-select" id="mahasiswa_id" required>
                        <option value="" disabled>Pilih Mahasiswa</option>
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}"
                                {{ $prestasi->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nim }} - {{ $mhs->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Prestasi --}}
                <div class="col-md-6 mb-3">
                    <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" class="form-control"
                        value="{{ old('nama_prestasi', $prestasi->nama) }}" required>
                </div>

                {{-- Penyelenggara --}}
                <div class="col-md-6 mb-3">
                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="form-control"
                        value="{{ old('penyelenggara', $prestasi->penyelenggara) }}" required>
                </div>

                {{-- Jenis Prestasi --}}
                <div class="col-md-3 mb-3">
                    <label for="jenis_prestasi" class="form-label">Jenis Prestasi</label>
                    <select name="jenis_prestasi" class="form-select" required>
                        <option value="" disabled>Pilih Jenis Prestasi</option>
                        <option value="1" {{ $prestasi->jenis == 1 ? 'selected' : '' }}>Sains</option>
                        <option value="2" {{ $prestasi->jenis == 2 ? 'selected' : '' }}>Seni</option>
                        <option value="3" {{ $prestasi->jenis == 3 ? 'selected' : '' }}>Olahraga</option>
                        <option value="9" {{ $prestasi->jenis == 9 ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Tingkat Prestasi --}}
                <div class="col-md-3 mb-3">
                    <label for="tingkat_prestasi" class="form-label">Tingkat Prestasi</label>
                    <select name="tingkat_prestasi" class="form-select" required>
                        <option value="" disabled>Pilih Tingkat Prestasi</option>
                        <option value="1" {{ $prestasi->tingkat == 1 ? 'selected' : '' }}>Sekolah</option>
                        <option value="2" {{ $prestasi->tingkat == 2 ? 'selected' : '' }}>Kecamatan</option>
                        <option value="3" {{ $prestasi->tingkat == 3 ? 'selected' : '' }}>Kabupaten / Kota
                        </option>
                        <option value="4" {{ $prestasi->tingkat == 4 ? 'selected' : '' }}>Provinsi</option>
                        <option value="5" {{ $prestasi->tingkat == 5 ? 'selected' : '' }}>Nasional</option>
                        <option value="6" {{ $prestasi->tingkat == 6 ? 'selected' : '' }}>Internasional
                        </option>
                        <option value="7" {{ $prestasi->tingkat == 7 ? 'selected' : '' }}>Regional</option>
                        <option value="9" {{ $prestasi->tingkat == 9 ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Peringkat --}}
                <div class="col-md-3 mb-3">
                    <label for="peringkat" class="form-label">Peringkat</label>
                    <input type="text" name="peringkat" class="form-control"
                        value="{{ old('peringkat', $prestasi->peringkat) }}">
                </div>

                {{-- Tahun --}}
                <div class="col-md-3 mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="text" name="tahun" class="form-control" value="{{ old('tahun', $prestasi->tahun) }}"
                        required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
