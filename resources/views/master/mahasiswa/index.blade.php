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
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <a href="#" class="btn btn-primary btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal"
                                data-bs-target="#quickAddModal">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data Ringkas
                            </a>
                            <a href="#" class="btn btn-success btn-icon-text mb-2 mb-md-0" data-bs-toggle="modal"
                                data-bs-target="#importModal">
                                <i class="btn-icon-prepend" data-feather="upload"></i>
                                Import
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                            <a href="{{ route('mahasiswa.export', ['dataLengkap' => 1]) }}"
                                class="btn btn-success btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="download"></i>
                                Template
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
                                    <th>Data Lengkap</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mahasiswa as $mhs)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mhs->nim }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td>{{ $mhs->programStudi->nama_program_studi }}</td>
                                        <td class="text-center">
                                            @if ($mhs->is_filled == 1)
                                                <span class="badge bg-success">
                                                    <i class="col-sm-6 col-md-4 col-lg-3" data-feather="check"
                                                        style="width: 12px; height: 12px;"></i>
                                                    <span class="d-none">1</span>
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="col-sm-6 col-md-4 col-lg-3" data-feather="x"
                                                        style="width: 12px; height: 12px;"></i>
                                                    <span class="d-none">0</span>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($mhs->status == 1)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Nonaktif</span>
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
                                                class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                                            <input type="date" class="form-control" id="tgl_transfer"
                                                name="tgl_transfer" required>
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
                <div class="card-body">
                    <!-- Modal Tambah Data Cepat -->
                    <div class="modal fade bd-example-modal-lg" id="quickAddModal" tabindex="-1"
                        aria-labelledby="quickAddModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="quickAddModalLabel">Tambah Data Cepat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Check for validation errors --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade mt-4">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    {{-- Check for other error messages --}}
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible show fade mt-4">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{ route('mahasiswa.quickAdd') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            {{-- Nama --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    id="nama" name="nama" placeholder="NAMA"
                                                    value="{{ old('nama') ? strtoupper(old('nama')) : '' }}"
                                                    oninput="this.value = this.value.toUpperCase()">
                                                @error('nama')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Email --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="Email"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Jurusan --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="jurusan" class="form-label">Jurusan</label>
                                                <select class="form-select @error('jurusan') is-invalid @enderror"
                                                    id="jurusan" name="jurusan" required>
                                                    <option value="" disabled selected>Pilih Jurusan</option>
                                                    @foreach ($jurusan as $js)
                                                        <option value="{{ $js->id }}"
                                                            {{ old('jurusan') == $js->id ? 'selected' : '' }}>
                                                            {{ $js->nama_jurusan }}
                                                        </option>
                                                    @endforeach
                                                    </option>
                                                </select>
                                                @error('jurusan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Program Studi --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="program_studi" class="form-label">Program Studi</label>
                                                <select class="form-select @error('program_studi') is-invalid @enderror"
                                                    id="program_studi" name="program_studi">
                                                    <option value="" disabled selected>Pilih Program Studi</option>
                                                    @foreach ($prodi as $ps)
                                                        <option value="{{ $ps->id }}"
                                                            {{ old('program_studi') == $ps->id ? 'selected' : '' }}>
                                                            {{ $ps->nama_program_studi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('program_studi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Registrasi Tanggal --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="registrasi_tanggal" class="form-label">Registrasi
                                                    Tanggal</label>
                                                <input type="date"
                                                    class="form-control @error('registrasi_tanggal') is-invalid @enderror"
                                                    id="registrasi_tanggal" name="registrasi_tanggal"
                                                    value="{{ old('registrasi_tanggal') }}">
                                                @error('registrasi_tanggal')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Status Mahasiswa --}}
                                            <input type="hidden" name="status" id="status" value="0">

                                            {{-- Semester Berjalan --}}
                                            <input type="hidden" name="semester_berjalan" id="semester_berjalan"
                                                value="1">

                                            {{-- Is Filled --}}
                                            <input type="hidden" name="is_filled" id="is_filled" value="0">

                                            {{-- Telp Rumah --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="telp_rumah" class="form-label">Telp Rumah</label>
                                                <input type="text"
                                                    class="form-control @error('telp_rumah') is-invalid @enderror"
                                                    id="telp_rumah" name="telp_rumah" placeholder="Telp Rumah"
                                                    value="{{ old('telp_rumah') }}" maxlength="13"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                                @error('telp_rumah')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- No Hp --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="no_hp" class="form-label">No HP</label>
                                                <input type="text"
                                                    class="form-control @error('no_hp') is-invalid @enderror"
                                                    id="no_hp" name="no_hp" placeholder="No HP"
                                                    value="{{ old('no_hp') }}" maxlength="13"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)">
                                                @error('no_hp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Alamat Domisili --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="alamat_domisili" class="form-label">Alamat Domisili</label>
                                                <textarea class="form-control @error('alamat_domisili') is-invalid @enderror" id="alamat_domisili"
                                                    name="alamat_domisili" placeholder="Alamat Domisili" oninput="this.value = this.value.toUpperCase()">{{ old('alamat_domisili') }}</textarea>
                                                @error('alamat_domisili')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            {{-- Kode Pos --}}
                                            <div class="col-md-4 mb-3">
                                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                                <input type="text"
                                                    class="form-control @error('kode_pos') is-invalid @enderror"
                                                    id="kode_pos" name="kode_pos" placeholder="Kode Pos"
                                                    value="{{ old('kode_pos') }}" maxlength="5"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5)">
                                                @error('kode_pos')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
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
                <div class="card-body">
                    <!-- Modal Import Data Mahasiswa -->
                    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importModalLabel">Import Data Mahasiswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Check for validation errors --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade mt-4">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    {{-- Check for success message --}}
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible show fade mt-4">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    {{-- Check for other error messages --}}
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible show fade mt-4">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <a href="{{ route('mahasiswa.export', ['dataLengkap' => 0]) }}"
                                            class="btn btn-success btn-icon-text mb-2 mb-md-0">
                                            <i class="btn-icon-prepend" data-feather="download"></i>
                                            Template
                                        </a>
                                    </div>

                                    <form action="{{ route('mahasiswa.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload File Excel/CSV</label>
                                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                                id="file" name="file" required>
                                            @error('file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </div>
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
