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

                    <!-- Flash Message for Success -->
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
                                    <th>NIM</th>
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
                                        <td>{{ $permintaan->mahasiswa->nim }}</td>
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
                                            <!-- Button to Open Modal -->
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

                        <!-- Modal for Updating Status -->
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
                var prosesModal = document.getElementById('prosesModal');
                prosesModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var id = button.getAttribute('data-id');
                    var catatan = button.getAttribute('data-catatan');
                    var status = button.getAttribute('data-status');

                    var form = document.getElementById('statusForm');
                    form.action = "/mhs/permintaan-surat/" + id + "/proses";

                    var catatanTextarea = document.getElementById('catatan');
                    catatanTextarea.value = catatan ? catatan :
                        '';

                    var statusSelect = document.getElementById('status');
                    statusSelect.value = status;
                });
            });
        </script>
    @endsection
