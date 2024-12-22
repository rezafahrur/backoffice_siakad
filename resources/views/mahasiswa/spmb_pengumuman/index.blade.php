@extends('layouts.app')

@section('title', 'Pengumuman SPMB')

@section('content')
    <div class="page-heading">
        <h3>Pengumuman SPMB</h3>
    </div>

    <div class="mb-3">
        <a href="{{ route('spmb_pengumuman.create') }}" class="btn btn-primary">Buat Pengumuman</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
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
                        <td>{{ $pgm->judul }}</td>
                        <td>
                            @if ($pgm->gambar)
                                <img src="{{ Storage::url($pgm->gambar) }}" alt="{{ $pgm->judul }}" width="100">
                            @endif
                        </td>
                        <td>
                            @if ($pgm->file_pengumuman)
                                <a href="{{ Storage::url($pgm->file_pengumuman) }}" class="btn btn-sm btn-info"
                                    target="_blank">Download</a>
                            @endif
                        </td>
                        <td>{{ $pgm->deskripsi }}</td>
                        <td>
                            <a href="{{ route('spmb_pengumuman.edit', $pgm->id) }}" class="btn btn-sm btn-primary btn-icon">
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
@endsection
