@extends('layouts.app')

@section('title', 'Permintaan Surat')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permintaan Surat</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Permintaan Surat</h6>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive mt-4">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Tahun Akademik</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permintaanSurat as $index => $permintaan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $permintaan->mahasiswa->nama }}</td>
                                        <td>{{ $permintaan->semester->nama_semester }}</td>
                                        <td>
                                            @switch($permintaan->jenis_surat)
                                                @case('1')
                                                    MODELC - Surat Pernyataan Masih Kuliah
                                                @break

                                                @case('2')
                                                    Surat Keterangan Kuliah
                                                @break

                                                @case('3')
                                                    Surat Keterangan Lunas Administrasi
                                                @break

                                                @default
                                                    Tidak Diketahui
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($permintaan->status == 2)
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif ($permintaan->status == 1)
                                                <span class="badge bg-warning">Diproses</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Button to Open Detail Modal -->
                                            <button type="button" class="btn btn-sm btn-info btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#detailModal"
                                                data-id="{{ $permintaan->id }}">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </button>

                                            <!-- Button to Open Proses/Edit Modal -->
                                            <button type="button" class="btn btn-sm btn-primary btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#prosesModal"
                                                data-id="{{ $permintaan->id }}" data-status="{{ $permintaan->status }}"
                                                data-catatan="{{ $permintaan->catatan }}">
                                                <i class="btn-icon-prepend text-white" data-feather="edit"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('permintaan-surat.destroy', $permintaan->id) }}"
                                                method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-delete btn-sm btn-danger btn-icon">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Detail Modal -->
                        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel">Detail Permintaan Surat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Detail content from t_request_surat_detail will be loaded here -->
                                        <p><strong>NIM:</strong> <span id="detailNim"></span></p>
                                        <p><strong>Nama Mahasiswa:</strong> <span id="detailNama"></span></p>
                                        <p><strong>Semester:</strong> <span id="detailSemester"></span></p>
                                        <p><strong>Jenis Surat:</strong> <span id="detailJenisSurat"></span></p>
                                        <p><strong>Nama Orang Tua:</strong> <span id="detailNamaOrangTua"></span></p>
                                        <p><strong>NIP:</strong> <span id="detailNip"></span></p>
                                        <p><strong>Pangkat:</strong> <span id="detailPangkat"></span></p>
                                        <p><strong>Instansi:</strong> <span id="detailInstansi"></span></p>
                                        <p><strong>Status:</strong> <span id="detailStatus"></span></p>
                                        <p><strong>Catatan:</strong> <span id="detailCatatan"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Proses/Edit Modal -->
                        <div class="modal fade" id="prosesModal" tabindex="-1" aria-labelledby="prosesModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="prosesModalLabel">Ubah Status Permintaan Surat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="statusForm" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Pilih Status</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="0">Ditolak</option>
                                                    <option value="1">Diproses</option>
                                                    <option value="2">Selesai</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="catatan" class="form-label">Catatan (Opsional)</label>
                                                <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                                    placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                            </div>
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
                </div>
            </div>
        </div>

        <!-- Script to Populate Modal Form Action Dynamically -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Detail Modal population
                var detailModal = document.getElementById('detailModal');
                detailModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');

                    // Fetch data and populate the modal with AJAX
                    fetch(`/surat/permintaan-surat/${id}/detail`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('detailNim').textContent = data.mahasiswa.nim;
                            document.getElementById('detailNama').textContent = data.mahasiswa.nama;
                            document.getElementById('detailJenisSurat').textContent = data.jenis_surat;
                            document.getElementById('detailStatus').textContent = data.status;
                            document.getElementById('detailCatatan').textContent = data.catatan ||
                                'Tidak ada catatan';
                        });
                });

                // Proses Modal population
                var prosesModal = document.getElementById('prosesModal');
                prosesModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var catatan = button.getAttribute('data-catatan');
                    var status = button.getAttribute('data-status');

                    // Set action URL untuk form sesuai ID
                    var form = document.getElementById('statusForm');
                    form.action = `/surat/permintaan-surat/${id}/proses`;

                    document.getElementById('catatan').value = catatan || '';
                    document.getElementById('status').value = status;
                });
            });
        </script>

    @endsection
