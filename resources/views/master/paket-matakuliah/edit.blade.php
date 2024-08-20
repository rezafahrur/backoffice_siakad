@extends('layouts.custom')

@section('title', 'Form Update Paket Mata Kuliah')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('paket-matakuliah.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('paket-matakuliah.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    
    <div class="card-header">
        <h4 class="card-title">Form Update Paket Mata Kuliah</h4>
    </div>
    
    <div class="card-body">
        <form action="{{ route('paket-matakuliah.update', $paketMatakuliah->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Paket Mata Kuliah --}}
            <div class="mb-3">
                <label for="nama_paket_matakuliah" class="form-label">Nama Paket Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_paket_matakuliah" name="nama_paket_matakuliah" value="{{ old('nama_paket_matakuliah', $paketMatakuliah->nama_paket_matakuliah) }}" required>
            </div>

            {{-- Program Studi --}}
            <div class="mb-3">
                <label for="program_studi_id" class="form-label">Program Studi</label>
                <select class="form-select" id="program_studi_id" name="program_studi_id" required>
                    <option value="" disabled selected>Pilih Program Studi</option> <!-- Opsi default -->
                    @foreach($programStudi as $prodi)
                        <option value="{{ $prodi->id }}" {{ $prodi->id == $paketMatakuliah->program_studi_id ? 'selected' : '' }}>
                            {{ $prodi->kode_program_studi }} - {{ $prodi->nama_program_studi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Semester --}}
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-select" id="semester" name="semester" required>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ $i == $paketMatakuliah->semester ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1" {{ $paketMatakuliah->status == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $paketMatakuliah->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            {{-- Mata Kuliah --}}
            <div class="mb-3">
                <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="multiple-select-field" name="matakuliah_id[]" multiple required>
                    @foreach($matakuliah as $matkul)
                        <option value="{{ $matkul->id }}" {{ in_array($matkul->id, old('matakuliah_id', $matakuliahTerpilih)) ? 'selected' : '' }}>
                            {{ $matkul->kode_matakuliah }} - {{ $matkul->nama_matakuliah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Pilih Mata Kuliah",
            closeOnSelect: false
        });
    });
    </script>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
