@extends('layouts.app')

@section('title', 'Pengumuman SPMB')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">SPMB Pengumuman</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('spmb_pengumuman.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="plus-square"></i>
                        Buat Pengumuman
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Gambar</th>
                                    <th>File</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengumuman as $pgm)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ e($pgm->judul) }}</td> <!-- Escape untuk menghindari XSS -->
                                        <td>
                                            @if ($pgm->gambar)
                                                <img src="{{ Storage::url($pgm->gambar) }}" alt="{{ e($pgm->judul) }}"
                                                    width="100">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pgm->file_pengumuman)
                                                <a href="{{ Storage::url($pgm->file_pengumuman) }}"
                                                    class="btn btn-sm btn-info" target="_blank">Download</a>
                                            @endif
                                        </td>
                                        <td>{{ e($pgm->deskripsi) }}</td> <!-- Escape untuk menghindari XSS -->
                                        <td>
                                            <a href="{{ route('spmb_pengumuman.edit', $pgm->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <form action="{{ route('spmb_pengumuman.destroy', $pgm->id) }}" method="post"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-delete btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada pengumuman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
