@extends('layouts.custom')

@section('title', 'Edit User')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('position.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('position.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}"> </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Edit Data</h4>
    </div>
    <div class="card-body">
        <form action="{{ url('master/position/update/' . $position->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Posisi</label>
                <input type="text" class="form-control" id="posisi" name="posisi" placeholder="Kode Program Studi"
                    value="{{ $position->posisi }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
