@extends('layouts.app')

@section('title', 'Detail Ruang Kelas')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('ruang-kelas.index') }}">Ruang Kelas</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Ruang Kelas
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Ruang Kelas</h4>

            <!-- Detail Informasi Ruang Kelas -->
            <dl class="row col-md-6">
                <dt class="col-sm-4">Kode Ruang Kelas</dt>
                <dd class="col-sm-8">{{ $ruangKelas->kode_ruang_kelas }}</dd>
                <dt class="col-sm-4">Nama Ruang Kelas</dt>
                <dd class="col-sm-8">{{ $ruangKelas->nama_ruang_kelas }}</dd>
                <dt class="col-sm-4">Kapasitas</dt>
                <dd class="col-sm-8">{{ $ruangKelas->kapasitas }} orang</dd>
            </dl>

            <!-- Tabel Jadwal Ruang Kelas -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            @foreach ($schedules as $hari => $jadwal)
                                <th>{{ $hari }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($schedules as $hari => $jadwal)
                                <td>
                                    @foreach ($jadwal as $detail)
                                        <p>{{ $detail->jam_awal }} - {{ $detail->jam_akhir }}</p>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Kembali -->
            <a href="{{ route('ruang-kelas.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
@endsection
