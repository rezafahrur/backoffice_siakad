@extends('layouts.custom')

@section('title', 'Form Paket MataKuliah')

@section('content')
    {{-- start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('paket-matakuliah.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('paket-matakuliah.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    <div class="card-header">
        <h4 class="card-title">Form Paket MataKuliah</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('paket-matakuliah.store') }}" method="POST">
            @csrf

            {{-- nama_paket_matakuliah --}}
            <div class="mb-3">
                <label for="nama_paket_matakuliah" class="form-label">Nama Paket Mata Kuliah</label>
                <input type="text" class="form-control" id="nama_paket_matakuliah" name="nama_paket_matakuliah" placeholder="Nama Paket Matakuliah" required>
            </div>

            {{-- program_studi_id --}}
            <div class="mb-3">
                <label for="program_studi_id" class="form-label">Program Studi</label>
                <select class="form-select" id="program_studi_id" name="program_studi_id" required>
                    <option value="" disabled selected>Pilih Program Studi</option>
                    @foreach($programStudi as $prodi)
                        <option value="{{ $prodi->id }}">
                            {{ $prodi->kode_program_studi }} - {{ $prodi->nama_program_studi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- semester --}}
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-select" id="semester" name="semester" required>
                    <option value="" disabled selected>Pilih Semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>

            {{-- status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="" disabled selected>Pilih Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="multiple-select-field" name="matakuliah_id[]" multiple required>

                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- jQuery Full Version -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <script>
    $(document).ready(function() {
    $('#multiple-select-field').select2({
        theme: "bootstrap-5",
        width: '100%',
        placeholder: "Pilih Mata Kuliah",
        closeOnSelect: false
    });

    const programStudiSelect = $('#program_studi_id');
    const semesterSelect = $('#semester');
    const mataKuliahSelect = $('#multiple-select-field');

    function fetchMataKuliah() {
        const programStudiId = programStudiSelect.val();
        const semester = semesterSelect.val();

        $.ajax({
            url: `/paket-matakuliah/get-matakuliah/${programStudiId}/${semester}`,
            method: 'GET',
            success: function(response) {
                mataKuliahSelect.empty();
                response.forEach(mataKuliah => {
                    mataKuliahSelect.append(new Option(mataKuliah.nama_matakuliah, mataKuliah.id, false, false));
                });
                mataKuliahSelect.trigger('change');
            },
            error: function(xhr) {
                mataKuliahSelect.empty(); // Hapus opsi yang ada
                if (xhr.status === 404) {
                    mataKuliahSelect.append(new Option('Mata Kuliah tidak ditemukan.', '', false, false));
                } else {
                    mataKuliahSelect.append(new Option('Terjadi kesalahan pada server.', '', false, false));
                }
                mataKuliahSelect.trigger('change'); // Memperbarui dropdown
            }
        });
    }

    programStudiSelect.on('change', fetchMataKuliah);
    semesterSelect.on('change', fetchMataKuliah);
});


    </script>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
