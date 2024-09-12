@extends('layouts.app')

@section('title', 'Create Semester')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('semester.index') }}">Semester</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Create
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Semester</h4>
            <form action="{{ route('semester.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tahun_awal" class="form-label">Tahun Awal</label>
                        <input type="number" class="form-control @error('tahun_awal') is-invalid @enderror" id="tahun_awal"
                            name="tahun_awal" value="{{ old('tahun_awal') }}">
                        @error('tahun_awal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                
                    <div class="col-md-6">
                        <label for="tahun_akhir" class="form-label">Tahun Akhir</label>
                        <input type="number" class="form-control @error('tahun_akhir') is-invalid @enderror" id="tahun_akhir"
                            name="tahun_akhir" value="{{ old('tahun_akhir') }}" readonly>
                        @error('tahun_akhir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-control @error('semester') is-invalid @enderror" id="semester" name="semester">
                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Genap</option>
                        <option value="3" {{ old('semester') == '3' ? 'selected' : '' }}>Pendek</option>
                    </select>
                    @error('semester')
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
