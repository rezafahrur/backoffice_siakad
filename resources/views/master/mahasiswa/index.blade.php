@extends('layouts.app')

@section('title', 'Mahasiswa')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Mahasiswa</h3>
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
                                <a href="">Table</a>
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
                                Table Data Mahasiswa
                            </h4>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('mahasiswa.create') }}" class="btn icon icon-left btn-primary"><i
                                    data-feather="user-plus"></i>
                                Add Data</a>
                            <!-- table head dark -->
                            <div class="card-header table-responsive">
                                <table class="table" id="mhsTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nim</th>
                                            <th>Nama Lengkap</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Vertically Centered Modal -->
                            <div class="modal fade" id="bayarModal" tabindex="-1" role="dialog"
                                aria-labelledby="bayarModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bayarModalTitle">Pilih Paket Mata Kuliah dan
                                                Pembayaran</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <form id="bayarForm" action="{{ route('mahasiswa.bayar') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <!-- Input Mahasiswa ID (Hidden) -->
                                                <input type="hidden" name="mahasiswa_id" id="mahasiswaIdInput">

                                                {{-- Input Status Aktif (Hidden) --}}
                                                <input type="hidden" name="status" value="1">

                                                <!-- Input Tanggal Transfer -->
                                                <div class="form-group">
                                                    <label for="tgl_transfer">Tanggal Transfer</label>
                                                    <input type="date" class="form-control" id="tgl_transfer"
                                                        name="tgl_transfer" required>
                                                </div>

                                                <!-- Select Paket Mata Kuliah -->
                                                <div class="form-group">
                                                    <label for="paket_matakuliah_id">Paket Mata Kuliah</label>
                                                    <select class="form-control" id="paket_matakuliah_id"
                                                        name="paket_matakuliah_id" required>
                                                        <option value="" disabled selected>Pilih Paket Mata Kuliah
                                                        </option>
                                                    </select>
                                                </div>

                                                <!-- Detail Paket Mata Kuliah -->
                                                <div id="paketMatakuliahDetails">
                                                    <!-- Detail mata kuliah akan muncul di sini -->
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Close</span>
                                                </button>
                                                <button type="submit" class="btn btn-primary ms-1">
                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Submit</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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
        $(document).ready(function() {
            $('#mhsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('mahasiswa.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            return data == 1 ? 'Aktif' : 'Nonaktif';
                        }
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
                        previous: 'Prev',
                        next: 'Next'
                    }
                }
            });

            $('#paket_matakuliah_id').on('change', function() {
                var paketId = $(this).val();

                if (paketId) {
                    $.ajax({
                        url: '/get-paket-matakuliah-details/' + paketId,
                        type: 'GET',
                        success: function(data) {
                            if (data) {
                                var detailHtml = '';

                                data.matakuliah_details.forEach(function(detail) {
                                    detailHtml += '<p><strong>' + detail
                                        .nama_matakuliah + '</strong></p>';
                                });

                                $('#paketMatakuliahDetails').html(detailHtml);
                            }
                        },
                        error: function() {
                            $('#paketMatakuliahDetails').html('<p>Detail tidak ditemukan.</p>');
                        }
                    });
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
    <script>
        function openBayarModal(mahasiswaId) {
            // Set mahasiswa_id ke input hidden dalam form
            $('#mahasiswaIdInput').val(mahasiswaId);

            // Ganti title modal dengan nama mahasiswa
            var namaMahasiswa = $('button[data-mahasiswa-id="' + mahasiswaId + '"]').data('nama');
            $('#bayarModalTitle').text('Pilih Paket Mata Kuliah dan Pembayaran untuk ' + namaMahasiswa);

            // Ambil semester dari data attribute pada button
            var semester = $('button[data-mahasiswa-id="' + mahasiswaId + '"]').data('semester');

            // Assuming `prodiId` is obtained from the button's data attribute
            var prodiId = $('button[data-mahasiswa-id="' + mahasiswaId + '"]').data('program-studi-id');

            $.ajax({
                url: '/get-paket-matakuliah-by-semester',
                type: 'GET',
                data: {
                    semester: semester,
                    prodi_id: prodiId
                },
                success: function(data) {
                    $('#paket_matakuliah_id').empty();
                    $('#paket_matakuliah_id').append(
                        '<option value="" disabled selected>Pilih Paket Mata Kuliah</option>'
                    );
                    $.each(data, function(key, paket) {
                        $('#paket_matakuliah_id').append(
                            '<option value="' + paket.id + '">' + paket.nama_paket_matakuliah +
                            '</option>'
                        );
                    });
                    $('#bayarModal').modal('show');
                },
                error: function() {
                    alert('Gagal memuat data paket mata kuliah.');
                }
            });
        }
    </script>
@endsection
