@extends('layouts.app')

@section('title', 'Data Tahun Ajaran')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Tahun Ajaran</h3>
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
                                <a href="">Tahun Ajaran</a>
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
                                Table Data Tahun Ajaran
                            </h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('tahun-ajaran.create') }}" class="mb-3 btn icon icon-left btn-primary"><i
                                    data-feather="user-plus"></i>
                                Add Data</a>
                            <!-- table head dark -->
                            <div class="card-header table-responsive">
                                <table class="table" id="tahunTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tahun Ajaran</th>
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
        <!-- Table head options end -->
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
    </script>

    <script>
        $(document).ready(function() {
            $('#tahunTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('tahun-ajaran.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
            });
        });
    </script>
@endsection
