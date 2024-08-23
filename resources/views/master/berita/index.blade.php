@extends('layouts.app')

@section('title', 'Berita')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Berita</h3>
                <p class="text-subtitle text-muted">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, accusamus.
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Dashboard</a>
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
                            Table Data Berita
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>
                                "Welcome to our web page showcasing the user data of our boarding house, where comfort
                                and convenience come together in one place."
                            </p>
                            <a href="{{ route('berita.create') }}" class="btn icon icon-left btn-primary">
                                <i data-feather="user-plus"></i> Add Data Berita
                            </a>
                        </div>

                        <!-- table head dark -->
                        <div class="card-header table-responsive">
                            <table id="beritaTable" class="table mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Judul Berita</th>
                                        <th>Kategori</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="m-3 pagination pagination-primary">
                            {{-- {{ $users->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Table head options end -->
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#beritaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('berita.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'judul_berita', name: 'judul_berita' },
                { data: 'kategori_berita', name: 'kategori_berita' },
                { data: 'photo', name: 'photo', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries available",
                infoFiltered: "(filtered from _MAX_ total entries)"
            }
        });

        $(document).on('click', '.btn-delete', function() {
            const beritaId = $(this).data('id');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/berita/delete/${beritaId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.success,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#beritaTable').DataTable().ajax.reload(); // Reload the table data
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif
    });
</script>

@endsection
