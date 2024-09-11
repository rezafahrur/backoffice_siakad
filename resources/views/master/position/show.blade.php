@extends('layouts.app')

@section('title', 'Detail Position')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Posisi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Position
            </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Position</h4>
            <div class="form-group">
                <label for="posisi">Position Name:</label>
                <p class="form-control-plaintext">{{ $position->posisi }}</p>
            </div>

            <div class="form-group">
                <div class="mb-3">
                    <label class="form-label">Permissions:</label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Feature</th>
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
        </div>
    </div>

@endsection
