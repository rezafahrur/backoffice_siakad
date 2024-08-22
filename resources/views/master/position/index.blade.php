@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Posisi</h3>
                    <p class="text-subtitle text-muted">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, accusamus.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Master</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Posisi</a>
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
                                Table Data Posisi
                            </h4>
                        </div>
                        <div class="card-body">
                            <p>
                                "Welcome to our web page showcasing the user data of our boarding house, where comfort
                                and convenience come together in one place."
                            </p>
                            <a href="{{ url('master/position/create') }}" class="btn icon icon-left btn-primary"><i
                                    data-feather="user-plus"></i>
                                Add Data Position</a>


                            <!-- table head dark -->
                            <div class="card-header table-responsive">
                                <table class="table" id="psTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Posisi</th>
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
        $(document).ready(function() {
            $('#psTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('position.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'posisi',
                        name: 'posisi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    searchPlaceholder: 'Search..',
                    sSearch: '',
                    paginate: {
                        preveious: 'Prev',
                        next: 'Next'
                    }
                }
            });
        })

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
