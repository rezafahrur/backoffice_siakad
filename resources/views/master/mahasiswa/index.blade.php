@extends('layouts.app')

@section('title', 'Mahasiswa')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Mahasiswa</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
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
                                    <th>NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>Program Studi</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mahasiswa as $mhs)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mhs->nim }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td>{{ $mhs->programStudi->nama_program_studi }}</td>
                                        <td>
                                            @if ($mhs->status == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Non-Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('mahasiswa.edit', $mhs->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="check-square"></i>
                                            </a>
                                            <a href="{{ route('mahasiswa.show', $mhs->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                            @if ($mhs->status == 0)
                                                <button class="btn btn-sm btn-success btn-icon" title="Bayar"
                                                    data-semester="{{ $mhs->semester_berjalan }}"
                                                    data-mahasiswa-id="{{ $mhs->id }}"
                                                    data-program-studi-id="{{ $mhs->program_studi_id }}"
                                                    data-nama="{{ $mhs->nama }}" data-bs-toggle="modal"
                                                    data-bs-target="#bayarModal"
                                                    onclick="openBayarModal({{ $mhs->id }})">
                                                    <i class="btn-icon-prepend" data-feather="dollar-sign"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Vertically Centered Modal -->
                    <div class="modal fade" id="bayarModal" tabindex="-1" role="dialog" aria-labelledby="bayarModalTitle"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bayarModalTitle">Pilih Kurikulum dan Pembayaran : <br>
                                        {{ $mhs->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="bayarForm" action="{{ route('mahasiswa.bayar') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <!-- Input Mahasiswa ID (Hidden) -->
                                        <input type="hidden" name="mahasiswa_id" id="mahasiswaIdInput">

                                        <!-- Input Status Aktif (Hidden) -->
                                        <input type="hidden" name="status" value="1">

                                        <!-- Input Tanggal Transfer -->
                                        <div class="mb-3">
                                            <label for="tgl_transfer">Tanggal Transfer</label>
                                            <input type="date" class="form-control" id="tgl_transfer" name="tgl_transfer"
                                                required>
                                        </div>

                                        <!-- Select Kurikulum -->
                                        <div class="mb-3">
                                            <label for="kurikulum_id">Kurikulum</label>
                                            <select class="form-control" id="kurikulum_id" name="kurikulum_id" required>
                                                <option value="" disabled selected>Pilih Kurikulum</option>
                                            </select>
                                        </div>

                                        <!-- Detail Kurikulum -->
                                        <div class="mb-3">
                                            <label>Mata Kuliah</label>
                                            <ul id="kurikulumDetails">
                                                <!-- Mata Kuliah Details akan dimuat di sini -->
                                            </ul>
                                        </div>

                                        <!-- Select Kelas -->
                                        <div class="mb-3">
                                            <label for="kelas_id">Kelas</label>
                                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                                <option value="" disabled selected>Pilih Kelas</option>
                                            </select>
                                            <span id="kelas_kapasitas">Kapasitas : - | Jumlah Mahasiswa : -</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary ms-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openBayarModal(mahasiswaId) {
            // Set mahasiswa_id ke input hidden dalam form
            $('#mahasiswaIdInput').val(mahasiswaId);

            // Ganti title modal dengan nama mahasiswa
            var namaMahasiswa = $('button[data-mahasiswa-id="' + mahasiswaId + '"]').data('nama');
            $('#bayarModalTitle').html('Pilih Kurikulum dan Pembayaran : <br>' + namaMahasiswa);

            // Ambil semester dan prodi_id dari data attribute pada button
            var semester = $('button[data-mahasiswa-id="' + mahasiswaId + '"]').data('semester');
            var prodiId = $('button[data-mahasiswa-id="' + mahasiswaId + '"]').data('program-studi-id');

            // request AJAX untuk mendapatkan kurikulum berdasarkan semester dan program studi
            $.ajax({
                url: '/get-kurikulum-by-semester',
                type: 'GET',
                data: {
                    semester: semester,
                    prodi_id: prodiId
                },
                success: function(data) {
                    $('#kurikulum_id').empty();
                    $('#kurikulum_id').append('<option value="" disabled selected>Pilih Kurikulum</option>');
                    $.each(data, function(key, paket) {
                        $('#kurikulum_id').append('<option value="' + paket.id + '">' + paket
                            .nama_kurikulum + '</option>');
                    });
                    $('#bayarModal').modal('show');
                },
                error: function() {
                    alert('Gagal memuat data paket mata kuliah.');
                }
            });

            // Event listener untuk ketika kurikulum dipilih
            $('#kurikulum_id').on('change', function() {
                var kurikulumId = $(this).val();

                if (kurikulumId) {
                    $.ajax({
                        url: '/get-kurikulum-details/' + kurikulumId,
                        type: 'GET',
                        success: function(data) {
                            var matkulHtml = '';
                            var kelasHtml = '';

                            // Handle Mata Kuliah Details
                            if (data.matakuliah_details && data.matakuliah_details.length > 0) {
                                data.matakuliah_details.forEach(function(detail) {
                                    matkulHtml += '<li><strong>' + detail.nama_matakuliah +
                                        '</strong></li>';
                                });
                            } else {
                                matkulHtml = '<li>Detail tidak ditemukan.</li>';
                            }

                            // Handle Kelas Details
                            if (data.kelas_details && data.kelas_details.length > 0) {
                                data.kelas_details.forEach(function(kelas) {
                                    kelasHtml += '<option value="' + kelas.id +
                                        '" data-kapasitas="' + kelas.kapasitas +
                                        '" data-jumlah="' + kelas.jumlah_mahasiswa + '">' +
                                        kelas.nama_kelas + '</option>';
                                });
                            } else {
                                kelasHtml = '<option value="">Kelas tidak tersedia</option>';
                            }

                            $('#kurikulumDetails').html(matkulHtml);
                            $('#kelas_id').html(kelasHtml);

                            // Reset kapasitas dan jumlah mahasiswa
                            $('#kelas_kapasitas').html('Kapasitas : - | Jumlah Mahasiswa : -');

                            // Trigger change event to update details for the initially selected kelas
                            $('#kelas_id').trigger('change');
                        },
                        error: function() {
                            $('#kurikulumDetails').html('<p>Gagal memuat detail kurikulum.</p>');
                            $('#kelas_id').html('<option value="">Gagal memuat kelas</option>');
                            $('#kelas_kapasitas').html('Kapasitas : - | Jumlah Mahasiswa : -');
                        }
                    });
                } else {
                    $('#kurikulumDetails').html('');
                    $('#kelas_id').html('');
                    $('#kelas_kapasitas').html('Kapasitas : - | Jumlah Mahasiswa : -');
                }
            });

            // Event listener untuk ketika kelas dipilih
            $('#kelas_id').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var kapasitas = selectedOption.data('kapasitas');
                var jumlahMahasiswa = selectedOption.data('jumlah');

                $('#kelas_kapasitas').html('Kapasitas : ' + kapasitas + ' | Jumlah Mahasiswa : ' + jumlahMahasiswa);
            });

            // Event listener untuk modal close
            $('#bayarModal').on('hidden.bs.modal', function() {
                // Reset kurikulum details
                $('#kurikulum_id').html('<option value="" disabled selected>Pilih Kurikulum</option>');
                $('#kurikulumDetails').html('');
                $('#kelas_id').html('<option value="" disabled></option>');
                $('#kelas_kapasitas').html('Kapasitas : - | Jumlah Mahasiswa : -');
            });
        }
    </script>
@endpush
