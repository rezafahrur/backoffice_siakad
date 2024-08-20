@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Paket Matakuliah</h3>
                    <p class="text-subtitle text-muted">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, accusamus.
                    </p>
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
                                Table Data Paket Matakuliah
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <p>
                                    "Welcome to our web page showcasing the user data of our boarding house, where comfort
                                    and convenience come together in one place."
                                </p>
                                <a href="{{ route('paket-matakuliah.create') }}" class="btn icon icon-left btn-primary"><i
                                        data-feather="user-plus"></i>
                                    Add Data Paket Matakuliah</a>
                            </div>

                            <!-- table head dark -->
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Paket Matakuliah</th>
                                            <th>Program Studi</th>
                                            <th>Semester</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($paketMatakuliah as $index => $paketmatkul)
                                        <tr>
                                            <td class="text-bold-500">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $paketmatkul->nama_paket_matakuliah }}
                                            </td>
                                            <td class="text-bold-500">
                                                {{ $paketmatkul->programStudi->nama_program_studi }}
                                            </td>
                                            {{-- semester --}}
                                            <td class="text-bold-500">
                                                {{ $paketmatkul->semester }}
                                            </td>
                                            {{-- status --}}
                                            <td>
                                                <span class="badge {{ $paketmatkul->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $paketmatkul->status == '1' ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            
                                            
                                            <td>
                                                <a href="{{ url('/paket-matakuliah/show/'.$paketmatkul->id) }}" class="btn icon btn-primary" title="Detail"><i
                                                        class="bi bi-eye"></i></a>
                                                <a href="{{ url('/paket-matakuliah/edit/'.$paketmatkul->id) }}" class="btn icon btn-warning" title="Edit"><i
                                                        class="bi bi-pencil-square"></i></a>
                                                        <form action="{{ url('/paket-matakuliah/'.$paketmatkul->id) }}" method="post" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button onclick="return confirm('Konfirmasi hapus data ?')"
                                                                class="btn icon btn-danger" title="Delete"><i
                                                                    class="bi bi-trash"></i></button>
                                                        </form>

                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="m-3 pagination pagination-primary">
                                {{-- {{ $users->links() }} --}}
                            </div>
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



