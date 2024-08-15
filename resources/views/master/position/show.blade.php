@extends('layouts.custom')

@section('title', 'Detail User')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('position.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('position.index') }}">
                <img src="{{ asset('assets/img/logo-kos.svg') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}
    <div class="card-header">
        <h4 class="card-title">Detail Position</h4>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Posisi</label>
            <span class="form-control border-1 border-primary">{{ $position->posisi }}</span>
        </div>
        
    </div>
@endsection
