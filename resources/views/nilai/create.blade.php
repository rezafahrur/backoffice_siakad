@extends('layouts.custom')

@section('title', 'Form Tambah Penilaian')

@section('content')
    {{-- Start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('berita.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('paket-matakuliah.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    <div class="card-header">
        <h4 class="card-title">Form Tambah Penilaian</h4>
    </div>
    <div class="card-body">
        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="beritaForm" action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul_berita" class="form-label>">Matakuliah</label>
                <select name="matakuliah" id="matakuliah" class="form-control">
                    <option value="">Pilih MATKUL</option>
                    @foreach ($matakuliahs as $key => $value)
                        <option value="{{ $value['matakuliah_id'] }}">{{ $value['nama_matakuliah'] }}</option>
                    @endforeach        
                </select>
            </div>

            <div class="mb-3">
                <label for="judul_berita" class="form-label>">Mahasiswa</label>
                <select name="mahasiswa" id="mahasiswa" class="form-control">
                    <option value="">Pilih Mahasiswa</option>
                    @foreach ($mahasiswas as $key => $value)
                        <option value="{{ $value['mahasiswa_id'] }}">{{ $value['nama'] }}</option>
                    @endforeach        
                </select>
            </div>

            <div class="mb-3">
                <label for="judul_berita" class="form-label>">Semester</label>
                <select name="semester" id="semester" class="form-control">
                    <option value="">Pilih Semester</option>
                    @foreach ($paketMatkuls as $key => $value)
                        <option value="{{ $value['paket_matakuliah_id'] }}">
                            {{ $value['nama_paket_matakuliah'] }}, Semester {{ $value['semester'] }}
                        </option>
                    @endforeach        
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
