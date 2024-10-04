@extends('layouts.app')

@section('title', 'HR')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">HR</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data HR</h6>
                    
                    <!-- Filter Form -->
                    <div class="d-flex justify-content-between mb-3">
                        <!-- Form Filter -->
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('hr.index') }}" method="GET" class="d-flex align-items-center">
                                <div class="form-group mr-2">
                                    <select class="form-control" name="position_id" id="positionFilter">
                                        <option value="">-- Pilih Posisi --</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}" 
                                                {{ request('position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->posisi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    
                        <!-- Button Tambah Data -->
                        <div>
                            <a href="{{ route('hr.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                        </div>
                    </div>
                    

                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th>Foto Profil</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hr as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->position->posisi }}</td>
                                        @if ($item->photo_profile == null || !file_exists(public_path('storage/' . $item->photo_profile)))
                                            <td>
                                                <img src="{{ asset('assets/images/others/default-avatar.jpg') }}"
                                                    alt="photo_profile"
                                                    style="width: 50px; height: 50px; object-fit: cover;"
                                                    class="img-thumbnail">
                                            </td>
                                        @else
                                            <td>
                                                <img src="{{ asset('storage/' . $item->photo_profile) }}"
                                                    alt="photo_profile" class="img-fluid rounded-circle"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('hr.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('hr.show', $item->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('hr.destroy', $item->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
