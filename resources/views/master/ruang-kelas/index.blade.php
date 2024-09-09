@extends('layouts.app')

@section('title', 'Data Ruang Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ruang Kelas</li>
            <li class="breadcrumb-item active" aria-current="page">Detail Ruang Kelas</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Ruang Kelas</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <button type="button" id="modal-button" class="btn btn-primary btn-icon-text mb-2 mb-md-0"
                                data-bs-toggle="modal" data-bs-target="#productModal">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Produk
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="kelasTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kapasitas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('#kelasTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('kelas.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_ruang_kelas',
                        name: 'kode_ruang_kelas'
                    },
                    {
                        data: 'nama_ruang_kelas',
                        name: 'nama_ruang_kelas'
                    },
                    {
                        data: 'kapasitas',
                        name: 'kapasitas'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                }
            });
        });
    </script>
@endpush
