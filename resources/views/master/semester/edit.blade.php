@extends('layouts.app')

@section('title', 'Edit Semester')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Semester</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
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

                <a href="{{ route('semester.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
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
