@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Jadwal Ujian</h2>

    <!-- Jadwal Ujian Details -->
    <div class="card mb-3">
        <div class="card-header">
            <h5>Kelas: {{ $jadwalUjians->kelas->nama_kelas ?? 'Tidak Diketahui' }}</h5>
        </div>
        <div class="card-body">
            <h6>Detail Jadwal:</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ruang Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Kode Jadwal Ujian</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalUjians->details as $detail)
                        <tr>
                            <td>{{ $detail->ruangKelas->nama_ruang_kelas ?? 'Tidak Diketahui' }}</td>
                            <td>{{ $detail->matakuliah->nama_matakuliah ?? 'Tidak Diketahui' }}</td>
                            <td>{{ $detail->kode_jadwal_ujian }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->jam_mulai)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($detail->jam_akhir)->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('jadwal-ujian.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
@endsection
