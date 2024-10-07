@extends('layouts.app')

@section('title', 'Aktivitas Mahasiswa Bimbing Uji')

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Aktivitas Mahasiswa Bimbing Uji</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daftar Aktivitas Mahasiswa Bimbing Uji</h6>
                    <div class="d-flex justify-content-end mb-3">
                        <div>
                            <a href="{{ route('bimbingUji.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="plus-square"></i>
                                Tambah Data
                            </a>
                            <a href="{{ route('bimbingUji.export') }}" class="btn btn-success btn-icon-text">
                                <i class="btn-icon-prepend" data-feather="download"></i>
                                Aktivitas Mahasiswa Bimbing Uji
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Aktivitas</th>
                                    <th>NIDN Dosen</th>
                                    <th>Nama Dosen</th>
                                    <th>Jenis Peran</th>
                                    <th>Urutan Pembimbing</th>
                                    <th>Kategori Kegiatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bimbingUji as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->aktivitasMahasiswa->kode_aktivitas }}</td>
                                        <td>{{ $item->nidn_dosen }}</td>
                                        <td>{{ $item->nama_dosen }}</td>
                                        <td>
                                            @if ($item->jenis_peran == 1)
                                                Pembimbing
                                            @elseif ($item->jenis_peran == 2)
                                                Penguji
                                            @else
                                                Tidak Diketahui
                                            @endif
                                        </td>
                                        <td>{{ $item->urutan_pembimbing }}</td>
                                        <td>{{ $item->kategori_kegiatan }}</td>
                                        <td>
                                            <a href="{{ route('bimbingUji.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary btn-icon">
                                                <i class="btn-icon-prepend" data-feather="edit"></i>
                                            </a>
                                            <a href="{{ route('bimbingUji.show', $item->id) }}"
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class="btn-icon-prepend text-white" data-feather="eye"></i>
                                            </a>
                                            <form action="{{ route('bimbingUji.destroy', $item->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger btn-icon"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus aktivitas ini?');">
                                                    <i class="btn-icon-prepend" data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
