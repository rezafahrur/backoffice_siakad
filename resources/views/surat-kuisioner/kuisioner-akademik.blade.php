@extends('layouts.app')

@section('title', 'Kuisioner Akademik')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kuisioner Akademik</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Kuisioner Akademik</h6>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="#" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal"
                                data-bs-target="#addModal">
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
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kuisioner as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pertanyaan_kuisioner }}</td>
                                        <td>{{ $item->jawaban_kuisioner }}</td>
                                        <td>
                                            <!-- Button to Open Edit Modal -->
                                            <button type="button" class="btn btn-sm btn-primary btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                <i class="btn-icon-prepend text-white" data-feather="edit"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('kuisioner-akademik.destroy', $item->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-delete btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('kuisioner-akademik.update', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit
                                                            Kuisioner</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="pertanyaan_kuisioner" class="form-label">Pertanyaan
                                                                Kuisioner</label>
                                                            <input type="text" name="pertanyaan_kuisioner"
                                                                class="form-control"
                                                                value="{{ $item->pertanyaan_kuisioner }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jawaban_kuisioner" class="form-label">Jawaban
                                                                Kuisioner</label>
                                                            <input type="text" name="jawaban_kuisioner"
                                                                class="form-control" value="{{ $item->jawaban_kuisioner }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('kuisioner-akademik.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Kuisioner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pertanyaan_kuisioner" class="form-label">Pertanyaan Kuisioner</label>
                            <input type="text" name="pertanyaan_kuisioner" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jawaban_kuisioner" class="form-label">Jawaban Kuisioner</label>
                            <input type="text" name="jawaban_kuisioner" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Kuisioner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
