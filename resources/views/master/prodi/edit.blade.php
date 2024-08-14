@extends('layouts.custom')

@section('title', 'Edit User')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('prodi.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('prodi.index') }}">
                <img style="height: 50px" src="{{ asset('assets/img/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Users</h4>
    </div>
    <div class="card-body">
        <form action="{{ url('master/prodi/update/' . $program_studi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Kode Program Studi</label>
                <input type="text" class="form-control" id="kode_program_studi" name="kode_program_studi"
                    placeholder="Kode Program Studi" value="{{ $program_studi->kode_program_studi }}" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Program Studi</label>
                <input type="text" class="form-control" id="nama_program_studi" name="nama_program_studi"
                    placeholder="Nama Program Studi" value="{{ $program_studi->nama_program_studi }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
