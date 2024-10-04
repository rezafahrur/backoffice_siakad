@extends('layouts.app')

@section('title', 'Form Position')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('position.index') }}">Posisi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Posisi
            </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Form Tambah Posisi</h4>
            <form action="{{ route('position.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="posisi">Position Name:</label>
                    <input type="text" class="form-control @error('posisi') is-invalid @enderror" id="posisi"
                        name="posisi" value="{{ old('posisi') }}" required>
                    @error('posisi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <label class="form-label">Permissions:</label>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fitur</th>
                                    <th>Create</th>
                                    <th>Read</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($features as $feature)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_', ' ', $feature->name)) }}</td>
                                        @foreach (['create', 'read', 'update', 'delete'] as $action)
                                            <td>
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $action }}_{{ $feature->name }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @error('permissions[]')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <a href="{{ route('position.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>


@endsection
