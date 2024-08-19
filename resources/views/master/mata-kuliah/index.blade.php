@extends('layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Mata Kuliah</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Table</a>
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
                                Table Data Mata Kuliah
                            </h4>
                        </div>

                        <div class="card-body">
                            <a href="{{ route('mata-kuliah.create') }}" class="mb-3 btn icon icon-left btn-primary"><i
                                    data-feather="user-plus"></i>
                                Add Data</a>
                            <!-- table head dark -->
                            <div class="card-header table-responsive">
                                <table class="table" id="prodiTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Program Studi</th>
                                            <th>Kode Mata Kuliah</th>
                                            <th>Nama Mata Kuliah</th>
                                            <th>SKS</th>
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
            $('#prodiTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('mata-kuliah.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_program_studi',
                        name: 'nama_program_studi'
                    },
                    {
                        data: 'kode_matakuliah',
                        name: 'kode_matakuliah'
                    },
                    {
                        data: 'nama_matakuliah',
                        name: 'nama_matakuliah'
                    },
                    {
                        data: 'sks',
                        name: 'sks'
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
