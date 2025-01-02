@extends('layouts.app')

@section('title', 'Validasi KTM Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Data</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Validasi SPMB Pendaftaran</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-3">Data Validasi Pendaftar</h6>

                    <a href="{{ route('spmb.exportPDF') }}" class="btn btn-primary mt-3">
                        <i data-feather="file-text" class="me-2"></i> Unduh Semua PDF
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>No Pendaftaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftar as $key => $spmb)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $spmb->user ? $spmb->user->name : 'Tidak Tersedia' }}</td>
                                        <td>{{ $spmb->no_pendaftaran }}</td>
                                        <td>
                                            @if ($spmb->status == 0)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($spmb->status == 1)
                                                <span class="badge bg-success">Diterima</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button Validasi -->
                                            <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#modalValidate{{ $spmb->id }}">
                                                <i class="btn-icon-prepend text-white" data-feather="check-circle"></i>
                                            </button>

                                            <!-- Button Reject -->
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalReject{{ $spmb->id }}">
                                                <i class="btn-icon-prepend text-white" data-feather="x-circle"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Validasi -->
                                    <div class="modal fade" id="modalValidate{{ $spmb->id }}" tabindex="-1"
                                        aria-labelledby="validateLabel{{ $spmb->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="validateLabel{{ $spmb->id }}">Validasi
                                                        Pendaftar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin memvalidasi pendaftar ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('spmb.validate', $spmb->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success">Ya, Validasi</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Reject -->
                                    <div class="modal fade" id="modalReject{{ $spmb->id }}" tabindex="-1"
                                        aria-labelledby="rejectLabel{{ $spmb->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectLabel{{ $spmb->id }}">Tolak
                                                        Pendaftar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menolak pendaftar ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('spmb.reject', $spmb->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
