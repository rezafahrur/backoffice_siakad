@extends('layouts.app')

@section('title', 'Form Tambah Jadwal')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Jadwal</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Jadwal
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Paket Jadwal</h3>

            {{-- Check for validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade mt-4">
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
                <div class="alert alert-danger alert-dismissible show fade mt-4">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <select id="program_studi" name="program_studi" class="form-control">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ($programStudi as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->nama_program_studi }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select id="kelas" name="kelas" class="form-control">
                        <option value="">-- Pilih Kelas --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="mata_kuliah">Mata Kuliah</label>
                    <select id="mata_kuliah" name="mata_kuliah" class="form-control">
                        <option value="">-- Pilih Mata Kuliah --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ruang_kelas_details">Detail Ruang Kelas</label>
                    <div id="ruang_kelas_details" class="d-flex flex-wrap">
                        <!-- Card options loaded via AJAX -->
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#program_studi').change(function() {
            let programStudiId = $(this).val();
            $.ajax({
                url: `/kuliah/kelas/${programStudiId}`,
                method: 'GET',
                success: function(data) {
                    let kelasOptions = '<option value="">-- Pilih Kelas --</option>';
                    data.forEach(kelas => {
                        kelasOptions +=
                            `<option value="${kelas.id}">${kelas.nama_kelas}</option>`;
                    });
                    $('#kelas').html(kelasOptions);
                }
            });
        });

        $('#kelas').change(function() {
            let kelasId = $(this).val();
            $.ajax({
                url: `/kuliah/mata-kuliah/${kelasId}`,
                method: 'GET',
                success: function(data) {
                    let matkulOptions = '<option value="">-- Pilih Mata Kuliah --</option>';
                    data.forEach(matkul => {
                        matkulOptions += `<option value="${matkul.id}">${matkul.nama}</option>`;
                    });
                    $('#mata_kuliah').html(matkulOptions);
                }
            });
        });

        $('#mata_kuliah').change(function() {
            let matkulId = $(this).val();
            $.ajax({
                url: `/kuliah/ruang-kelas/${matkulId}`,
                method: 'GET',
                success: function(data) {
                    let cardHtml = '';
                    data.forEach(detail => {
                        cardHtml += `
                        <div class="card">
                            <input type="checkbox" name="details[]" value="${detail.id}" />
                            <label>${detail.hari} ${detail.jam_awal} - ${detail.jam_akhir}</label>
                        </div>
                    `;
                    });
                    $('#ruang_kelas_details').html(cardHtml);
                }
            });
        });
    </script>
@endpush
