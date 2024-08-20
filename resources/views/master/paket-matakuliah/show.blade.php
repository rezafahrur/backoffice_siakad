@extends('layouts.custom')

@section('title', 'Detail Paket Matakuliah')

@section('content')
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-light">
            <div class="container d-block">
                <a href="{{ route('paket-matakuliah.index') }}"><i class="bi bi-chevron-left"></i></a>
                <a class="navbar-brand ms-4" href="{{ route('paket-matakuliah.index') }}">
                    <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
                </a>
            </div>
        </nav>

        <!-- Detail Paket Mata Kuliah -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ $paketMatakuliah->nama_paket_matakuliah }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Program Studi:</strong> 
                    <span class="badge bg-secondary">{{ $paketMatakuliah->programStudi->nama_program_studi }}</span>
                </div>
                <div class="mb-2">
                    <strong>Semester:</strong> 
                    <span class="badge bg-info">{{ $paketMatakuliah->semester }}</span>
                </div>
                <div>
                    <strong>Status:</strong> 
                    <span class="badge {{ $paketMatakuliah->status == '1' ? 'bg-success' : 'bg-danger' }}">
                        {{ $paketMatakuliah->status == '1' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                
            </div>
        </div>

        <!-- Daftar Mata Kuliah -->
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h4 class="mb-0">Daftar Mata Kuliah</h4>
            </div>
            <div class="card-body">
                @if($paketMatakuliah->paketMataKuliahDetail->isEmpty())
                    <div class="alert alert-warning" role="alert">
                        Tidak ada mata kuliah yang ditambahkan pada paket ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nama Matakuliah</th>
                                    <th scope="col">Kode Mata Kuliah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paketMatakuliah->paketMataKuliahDetail as $detail)
                                    <tr>
                                        <td>{{ $detail->matakuliah->nama_matakuliah }}</td>
                                        <td>{{ $detail->matakuliah->kode_matakuliah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        
        

    </div>
@endsection
