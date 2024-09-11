@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Jadwal</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detail Jadwal
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header mt-2">
            <h4>{{ $jadwal->paketMataKuliah->nama_paket_matakuliah ?? 'N/A' }}</h4>
        </div>
        <div class="card-body">
            <h5 class="mb-3">Detail Jadwal:</h5>
            @if ($jadwal->details->isEmpty())
                <p>Tidak ada detail tersedia.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Mata Kuliah</th>
                                <th scope="col">Ruang Kelas</th>
                                <th scope="col">Hari</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal->details as $detail)
                                <tr>
                                    <td>{{ $detail->paketMataKuliahDetail->matakuliah->nama_matakuliah ?? 'N/A' }}</td>
                                    <td>{{ $detail->ruangKelas->nama_ruang_kelas ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $days = [
                                                1 => 'Senin',
                                                2 => 'Selasa',
                                                3 => 'Rabu',
                                                4 => 'Kamis',
                                                5 => 'Jumat',
                                                6 => 'Sabtu',
                                                7 => 'Minggu',
                                            ];
                                            echo $days[$detail->jadwal_hari] ?? 'N/A';
                                        @endphp
                                    </td>
                                    <td>
                                        {{ substr($detail->jadwal_jam_mulai, 0, 5) ?? 'N/A' }} -
                                        {{ substr($detail->jadwal_jam_akhir, 0, 5) ?? 'N/A' }}
                                    </td>
                                    <td>{{ $detail->hr->nama ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>
@endsection
