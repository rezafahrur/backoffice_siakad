@extends('layouts.app')

@section('title', 'Data Ruang Kelas')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Jurusan</h3>
                    <p class="text-subtitle text-muted">
                        Who does not love The Kost
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="">Master</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="">Jurusan</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Table head options start -->
        <section class="section">
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Table Data Jurusan
                            </h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('jurusan.create') }}" class="mb-3 btn icon icon-left btn-primary"><i
                                    data-feather="user-plus"></i>
                                Add Data</a>

                            <div class="card-header table-responsive">
                                <table class="table" id="jrTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Kode Jurusan</th>
                                            <th>Nama Jurusan</th>
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
        </section>
    </div>
@endsection
@section('script')
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif


        $(document).ready(function() {
            $('#jrTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('jurusan.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_jurusan',
                        name: 'kode_jurusan'
                    },
                    {
                        data: 'nama_jurusan',
                        name: 'nama_jurusan'
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
@endsection
