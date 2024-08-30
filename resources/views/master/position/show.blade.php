@extends('layouts.custom')

@section('title', 'Show Position')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('position.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('position.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}"> </a>
        </div>
    </nav>
    {{-- end logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Position Details</h4>
    </div>
    <div class="card-body">
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
@endsection
