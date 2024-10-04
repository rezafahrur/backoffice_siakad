{{-- tampilan create aktivitas mahasiswa peserta --}}
@extends('layouts.app')
@section('title', 'Tambah Aktivitas Peserta')
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Aktivitas Mahasiswa Peserta</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Form Tambah Aktivitas Mahasiswa Peserta</h6>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('aktivitas-peserta.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="aktivitas_mahasiswa_id">ID Aktivitas Mahasiswa</label>
                    <select class="form-control" id="aktivitas_mahasiswa_id" name="aktivitas_mahasiswa_id">
                        <option value="" disabled selected>Pilih Aktivitas Mahasiswa</option>
                        @foreach ($aktivitasMahasiswa as $aktivitas)
                            <option value="{{ $aktivitas->id }}">{{ $aktivitas->kode_aktivitas }}</option>
                        @endforeach
                        @error('aktivitas_mahasiswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mahasiswa_id">Mahasiswa</label>
                    <select class="form-control" id="mahasiswa_id" name="mahasiswa_id">
                        <option value="" disabled selected>Pilih Mahasiswa</option>
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}">{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                        @endforeach
                        @error('mahasiswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </select>
                </div>
                <div class="mb-3">
                    <label for="program_studi_id">Program Studi</label>
                    <select class="form-control" id="program_studi_id" name="program_studi_id">
                        <option value="" disabled selected>Pilih Program Studi</option>
                        @foreach ($programStudi as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->kode_prodi }} -
                                {{ $prodi->nama_program_studi }}</option>
                        @endforeach
                        @error('program_studi_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </select>
                </div>
                <div class="mb-3">
                    <label for="matakuliah_id">Mata Kuliah</label>
                    <select class="form-control" id="matakuliah_id" name="matakuliah_id">
                        <option value="" disabled selected>Pilih Mata Kuliah</option>
                        @foreach ($matakuliah as $matkul)
                            <option value="{{ $matkul->id }}">{{ $matkul->kode_matakuliah }} -
                                {{ $matkul->nama_matakuliah }}</option>
                        @endforeach
                    </select>
                    @error('matakuliah_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="sks">SKS</label>
                    <input type="number" class="form-control" id="sks" name="sks" placeholder="Jumlah SKS">
                    @error('sks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jenis_peran" class="form-label">Jenis Peran</label>
                    <select name="jenis_peran" id="jenis_peran" class="form-control">
                        <option value="1" {{ old('jenis_peran') == '1' ? 'selected' : '' }}>Ketua
                        </option>
                        <option value="2" {{ old('jenis_peran') == '2' ? 'selected' : '' }}>Anggota
                        </option>
                        <option value="3" {{ old('jenis_peran') == '3' ? 'selected' : '' }}>Personal
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nilai_huruf">Nilai Huruf</label>
                    <input type="text" class="form-control" id="nilai_huruf" name="nilai_huruf"
                        placeholder="Nilai Huruf">
                    @error('nilai_huruf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nilai_indeks">Nilai Indeks</label>
                    <select name="nilai_indeks" id="nilai_indeks" class="form-control">
                        <option value="1" {{ old('nilai_indeks') == '1' ? 'selected' : '' }}>0
                        </option>
                        <option value="2" {{ old('nilai_indeks') == '2' ? 'selected' : '' }}>1
                        </option>
                        <option value="3" {{ old('nilai_indeks') == '3' ? 'selected' : '' }}>2
                        </option>
                        <option value="4" {{ old('nilai_indeks') == '4' ? 'selected' : '' }}>3
                        </option>
                        <option value="5" {{ old('nilai_indeks') == '5' ? 'selected' : '' }}>4
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nilai_angka">Nilai Angka</label>
                    <input type="text" class="form-control" id="nilai_angka" name="nilai_angka"
                        placeholder="Nilai Angka">
                    @error('nilai_angka')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('aktivitas-peserta.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
