@extends('layouts.custom')

@section('title', 'Detail Prestasi')

@section('content')
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('prestasi.index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('prestasi.index') }}">
                <img style="height: 50px" src="{{ asset('assets/images/logo/logo.png') }}">
            </a>
        </div>
    </nav>

    <div class="card-header">
        <h4 class="card-title">Detail Prestasi Mahasiswa</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <dl class="row">
                    <dt class="col-sm-4">Program Studi</dt>
                    <dd class="col-sm-8">{{ $prestasi->programStudi->nama_program_studi }}</dd>

                    <dt class="col-sm-4">Mahasiswa</dt>
                    <dd class="col-sm-8">{{ $prestasi->mahasiswa->nim }} - {{ $prestasi->mahasiswa->nama }}</dd>

                    <dt class="col-sm-4">Nama Prestasi</dt>
                    <dd class="col-sm-8">{{ $prestasi->nama }}</dd>

                    <dt class="col-sm-4">Penyelenggara</dt>
                    <dd class="col-sm-8">{{ $prestasi->penyelenggara }}</dd>

                    <dt class="col-sm-4">Jenis Prestasi</dt>
                    <dd class="col-sm-8">
                        @switch($prestasi->jenis)
                            @case(1)
                                Sains
                            @break

                            @case(2)
                                Seni
                            @break

                            @case(3)
                                Olahraga
                            @break

                            @case(9)
                                Lainnya
                            @break

                            @default
                                Tidak Diketahui
                        @endswitch
                    </dd>

                    <dt class="col-sm-4">Tingkat Prestasi</dt>
                    <dd class="col-sm-8">
                        @switch($prestasi->tingkat)
                            @case(1)
                                Sekolah
                            @break

                            @case(2)
                                Kecamatan
                            @break

                            @case(3)
                                Kab/Kota
                            @break

                            @case(4)
                                Provinsi
                            @break

                            @case(5)
                                Nasional
                            @break

                            @case(6)
                                Internasional
                            @break

                            @case(7)
                                Regional
                            @break

                            @case(9)
                                Lainnya
                            @break

                            @default
                                Tidak Diketahui
                        @endswitch
                    </dd>

                    <dt class="col-sm-4">Peringkat</dt>
                    <dd class="col-sm-8">{{ $prestasi->peringkat }}</dd>

                    <dt class="col-sm-4">Tahun</dt>
                    <dd class="col-sm-8">{{ $prestasi->tahun }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
