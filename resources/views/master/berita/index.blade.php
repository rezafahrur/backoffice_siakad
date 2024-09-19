@extends('layouts.app')

@section('title', 'Berita')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Berita</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Berita</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('berita.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                            <i class="btn-icon-prepend" data-feather="plus-square"></i>
                            Tambah Data
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul Berita</th>
                                    <th>Kategori</th>
                                    <th>Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($berita as $brt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $brt->judul_berita }}</td>
                                        <td>{{ $brt->kategoriBerita->kategori_berita ?? 'N/A' }}</td>
                                        <td>
                                            @if ($brt->path_photo)
                                                <img src="{{ asset('storage/' . $brt->path_photo) }}" alt="photo" style="width: 100px;">
                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('berita.edit', $brt->id) }}" class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('berita.show', $brt->id) }}" class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('berita.destroy', $brt->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger btn-icon" onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
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
