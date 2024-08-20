@extends('layouts.custom')

@section('title', 'Detail Mahasiswa')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Detail Mahasiswa</h3>
            </div>

            <div class="card-body">
                <!-- Wizard Navigation -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-mahasiswa-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-mahasiswa" type="button" role="tab" aria-controls="pills-mahasiswa"
                            aria-selected="true">Mahasiswa</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-wali-tab" data-bs-toggle="pill" data-bs-target="#pills-wali"
                            type="button" role="tab" aria-controls="pills-wali" aria-selected="false">Wali</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-kontak-darurat-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-kontak-darurat" type="button" role="tab"
                            aria-controls="pills-kontak-darurat" aria-selected="false">Kontak Darurat</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <!-- Mahasiswa Details -->
                    <div class="tab-pane fade show active" id="pills-mahasiswa" role="tabpanel"
                        aria-labelledby="pills-mahasiswa-tab">
                        <h4>Data Mahasiswa</h4>
                        <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
                        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
                        <p><strong>Email:</strong> {{ $mahasiswa->email }}</p>
                        <p><strong>Jurusan:</strong> {{ $jurusan->nama_jurusan }}</p>
                        <p><strong>Program Studi:</strong> {{ $mahasiswa->programStudi->nama_program_studi }}</p>
                        <p><strong>Tanggal Registrasi:</strong> {{ $mahasiswa->registrasi_tanggal }}</p>
                        <p><strong>Status:</strong> {{ $mahasiswa->status }}</p>
                        <p><strong>Semester Berjalan:</strong> {{ $mahasiswa->semester_berjalan }}</p>
                    </div>

                    <!-- Wali Details -->
                    <div class="tab-pane fade" id="pills-wali" role="tabpanel" aria-labelledby="pills-wali-tab">
                        <h4>Data Wali</h4>
                        @if ($wali)
                            <p><strong>Nama:</strong> {{ $wali->ktp->nama }}</p>
                            <p><strong>NIK:</strong> {{ $wali->ktp->nik }}</p>
                            <p><strong>Alamat:</strong> {{ $wali->ktp->alamat_jalan }}</p>
                            <p><strong>Tempat Lahir:</strong> {{ $wali->ktp->lahir_tempat }}</p>
                            <p><strong>Tanggal Lahir:</strong> {{ $wali->ktp->lahir_tgl }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $wali->ktp->jenis_kelamin }}</p>
                            <p><strong>Agama:</strong> {{ $wali->ktp->agama }}</p>
                        @else
                            <p>Data wali tidak tersedia.</p>
                        @endif
                    </div>

                    <!-- Kontak Darurat -->
                    <div class="tab-pane fade" id="pills-kontak-darurat" role="tabpanel"
                        aria-labelledby="pills-kontak-darurat-tab">
                        <h4>Kontak Darurat</h4>
                        <p><strong>Nama Kontak Darurat:</strong> {{ $mahasiswa->nama_kontak_darurat }}</p>
                        <p><strong>Hubungan:</strong> {{ $mahasiswa->hubungan_kontak_darurat }}</p>
                        <p><strong>No. HP:</strong> {{ $mahasiswa->hp_kontak_darurat }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <p class="card-text">
            Click the buttons below to show and hide another element via class changes:
        </p>
        <p>
            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Link with href
            </a>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Button with data-bs-target
            </button>
            </p>
            <div class="collapse" id="collapseExample">
                Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
@endsection
