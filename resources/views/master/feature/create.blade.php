@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Buat Fitur Baru</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('feature.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Fitur:</label>
            <input type="text" class="form-control" id="name" name="name" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <a href="{{ route('feature.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Buat Fitur</button>
    </form>
</div>
@endsection