@extends('layouts.custom')

@section('title', 'Form Create Prestasi')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('prestasi.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('prestasi.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- endt logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Create Prestasi</h4>
    </div>
    <div class="card-body">
        {{-- Check for validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Check for other error messages --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('prestasi.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Program Studi --}}
                <div class="col-md-6 mb-3">
                    <label for="program_studi_id" class="form-label">Program Studi</label>
                    <select name="program_studi_id" class="form-select" id="program_studi_id" required>
                        <option value="" disabled selected>Pilih Program Studi</option>
                        @foreach ($programStudi as $prd)
                            <option value="{{ $prd->id }}">{{ $prd->nama_program_studi }}</option>
                        @endforeach
                    </select>
                    @error('program_studi_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Mahasiswa --}}
                <div class="col-md-6 mb-3">
                    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                    <select name="mahasiswa_id" class="form-select" id="mahasiswa_id" disabled required>
                        <option value="" disabled selected>Pilih Mahasiswa</option>
                    </select>
                    @error('mahasiswa_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nama Prestasi --}}
                <div class="col-md-6 mb-3">
                    <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi"
                        class="form-control @error('nama_prestasi') is-invalid @enderror"
                        value="{{ old('nama_prestasi') }}" placeholder="Nama Prestasi" required>
                    @error('nama_prestasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Penyelenggara --}}
                <div class="col-md-6 mb-3">
                    <label for="penyelenggara" class="form-label">Penyelenggara</label>
                    <input type="text" name="penyelenggara"
                        class="form-control @error('penyelenggara') is-invalid @enderror"
                        value="{{ old('penyelenggara') }}" required placeholder="Penyelenggara"> @error('penyelenggara')>
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Jenis Prestasi --}}
                <div class="col-md-3 mb-3">
                    <label for="jenis_prestasi" class="form-label">Jenis Prestasi</label>
                    <select name="jenis_prestasi" class="form-select @error('jenis_prestasi') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Jenis Prestasi</option>
                        <option value="1">Sains</option>
                        <option value="2">Seni</option>
                        <option value="3">Olahraga</option>
                        <option value="9">Lainnya</option>
                    </select>
                    @error('jenis_prestasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tingkat Prestasi --}}
                <div class="col-md-3 mb-3">
                    <label for="tingkat_prestasi" class="form-label">Tingkat Prestasi</label>
                    <select name="tingkat_prestasi" class="form-select @error('tingkat_prestasi') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Tingkat Prestasi</option>
                        <option value="1">Sekolah</option>
                        <option value="2">Kecamatan</option>
                        <option value="3">Kabupaten / Kota</option>
                        <option value="4">Provinsi</option>
                        <option value="5">Nasional</option>
                        <option value="6">Internasional</option>
                        <option value="7">Regional</option>
                        <option value="9">Lainnya</option>
                    </select>
                    @error('tingkat_prestasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Peringkat --}}
                <div class="col-md-3 mb-3">
                    <label for="peringkat" class="form-label">Peringkat</label>
                    <input type="text" class="form-control @error('peringkat') is-invalid @enderror" id="peringkat"
                        name="peringkat" placeholder="00" value="{{ old('peringkat') }}" maxlength="2"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 2)" required>
                    @error('peringkat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tahun --}}
                <div class="col-md-3 mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun"
                        name="tahun" placeholder="0000" value="{{ old('tahun') }}" maxlength="4"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)" required>
                    @error('tahun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#program_studi_id').on('change', function() {
                var programStudiId = $(this).val();

                // Kosongkan dropdown mahasiswa
                $('#mahasiswa_id').empty().append(
                    '<option value="" disabled selected>Pilih Mahasiswa</option>');

                if (programStudiId) {
                    // AJAX request untuk mengambil mahasiswa berdasarkan program studi yang dipilih
                    $.ajax({
                        url: '{{ route('getMahasiswaByProdi') }}',
                        type: 'GET',
                        data: {
                            program_studi_id: programStudiId
                        },
                        success: function(data) {
                            $('#mahasiswa_id').prop('disabled', false);
                            $.each(data, function(key, value) {
                                $('#mahasiswa_id').append('<option value="' + value.id +
                                    '">' + value.nim + ' - ' + value.nama +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#mahasiswa_id').prop('disabled',
                        true); // Disable dropdown jika program studi tidak dipilih
                }
            });
        });
    </script>
@endpush
