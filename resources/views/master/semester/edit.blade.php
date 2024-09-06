@extends('layouts.custom')

@section('title', 'Edit Semester')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('semester.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('semester.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Edit Semester</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('semester.update', $semester) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- <div class="mb-3">
                <label for="kode_semester" class="form-label">Kode Semester</label>
                <input type="text" class="form-control @error('kode_semester') is-invalid @enderror" id="kode_semester"
                    name="kode_semester" value="{{ old('kode_semester', $semester->kode_semester) }}">
                @error('kode_semester')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            <div class="mb-3">
                <label for="tahun_awal" class="form-label">Tahun Awal</label>
                <input type="number" class="form-control @error('tahun_awal') is-invalid @enderror" id="tahun_awal"
                    name="tahun_awal" value="{{ old('tahun_awal', $semester->tahun_awal) }}">
                @error('tahun_awal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                <input type="number" class="form-control @error('tahun_akhir') is-invalid @enderror" id="tahun_akhir"
                    name="tahun_akhir" value="{{ old('tahun_akhir', $semester->tahun_akhir) }}" readonly>
                @error('tahun_akhir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-control @error('semester') is-invalid @enderror" id="semester" name="semester">
                    <option value="1" {{ old('semester', $semester->semester) == '1' ? 'selected' : '' }}>Ganjil
                    </option>
                    <option value="2" {{ old('semester', $semester->semester) == '2' ? 'selected' : '' }}>Genap
                    </option>
                    <option value="3" {{ old('semester', $semester->semester) == '3' ? 'selected' : '' }}>Pendek
                    </option>
                </select>
                @error('semester')
                    `
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        document.getElementById('tahun_awal').addEventListener('input', function() {
            const tahunAwal = parseInt(this.value);
            if (!isNaN(tahunAwal)) {
                document.getElementById('tahun_akhir').value = tahunAwal + 1;
            } else {
                document.getElementById('tahun_akhir').value = '';
            }
        });
    </script>
@endsection
