@extends('layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Mata Kuliah</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Table</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Table head options start -->
        <section class="section">
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Table Data Mata Kuliah
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <a href="{{ route('mataKuliah.create') }}" class="btn icon icon-left btn-primary"><i data-feather="user-plus"></i>
                                    Add Data</a>
                            </div>

                            <!-- table head dark -->
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Program Studi</th>
                                            <th class="text-center">Kode Mata Kuliah</th>
                                            <th class="text-center">Nama Mata Kuliah</th>
                                            <th class="text-center">Sks</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @forelse ($users as $index => $user) --}}
                                        @foreach ($datas as $matkul)
                                            <tr>
                                                <td class="text-bold-500">{{ $nums }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->nama_program_studi }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->kode_matakuliah }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->nama_matakuliah }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->sks }}</td>
                                                <td class="text-center">
                                                    <a href="{{route('mataKuliah.show', $matkul->id)}}" class="btn icon btn-primary" title="Detail"><i
                                                            class="bi bi-eye"></i></a>
                                                    <a href="{{route('mataKuliah.edit', $matkul->id)}}" class="btn icon btn-warning" title="Edit"><i
                                                            class="bi bi-pencil-square"></i></a>
                                                    <form action="{{ route('mataKuliah.destroy', $matkul->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="return confirm('Konfirmasi hapus data?')"
                                                            class="btn icon btn-danger" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                                $nums++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="m-3 pagination pagination-primary">
                                {{ $users->links() }}
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Table head options end -->
    </div>
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