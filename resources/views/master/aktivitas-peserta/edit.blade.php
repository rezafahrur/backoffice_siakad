@extends('layouts.app')
@section('title', 'Edit Aktivitas Mahasiswa Peserta')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('aktivitas-peserta.index') }}">Aktivitas Mahasiswa Peserta</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Aktivitas Mahasiswa Peserta</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Edit Aktivitas Mahasiswa Peserta</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('aktivitas-peserta.update', $peserta->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="aktivitas_mahasiswa_id" class="form-label">Aktivitas Mahasiswa</label>
                    <select id="aktivitas_mahasiswa_id" name="aktivitas_mahasiswa_id" class="form-select" required>
                        <option value="">Pilih Aktivitas Mahasiswa</option>
                        @foreach ($aktivitasMahasiswa as $aktivitas)
                            <option value="{{ $aktivitas->id }}"
                                {{ $peserta->aktivitas_mahasiswa_id == $aktivitas->id ? 'selected' : '' }}>
                                {{ $aktivitas->kode_aktivitas }} - {{ $aktivitas->judul }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mahasiswa_id" class="form-label">Nama Mahasiswa</label>
                    <select id="mahasiswa_id" name="mahasiswa_id" class="form-select" required>
                        <option value="">Pilih Mahasiswa</option>
                        @foreach ($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}" {{ $peserta->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="program_studi_id" class="form-label">Program Studi</label>
                    <select id="program_studi_id" name="program_studi_id" class="form-select" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach ($programStudi as $prodi)
                            <option value="{{ $prodi->id }}"
                                {{ $peserta->program_studi_id == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->nama_program_studi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="matakuliah_id" class="form-label">Matakuliah</label>
                    <select id="matakuliah_id" name="matakuliah_id" class="form-select" required>
                        <option value="">Pilih Matakuliah</option>
                        @foreach ($matakuliah as $matakul)
                            <option value="{{ $matakul->id }}"
                                {{ $peserta->matakuliah_id == $matakul->id ? 'selected' : '' }}>
                                {{ $matakul->kode_matakuliah }} - {{ $matakul->nama_matakuliah }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="number" id="sks" name="sks" class="form-control" value="{{ $peserta->sks }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="jenis_peran" class="form-label">Jenis Peran</label>
                    <select name="jenis_peran" id="jenis_peran" class="form-control" required>
                        <option value="1" {{ $peserta->jenis_peran == '1' ? 'selected' : '' }}>Ketua</option>
                        <option value="2" {{ $peserta->jenis_peran == '2' ? 'selected' : '' }}>Anggota</option>
                        <option value="3" {{ $peserta->jenis_peran == '3' ? 'selected' : '' }}>Personal</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nilai_huruf" class="form-label">Nilai Huruf</label>
                    <input type="text" class="form-control" id="nilai_huruf" name="nilai_huruf"
                        value="{{ $peserta->nilai_huruf }}" placeholder="Nilai Huruf" required>
                    @error('nilai_huruf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nilai_indeks" class="form-label">Nilai Indeks</label>
                    <select name="nilai_indeks" id="nilai_indeks" class="form-control" required>
                        <option value="1" {{ $peserta->nilai_indeks == '1' ? 'selected' : '' }}>0</option>
                        <option value="2" {{ $peserta->nilai_indeks == '2' ? 'selected' : '' }}>1</option>
                        <option value="3" {{ $peserta->nilai_indeks == '3' ? 'selected' : '' }}>2</option>
                        <option value="4" {{ $peserta->nilai_indeks == '4' ? 'selected' : '' }}>3</option>
                        <option value="5" {{ $peserta->nilai_indeks == '5' ? 'selected' : '' }}>4</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nilai_angka" class="form-label">Nilai Angka</label>
                    <input type="text" class="form-control" id="nilai_angka" name="nilai_angka"
                        value="{{ $peserta->nilai_angka }}" placeholder="Nilai Angka" required>
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
