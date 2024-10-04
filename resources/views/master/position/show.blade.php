@extends('layouts.app')

@section('title', 'Detail Position')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('position.index') }}">Posisi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Position
            </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header bg-secondary text-white">   
            <h5 class="card-title mb-0">Detail Posisi</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="posisi">Nama Posisi:</label>
                <p class="form-control-plaintext">{{ $position->posisi }}</p>
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
                                            <input type="checkbox" disabled
                                                {{ in_array($action . '_' . $feature->name, $rolePermissions) ? 'checked' : '' }}>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ route('position.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>

@endsection
