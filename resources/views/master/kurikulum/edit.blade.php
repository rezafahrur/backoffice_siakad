@extends('layouts.app')

@section('title', 'Edit Kurikulum')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('kurikulum.index') }}">Kurikulum</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Kurikulum</h4>
            <form action="{{ route('kurikulum.update', $kurikulum->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_kurikulum" class="form-label">Nama Kurikulum</label>
                    <input type="text" class="form-control @error('nama_kurikulum') is-invalid @enderror"
                        id="nama_kurikulum" name="nama_kurikulum" placeholder="nama kurikulum"
                        value="{{ $kurikulum->nama_kurikulum }}">
                    @error('nama_kurikulum')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" class="form-control" id="semester">
                                <option value="">Pilih Semester...</option>
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->kode_semester }}"
                                        {{ $kurikulum->semester == $semester->kode_semester ? 'selected' : '' }}>
                                        {{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-8">
                        {{-- Program Studi --}}
                        <div class="mb-3">
                            <label for="kode_prodi" class="form-label" required>Program Studi</label>
                            <select name="kode_prodi" class="form-control" id="kode_prodi">
                                <option value="">Pilih Program Studi...</option>
                                @foreach ($programStudis as $prodi)
                                    <option value="{{ $prodi->kode_program_studi }}"
                                        {{ $kurikulum->kode_prodi == $prodi->kode_program_studi ? 'selected' : '' }}>
                                        {{ $prodi->nama_program_studi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kode_prodi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="sum_sks_lulus" class="form-label">SKS Lulus</label>
                            <input type="number" class="form-control @error('sum_sks_lulus') is-invalid @enderror"
                                id="sum_sks_lulus" name="sum_sks_lulus" placeholder="sks lulus"
                                value="{{ $kurikulum->sum_sks_lulus }}">
                            @error('sum_sks_lulus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="sum_sks_wajib" class="form-label">SKS Wajib</label>
                            <input type="number" class="form-control @error('sum_sks_wajib') is-invalid @enderror"
                                id="sum_sks_wajib" name="sum_sks_wajib" placeholder="sks wajib"
                                value="{{ $kurikulum->sum_sks_wajib }}">
                            @error('sum_sks_wajib')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label for="sum_sks_pilihan" class="form-label">SKS Pilihan</label>
                            <input type="number" class="form-control @error('sum_sks_pilihan') is-invalid @enderror"
                                id="sum_sks_pilihan" name="sum_sks_pilihan" placeholder="sks pilihan"
                                value="{{ $kurikulum->sum_sks_pilihan }}">
                            @error('sum_sks_pilihan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <a href="{{ route('kurikulum.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
