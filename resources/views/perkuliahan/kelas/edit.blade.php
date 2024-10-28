@extends('layouts.app')

@section('title', 'Form Edit Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Kelas</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Kelas</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('kelas.update', $kelas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Nama Kelas --}}
                        <div class="row mb-3">
                            <label for="nama_kelas" class="col-md-3 col-form-label">Nama Kelas</label>
                            <div class="col-md-9">
                                <input type="text" name="nama_kelas"
                                    class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas"
                                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                                @error('nama_kelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- Program Studi --}}
                        <div class="row mb-3">
                            <label for="program_studi_id" class="col-md-3 col-form-label">Program Studi</label>
                            <div class="col-md-9">
                                <select name="program_studi_id" id="program_studi_id"
                                    class="form-control @error('program_studi_id') is-invalid @enderror">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach ($programStudi as $ps)
                                        <option value="{{ $ps->id }}"
                                            {{ old('program_studi_id', $kelas->program_studi_id) == $ps->id ? 'selected' : '' }}>
                                            {{ $ps->nama_program_studi }}
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Tanggal Mulai --}}
                        <div class="row mb-3">
                            <label for="tanggal_mulai" class="col-md-3 col-form-label">Tanggal Mulai</label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_mulai"
                                    class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai"
                                    value="{{ old('tanggal_mulai', $kelas->tanggal_mulai) }}">
                                @error('tanggal_mulai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- Tanggal Akhir --}}
                        <div class="row mb-3">
                            <label for="tanggal_akhir" class="col-md-3 col-form-label">Tanggal Akhir</label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_akhir"
                                    class="form-control @error('tanggal_akhir') is-invalid @enderror" id="tanggal_akhir"
                                    value="{{ old('tanggal_akhir', $kelas->tanggal_akhir) }}">
                                @error('tanggal_akhir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{-- Semester --}}
                        <div class="row mb-3">
                            <label for="semester_id" class="col-md-3 col-form-label">Semester</label>
                            <div class="col-md-9">
                                <select name="semester_id" id="semester_id"
                                    class="form-control @error('semester_id') is-invalid @enderror">
                                    <option value="">Pilih Semester</option>
                                    @foreach ($semester as $sms)
                                        <option value="{{ $sms->id }}"
                                            {{ old('semester_id', $kelas->semester_id) == $sms->id ? 'selected' : '' }}>
                                            {{ $sms->nama_semester }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('semester_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        {{-- Kurikulum --}}
                        <div class="row mb-3">
                            <label for="kurikulum_id" class="col-md-3 col-form-label">Kurikulum</label>
                            <div class="col-md-9">
                                <select name="kurikulum_id" id="kurikulum_id" onchange="fetchKurikulumDetails()"
                                    class="form-control">
                                    <option value="">Pilih Kurikulum</option>
                                    @foreach ($kurikulum as $kr)
                                        <option value="{{ $kr->id }}"
                                            {{ old('kurikulum_id', $kelas->kurikulum_id) == $kr->id ? 'selected' : '' }}>
                                            {{ $kr->nama_kurikulum }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kurikulum_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- kapasitas --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="kapasitas" class="col-md-3 col-form-label">Kapasitas</label>
                            <div class="col-md-9">
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)"
                                    name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                                    id="kapasitas" value="{{ old('kapasitas', $kelas->kapasitas) }}">
                                @error('kapasitas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Paket Jadwal -->
                <div id="kelas-details">
                    @foreach ($kelas->details as $detail)
                        <div class="detail-kelas my-5">
                            <hr> <!-- Separator line between details -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Mata Kuliah</label>
                                    <input type="hidden" name="details[{{ $detail->id }}][kurikulum_detail_id]"
                                        value="{{ $detail->kurikulum_detail_id }}">
                                    <input type="text" class="form-control"
                                        value="{{ $detail->kurikulumDetail->matakuliah->nama_matakuliah ?? 'Mata kuliah tidak tersedia' }}"
                                        readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Deskripsi</label>
                                    <input type="text" name="details[{{ $detail->id }}][description]"
                                        class="form-control"
                                        value="{{ old('details.' . $detail->id . '.description', $detail->description ?? '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Lingkup Kelas</label>
                                    <select name="details[{{ $detail->id }}][lingkup_kelas]" class="form-control">
                                        <option value="1" {{ $detail->lingkup_kelas == 1 ? 'selected' : '' }}>
                                            Internal</option>
                                        <option value="2" {{ $detail->lingkup_kelas == 2 ? 'selected' : '' }}>
                                            Eksternal</option>
                                        <option value="3" {{ $detail->lingkup_kelas == 3 ? 'selected' : '' }}>
                                            Campuran</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Mode Kelas</label>
                                    <select name="details[{{ $detail->id }}][mode_kelas]" class="form-control">
                                        <option value="O" {{ $detail->mode_kelas == 'O' ? 'selected' : '' }}>Online
                                        </option>
                                        <option value="F" {{ $detail->mode_kelas == 'F' ? 'selected' : '' }}>Offline
                                        </option>
                                        <option value="M" {{ $detail->mode_kelas == 'M' ? 'selected' : '' }}>Campuran
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Dosen</label>
                                    <select name="details[{{ $detail->id }}][hr_id]" class="form-control">
                                        <option value="">-- Pilih Dosen --</option>
                                        @foreach ($dosen as $d)
                                            <option value="{{ $d->id }}"
                                                {{ $detail->hr_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tatap Muka</label>
                                    <input type="number" name="details[{{ $detail->id }}][tatap_muka]"
                                        class="form-control"
                                        value="{{ old('details.' . $detail->id . '.tatap_muka', $detail->tatap_muka) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">SKS Ajar</label>
                                    <input type="number" name="details[{{ $detail->id }}][sks_ajar]"
                                        class="form-control" readonly
                                        value="{{ old('details.' . $detail->id . '.sks_ajar', $detail->sks_ajar) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Evaluasi</label>
                                    <select name="details[{{ $detail->id }}][jenis_evaluasi]" class="form-control">
                                        <option value="1" {{ $detail->jenis_evaluasi == 1 ? 'selected' : '' }}>
                                            Evaluasi Akademik</option>
                                        <option value="2" {{ $detail->jenis_evaluasi == 2 ? 'selected' : '' }}>
                                            Aktivitas Partisipatif</option>
                                        <option value="3" {{ $detail->jenis_evaluasi == 3 ? 'selected' : '' }}>Hasil
                                            Proyek</option>
                                        <option value="4" {{ $detail->jenis_evaluasi == 4 ? 'selected' : '' }}>
                                            Kognitif / Pengetahuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label class="form-label">Aktivitas Partisipatif (%)</label>
                                    <input type="text" name="details[{{ $detail->id }}][aktivitas_partisipatif]"
                                        class="form-control"
                                        value="{{ old('details.' . $detail->id . '.aktivitas_partisipatif', $detail->aktivitas_partisipatif ?? '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Hasil Proyek (%)</label>
                                    <input type="text" name="details[{{ $detail->id }}][hasil_proyek]"
                                        class="form-control"
                                        value="{{ old('details.' . $detail->id . '.hasil_proyek', $detail->hasil_proyek ?? '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tugas (%)</label>
                                    <input type="text" name="details[{{ $detail->id }}][tugas]"
                                        class="form-control"
                                        value="{{ old('details.' . $detail->id . '.tugas', $detail->tugas ?? '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Quiz (%)</label>
                                    <input type="text" name="details[{{ $detail->id }}][quiz]" class="form-control"
                                        value="{{ old('details.' . $detail->id . '.quiz', $detail->quiz ?? '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">UTS (%)</label>
                                    <input type="text" name="details[{{ $detail->id }}][uts]" class="form-control"
                                        value="{{ old('details.' . $detail->id . '.uts', $detail->uts ?? '') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">UAS (%)</label>
                                    <input type="text" name="details[{{ $detail->id }}][uas]" class="form-control"
                                        value="{{ old('details.' . $detail->id . '.uas', $detail->uas ?? '') }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
