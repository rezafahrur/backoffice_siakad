@extends('layouts.custom')

@section('title', 'Form Tambah Penilaian')

@section('content')
    {{-- Start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('berita.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('paket-matakuliah.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    <div class="card-header">
        <h4 class="card-title">Form Tambah Penilaian</h4>
    </div>
    <div class="card-body">
        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="beritaForm" action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul_berita" class="form-label">Matakuliah</label>
                <select name="matakuliah" id="matakuliah" class="form-control">
                    <option value="">Pilih MATKUL</option>
                    @foreach ($matakuliahs as $key => $value)
                        <option value="{{ $value['matakuliah_id'] }}">{{ $value['nama_matakuliah'] }}</option>
                    @endforeach        
                </select>
            </div>

            {{-- Datatable Mahasiswa --}}
            <div class="table-responsive mt-4">
                <table class="table table-bordered" id="mahasiswaTable" style="display: none;">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data mahasiswa akan dimuat di sini -->
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <script>
        document.getElementById('matakuliah').addEventListener('change', function() {
            let matakuliahId = this.value;

            if (matakuliahId) {
                fetch(`/nilai/getMahasiswaByMatakuliah?matakuliah_id=${matakuliahId}`)
                    .then(response => response.json())
                    .then(data => {
                        let tableBody = document.querySelector('#mahasiswaTable tbody');
                        tableBody.innerHTML = ''; // Clear previous data
                        
                        if (data.length > 0) {
                            data.forEach(mahasiswa => {
                                let row = `<tr>
                                    <td>${mahasiswa.nim}</td>
                                    <td>${mahasiswa.nama}</td>
                                    <td>${mahasiswa.status}</td>
                                </tr>`;
                                tableBody.innerHTML += row;
                            });

                            document.getElementById('mahasiswaTable').style.display = 'table'; // Show table
                        } else {
                            document.getElementById('mahasiswaTable').style.display = 'none'; // Hide table if no data
                        }
                    })
                    .catch(error => console.error('Error fetching mahasiswa data:', error));
            } else {
                document.getElementById('mahasiswaTable').style.display = 'none'; // Hide table if no matakuliah selected
            }
        });
    </script>
@endsection
