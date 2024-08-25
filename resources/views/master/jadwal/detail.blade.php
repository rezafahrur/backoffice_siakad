@extends('layouts.custom')

@section('title', 'Detail Jadwal')

@section('content')
    <div class="container">
        <nav class="navbar navbar-light">
            <div class="container d-block">
                <a href="{{ route('jadwal.index') }}"><i class="bi bi-chevron-left"></i></a>
                <a class="navbar-brand ms-4" href="{{ route('jadwal.index') }}">
                    <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
                </a>
            </div>
        </nav>
        <div class="card shadow-sm mb-4">
            <div class="card-header mb-3">
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
            </div>
        </div>
    </div>
@endsection
