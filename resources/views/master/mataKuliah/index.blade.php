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
                                <a href="{{ url('/') }}">Dashboard</a>
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
                            <div class="card-body" style="margin-top: -2%">
                                <a href="{{ route('mataKuliah.create') }}" class="btn icon icon-left btn-primary"><i
                                        data-feather="user-plus"></i>
                                    Add Data</a>
                            </div>

                            <!-- table head dark -->
                            <div class="card-header table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th class="text-center">Program Studi</th>
                                            <th class="text-center">Kode Mata Kuliah</th>
                                            <th class="text-center">Nama Mata Kuliah</th>
                                            <th class="text-center">SKS</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @forelse ($users as $index => $user) --}}
                                        @php
                                            $nums = 1 + ($datas->currentPage() - 1) * $datas->perPage();
                                        @endphp
                                        @foreach ($datas as $matkul)
                                            <tr>
                                                <td class="text-bold-500">{{ $nums }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->nama_program_studi }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->kode_matakuliah }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->nama_matakuliah }}</td>
                                                <td class="text-center text-bold-500">{{ $matkul->sks }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('mataKuliah.show', $matkul->id) }}"
                                                        class="btn icon btn-primary" title="Detail"><i
                                                            class="bi bi-eye"></i></a>
                                                    <a href="{{ route('mataKuliah.edit', $matkul->id) }}"
                                                        class="btn icon btn-warning" title="Edit"><i
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
                            <nav aria-label="Page navigation example" style="margin-right: 2.5%">
                                <ul class="pagination pagination-primary justify-content-end">
                                    @if ($datas->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1"
                                                aria-disabled="true">Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $datas->previousPageUrl() }}"
                                                tabindex="-1">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($datas->getUrlRange(1, $datas->lastPage()) as $page => $url)
                                        @if ($page == $datas->currentPage())
                                            <li class="page-item active">
                                                <a class="page-link" href="#">{{ $page }}</a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($datas->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $datas->nextPageUrl() }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" aria-disabled="true">Next</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Table head options end -->
    </div>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endsection
