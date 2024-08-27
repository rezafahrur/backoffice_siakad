@extends('layouts.custom')

@section('title', 'Form User')

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
        <h4 class="card-title">Form Members</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('position.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="posisi" class="form-label">Nama Posisi</label>
                <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi"
                    name="posisi" placeholder="Nama Posisi" required>
                @error('posisi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection
