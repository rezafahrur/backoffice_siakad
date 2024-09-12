@extends('layouts.app')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="">Config</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Edit Configurations</h6>
            <form action="{{ route('config.update') }}" method="POST">
                @csrf

                @foreach ($configs as $config)
                    <div class="row mb-3">
                        <label for="{{ $config->key }}" class="col-sm-3 col-form-label">{{ $config->key }}</label>
                        <div class="col-sm-9">
                            @if ($config->key == 'SEMESTER_AKTIF')
                                <select name="{{ $config->key }}" id="{{ $config->key }}" class="form-control">
                                    @foreach ($semesters as $kode => $nama)
                                        <option value="{{ $kode }}" {{ $config->value == $kode ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" name="{{ $config->key }}" id="{{ $config->key }}"
                                    value="{{ $config->value }}" class="form-control">
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
