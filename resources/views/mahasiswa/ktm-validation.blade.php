@extends('layouts.app')

@section('title', 'Validasi KTM Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Validasi KTM</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Data Validasi KTM</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <th>Program Studi</th>
                                    <th>Foto KTM</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mahasiswaKtms as $ktm)
                                    <tr>
                                        <td>{{ $ktm->mahasiswa->nama }}</td>
                                        <td>{{ $ktm->mahasiswa->programStudi->nama_program_studi ?? '-' }}</td>
                                        <td>
                                            <img src="http://127.0.0.1:9699/{{ $ktm->path_photo }}" alt="KTM Photo"
                                                style="height: 50px;" data-bs-toggle="modal"
                                                data-bs-target="#modalShow{{ $ktm->id }}" />
                                        </td>
                                        <td>
                                            @if ($ktm->status == 2)
                                                <span class="badge bg-success">Tervalidasi</span>
                                            @elseif ($ktm->status == 1)
                                                <span class="badge bg-warning">Pending</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button Show -->
                                            <a href="#" class="btn btn-sm btn-info btn-icon" data-bs-toggle="modal"
                                                data-bs-target="#modalShow{{ $ktm->id }}">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>

                                            <!-- Button Validasi -->
                                            <a href="#"
                                                class="btn btn-sm btn-icon
                                                @if ($ktm->status == 2) btn-success
                                                @elseif ($ktm->status == 0) btn-dark
                                                @else btn-warning @endif"
                                                @if ($ktm->status == 0 || $ktm->status == 2) style="pointer-events: none; cursor: not-allowed;"
                                                @else data-bs-toggle="modal" data-bs-target="#modalValidate{{ $ktm->id }}" @endif>
                                                @if ($ktm->status == 2)
                                                    <i class="btn-icon-prepend text-white" data-feather="check-circle"></i>
                                                @elseif ($ktm->status == 0)
                                                    <i class="btn-icon-prepend text-white" data-feather="x-circle"></i>
                                                @else
                                                    <i class="btn-icon-prepend text-white" data-feather="alert-circle"></i>
                                                @endif
                                            </a>

                                            <!-- Button Edit -->
                                            <a href="#" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $ktm->id }}">
                                                <i class="btn-icon-prepend text-white" data-feather="edit"></i>
                                            </a>

                                            <!-- Button Hapus -->
                                            <form action="{{ route('ktm-validasi.delete', $ktm->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-icon"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="btn-icon-prepend text-white" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Show -->
                                    <div class="modal fade" id="modalShow{{ $ktm->id }}" tabindex="-1"
                                        aria-labelledby="showLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="width: 360px; height: auto;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="showLabel">Detail Foto KTM</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="http://127.0.0.1:9699/{{ $ktm->path_photo }}" alt="KTM Photo"
                                                        style="width: 100%" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Validasi -->
                                    <div class="modal fade" id="modalValidate{{ $ktm->id }}" tabindex="-1"
                                        aria-labelledby="validateLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="validateLabel">Validasi Foto KTM</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda ingin memvalidasi foto KTM ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('ktm-validasi.validate', $ktm->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Ya, Validasi</button>
                                                    </form>
                                                    <form action="{{ route('ktm-validasi.reject', $ktm->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Tidak, Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="modalEdit{{ $ktm->id }}" tabindex="-1"
                                        aria-labelledby="editLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="width: 360px; height: auto;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editLabel">Edit Status KTM</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="http://127.0.0.1:9699/{{ $ktm->path_photo }}"
                                                        alt="KTM Photo" style="width: 100%; margin-bottom: 15px;" />
                                                    <form action="{{ route('ktm-validasi.update-status', $ktm->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status"
                                                                id="pending{{ $ktm->id }}" value="1"
                                                                {{ $ktm->status == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="pending{{ $ktm->id }}">
                                                                Pending
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status"
                                                                id="valid{{ $ktm->id }}" value="2"
                                                                {{ $ktm->status == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="valid{{ $ktm->id }}">
                                                                Validasi
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status"
                                                                id="reject{{ $ktm->id }}" value="0"
                                                                {{ $ktm->status == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="reject{{ $ktm->id }}">
                                                                Ditolak
                                                            </label>
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
@endsection
