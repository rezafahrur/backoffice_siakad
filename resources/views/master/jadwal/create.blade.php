@extends('layouts.app')

@section('title', 'Form Tambah Jadwal')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Jadwal</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Jadwal
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Paket Jadwal</h3>

            {{-- Check for validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade mt-4">
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
                <div class="alert alert-danger alert-dismissible show fade mt-4">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Input Data Semester --}}
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="text" class="form-control" id="semester" name="semester" value="{{ old('semester') }}"
                        required>
                </div>
                    
                    {{-- Input Data Ruang Kelas --}}
                <div class="mb-3">
                    <label for="ruang_kelas" class="form-label">Ruang Kelas</label>
                    <select class="form-select" id="ruang_kelas" name="ruang_kelas" required>
                        <option value="">Pilih Ruang Kelas</option>
                        @foreach ($ruangKelas as $rk)
                            <option value="{{ $rk->id }}">{{ $rk->nama_ruang_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection